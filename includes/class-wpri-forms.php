<?php

/**
 * The forms functionality of the plugin.
  *
  * @link       http://example.com
  * @since      1.0.0
  *
  * @package    wpri
  * @subpackage wpri/includes
  */

 /**
 * The forms functionality of the plugin.
  *
  * The forms functionality of the plugin.
  *
  * @since      1.0.0
  * @package    wpri
  * @subpackage wpri/includes
  * @author     Zafeirakis Zafeirakopoulos
  */
class WPRI_Form {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
    public static function wpri_create_form($title, $form) {
		// WPRI_Form::wpri_form_handle_request($form);
		?>
		<div class="container"><h1><?php echo $title ?> </h1></div>
	    	<div id="exTab1" class="container">
				<ul  class="nav nav-pills">
					<li class="active"><a href="#add" data-toggle="tab">Add New</a>
					</li>
					<li><a href="#update" data-toggle="tab">Update Existing</a>
					</li>
					<li><a href="#delete" data-toggle="tab">Delete Existing</a>
			   	</ul>

	   			<div class="tab-content clearfix">
		   			<div class="tab-pane active" id="add">
						<?php
					    WPRI_Form::wpri_form_add($form);
					   ?>
		   			</div>
		   			<div class="tab-pane" id="update">
						<?php
					    WPRI_Form::wpri_form_update($form);
					   ?>
		   			</div>
					<div class="tab-pane" id="delete">
						<?php
					    WPRI_Form::wpri_form_delete($form);
					   ?>
		   			</div>
			 	</div>
			</div>
		<?php
	}

	public static function wpri_form_handle_request($form) {


		// If POST for adding
		if( isset( $_POST['type']) && $_POST['type'] == 'add_' . $setting_name ) {

			$GLOBALS['wpdb']->insert( $table_name , array( 'name' => $_POST["setting_name"] ) );
			echo $GLOBALS['wpdb']->insert_id ;
			$new_id = $GLOBALS['wpdb']->insert_id;
			if($GLOBALS['wpdb']->insert_id) {
				?>
			<div class="updated"><p><strong>Added.</strong></p></div>
				<?php
			} else {
				?>
			<div class="error"><p>Unable to add.</p></div>
			<?php
			}
			foreach ( $locales as $locale ) {
				$GLOBALS['wpdb']->insert( $mixed_table_name , array(
					'locale' => $locale->id,
					$setting_name => $new_id,
					'name' => $_POST["setting_name_" . $locale->id],
				));
			}

		}

		// If POST for deleting
		if( isset( $_POST['type']) && $_POST['type'] == 'delete_' . $setting_name ) {
			foreach ( $locales as $locale ) {
				$GLOBALS['wpdb']->query( $GLOBALS['wpdb']->prepare(
					"DELETE FROM $mixed_table_name WHERE $setting_name = %d", $_POST['setting_id']
				));
			}
			$result = $GLOBALS['wpdb']->query( $GLOBALS['wpdb']->prepare(
				"DELETE FROM " . $table_name . " WHERE id = %d", $_POST['setting_id']
				));
			if($result) {
				?>
			<div class="updated"><p><strong>Deleted.</strong></p></div>
				<?php
			} else {
				?>
			<div class="error"><p>Unable to delete.</p></div>
			<?php
			}
		}
	}

