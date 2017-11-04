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
    public static function wpri_create_form($title, $form) {?>
		<div class="container"><h1><?php echo $title ?> </h1></div>
	    	<div id="exTab1" class="container">
				<ul  class="nav nav-pills">
					<li class="active"><a href="#add" data-toggle="tab">Add</a>
					</li>
					<li><a href="#update" data-toggle="tab">Update</a>
					</li>
					<li><a href="#delete" data-toggle="tab">Delete</a>
			   	</ul>

	   			<div class="tab-content clearfix">
		   			<div class="tab-pane active" id="add">
		            	<h3>Content's background color is the same for the tab</h3>
		   			</div>
		   			<div class="tab-pane" id="update">
		            	<h3>We use the class nav-pills instead of nav-tabs which automatically creates a background color for the tab</h3>
		   			</div>
		            <div class="tab-pane" id="delete">
						 <?php
			 			WPRI_Form::wpri_form_from_array($form);
			 			?>
		   			</div>
	   			</div>
	     </div>
		<?php
	}

	public static function wpri_form_from_array($form) {
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
					</div>
				<?php } ?>
				<?php foreach ($group["actions"] as $action) {?>
					<button type="submit" name="action" value="<?php echo $action?>"> <?php echo $action?></button>
				<?php } ?>
			</form>
		</div>
	<?php }
}
