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
    public static function wpri_create_form($form) {
		// WPRI_Form::wpri_form_handle_request($form);
		?>
		<div class="container"><h1><?php echo $form["title"] ?> </h1></div>
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
					foreach ($group["elements"] as $element) {?>
						<div class='row'>
						<?php
						if ($element["type"]=="text"){
							if (isset($element["all_locales"])!=true){ ?>
								<label class='col-sm-12 form-element-caption'> <?php echo $element["caption"] ?></label>
								<div class='col-sm-3 form-element-value'>
									<textarea id='<?php echo $element["name"]?>'
											  name='<?php echo $element["name"]?>'
											  cols='80>'
											  rows='3'>
										 <?php echo $element["value"]?>
									</textarea>
								</div>
						<?php }
							else{?>
								<label class='col-sm-12 form-element-caption'> <?php echo $element["caption"] ?></label>
								<?php
								foreach ($locales as $locale) {?>
									<label class='col-sm-6 form-element-caption'> <?php echo $locale["name"] ?></label>
									<div class='col-sm-6 form-element-value'>
										<textarea id='<?php echo $element["id"]?>'
												  name='<?php echo $element["name"].$locale["id"] ?>'
												  cols='80'
												  rows='3'>
											 <?php echo $element["value"]?>
										</textarea>
									</div>
								<?php
								}
							}
						}
						elseif ($element["type"]=="tinytext"){?>
							<textarea id='<?php echo $element["id"]?>'
									  name='<?php echo $element["name"].$locale["id"] ?>'
									  cols='40'
									  rows='1'>
								 <?php echo $element["value"]?>
							</textarea>
						<?php }
						elseif ($element["type"]=="radio"){?>
							<div class='col-sm-3 form-element-caption'> <?php echo $element["caption"] ?></div>
							<div class='col-sm-3 form-element-value'>   <?php echo $element["value"]   ?></div>
						<?php }
						elseif ($element["type"]=="multiple-select"){
							$relation = $element["relation"];
							// TODO Read the relation
							echo "<h3>".$element["caption"]."</h3>";
							?>
							<ul id='contnet-box'>
							<li> item </li>
							<li> other item </li>
							<li> yet another item </li>
							</ul>
							<script type="text/javascript">
								$("#contnet-box").sortable("widget"); 

							</script>
							<?php
							// $all_entries = array();
							// foreach ($element["table"] as $table) {
							// 	 $all_entries = $all_entries + WPRI_Database::get_all($table);
							// }
                            //
							// foreach ( $all_entries as $item ) {
							// 	echo "<div class='form-check'>";
							// 	echo "<label class='form-check-label'>";
							// 	echo "<input class='form-check-input' type='checkbox' name='ids[]' value='".$item->id."'>  ";
							// 	echo $item[$element["display_column"]];
							// 	echo "</label>";
							// 	echo "</div>";
							// }
						}
						elseif ($element["type"]=="select"){
							echo "<h3>".$element["caption"]."</h3>";
							echo "<select name='".$element["name"]."'>";
							$all_entries = array();
							foreach (WPRI_Database::get_all($element["table"]) as $dbitem) {
								if (isset($element["localized"])){
									 $display_name = WPRI_Database::get_localized($table,$dbitem["id"])[$table];
   								}
   								else{
									if (is_array($element["display_column"])){
										error_log($element["display_column"][0].$element["display_column"][1].$dbitem["id"]);

										$display_name = WPRI_Database::get_field($element["display_column"][0],$element["display_column"][1],$dbitem["id"]);
										error_log("display name:".$display_name);

									}else{
										$display_name = $dbitem[$element["display_column"]];
									}
   								}
								array_push($all_entries, array($dbitem,$display_name));
							}

							foreach ( $all_entries as $item ) {
								echo "<option name='".$item[0]["id"]."'>".$item[1]."</option>";
							}
							echo "</select>";
						}
						elseif ($element["type"]=="date") {
							echo "<h3>".$element["caption"]."</h3>";
							echo "<input type='date' name='".$element["name"]."'/>";
						}?>
						</div>
					 <?php }
				 } ?>
				<div class='col-sm-12 form-element-caption'>
					<button type="submit" class="btn btn-primary">Add</button>
				</div>
				<input type="hidden" name="type" value="add"/>
			</form>
			</div>
			<?php $all_entries = WPRI_Database::get_all($form["table_name"]);
			if (empty($all_entries)){
				echo "<h2>No entries yet.</h2>";
			}else{
				echo "<h2>Already existing:</h2>";
				echo "<ul class='list-group'>";
				foreach ( $all_entries as $item ) {
					echo "<li class='list-group-item'>".$item->name."</li>";

				 }
			  	 echo "</ul>";
			}
			  ?>
		</div>
	<?php }


	public static function wpri_form_delete($form) {
		$all_entries = WPRI_Database::get_all($form["table_name"]);
		if (empty($all_entries)){
			echo "<h2>No entries found. Nothing to delete.</h2>";
		}else{
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
	}

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
								<textarea id='<?php echo $element["name"]?>'
										  name='<?php echo $element["name"]?>'
										  cols='80'
										  rows='3'>
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
