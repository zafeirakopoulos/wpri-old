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

	// // $name,$caption,$description,$cols,$rows
	// // an array of arrays, field=> value. Filled in if update
	// // $field = array(
	// // 	'title' => "title",
	// // 	'elements' => array(
	// // 		array(
	// // 			'caption' => "caption" ,
	// 			 'value'=> "",
	// // 			'type'=> "text"
	// // 		),
	// // 		array(
	// // 			'' => ,
	// // 		),
	// // 		array(
	// // 			'' => ,
	// // 		)
	// // 	),
	// // 	'actions' => array("add","remove","update")
	// // );

	public static function wpri_form_from_array($form) {
		?>
		<div class='container'>
			<?php
			foreach ($form["groups"] as $group) {?>
			</hr>
				<div class='row'>
				<div class='col-sm-12 form-group-title'> <?php echo $group["title"] ?> </div>
				<?php
				foreach ($group["elements"] as $element) {
					if ($element["type"]=="text"){?>
					<div class='row'>
						<div class='col-sm-3 form-element-caption'> <?php echo $element["caption"] ?></div>
						<div class='col-sm-3 form-element-value'>   <?php echo $element["value"]   ?></div>
					</div>
					<?php }
					elseif ($element["type"]=="radio"){?>
						<div class='row'>";
							<div class='col-sm-3 form-element-caption'> <?php echo $element["caption"] ?></div>
							<div class='col-sm-3 form-element-value'>   <?php echo $element["value"]   ?></div>
						</div>
					<?php }	?>
				<?php } ?>
				</div>
			<?php } ?>
		</div>
	<?php }


}