	public static function wpri_form_add($form) {
		$locales= WPRI_Database::get_locales();
		?>
		<div>
			<div class='row'>
			<form name='<?php echo $form["name"]?>' method="post" action="">
				<div class='col-sm-12 form-title'> <?php echo $form["title"] ?> </div>
				<?php
				foreach ($form["groups"] as $group) {?>
					<hr/>
					<div class='col-sm-12 form-group-title'> <?php echo $group["title"] ?> </div>
					<?php
					foreach ($group["elements"] as $element) {

						if ($element["type"]=="text"){
							if ($element["all_locales"]!=1){ ?>
								<label class='col-sm-3 form-element-caption'> <?php echo $element["caption"] ?></label>
								<div class='col-sm-3 form-element-value'>
									<textarea id='<?php echo $element["id"]?>'
											  name='<?php echo $element["name"]?>'
											  cols='<?php echo $element["cols"]?>'
											  rows='<?php echo $element["rows"]?>'>
										 <?php echo $element["value"]?>
									</textarea>
								</div>
						<?php }
							else{
								echo "<label class='col-sm-3 form-element-caption'>".$element['caption']."</label>";
								foreach ($locales as $locale) {?>
									<label class='col-sm-6 form-element-caption'> <?php echo $locale["name"] ?></label>
									<div class='col-sm-6 form-element-value'>
										<textarea id='<?php echo $element["id"]?>'
												  name='<?php echo $element["name"].$locale["id"] ?>'
												  cols='<?php echo $element["cols"]?>'
												  rows='<?php echo $element["rows"]?>'>
											 <?php echo $element["value"]?>
										</textarea>
									</div>
								<?php
								}
							}
						}
						elseif ($element["type"]=="radio"){?>
							<div class='col-sm-3 form-element-caption'> <?php echo $element["caption"] ?></div>
							<div class='col-sm-3 form-element-value'>   <?php echo $element["value"]   ?></div>
						<?php }
						elseif ($element["type"]=="multiple-select"){
							echo "<h3>".$element["caption"]."/</h3>";
							$all_entries = WPRI_Database::get_all($element["source_table"]);
							foreach ( $all_entries as $item ) {
								echo "<div class='form-check'>";
								echo "<label class='form-check-label'>";
								echo "<input class='form-check-input' type='checkbox' name='ids[]' value='".$item->id."'>  ";
								echo $item[$element["display_column"]];
								echo "</label>";
								echo "</div>";
							}
						}
					 }
				 } ?>
				<div class='col-sm-12 form-element-caption'>
					<button type="submit" class="btn btn-primary">Add</button>
				</div>
				<input type="hidden" name="type" value="add"/>
			</form>
			</div>
			<?php $all_entries = WPRI_Database::get_all($form["table_name"]);
			echo "<h2>Already existing:</h2>";
			echo "<ul class='list-group'>";
			foreach ( $all_entries as $item ) {
				echo "<li class='list-group-item'>".$item->name."</li>";

			 }
		  	 echo "</ul>";
			  ?>
		</div>
	<?php }


	public static function wpri_form_delete($form) {
		$all_entries = WPRI_Database::get_all($form["table_name"]);
		?>
		<form name='id' method="post" action="">
				  <?php foreach ( $all_entries as $item ) {
					  echo "<div class='form-check'>";
					  echo "<label class='form-check-label'>";
					  echo "<input class='form-check-input' type='checkbox' name='ids[]' value='".$item->id."'>  ";
					  echo $item->name;
					  echo "</label>";
					  echo "</div>";
  			  } ?>
			<button type="submit" class="btn btn-primary">Delete selected</button>
			<input type="hidden" name="type" value="delete"/>
		</form>
	<?php }

	public static function wpri_form_update($form) {
		?>
		<div>
			<div class='row'>
			<form name='<?php echo $form["name"]?>' method="post" action="">
				<div class='col-sm-12 form-title'> <?php echo $form["title"] ?> </div>
				<?php
				foreach ($form["groups"] as $group) {?>
					<hr/>
					<div class='col-sm-12 form-group-title'> <?php echo $group["title"] ?> </div>
					<?php
					foreach ($group["elements"] as $element) {
						if ($element["type"]=="text"){?>
							<label class='col-sm-3 form-element-caption'> <?php echo $element["caption"] ?></label>
							<div class='col-sm-3 form-element-value'>
								<textarea id='<?php echo $element["id"]?>'
										  name='<?php echo $element["name"]?>'
										  cols='<?php echo $element["cols"]?>'
										  rows='<?php echo $element["rows"]?>'>
									 <?php echo $element["value"]?>
								</textarea>
							</div>
						<?php }
						elseif ($element["type"]=="radio"){?>
							<div class='col-sm-3 form-element-caption'> <?php echo $element["caption"] ?></div>
							<div class='col-sm-3 form-element-value'>   <?php echo $element["value"]   ?></div>
						<?php }	?>
					<?php } ?>
				<?php } ?>
				<button type="submit" name="action" value="add">Add</button>
			</form>
		</div>
	</div>
	<?php }
}
