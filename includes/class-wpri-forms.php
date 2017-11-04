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

	// $name,$caption,$description,$cols,$rows
	// an array of arrays, field=> value. Filled in if update
	// $field = array(
	// 	'title' => "title",
	// 	'elements' => array(
	// 		array(
	// 			'caption' => "caption" ,
	// 			'type'=> "text"
	// 		),
	// 		array(
	// 			'' => ,
	// 		),
	// 		array(
	// 			'' => ,
	// 		)
	// 	),
	// 	'actions' => array("add","remove","update")
	// );

	public function wpri_form_group($group) {
		?>
		<div class='row'>";
	   	<h2> <?php echo $group["title"]?> </h2>
		</div>
		<?php
	}

	public function wpri_text_field($field) {
	?>
			<h2>Undergraduate</h2>
			<table class="form-table">
			<tr>
			<th><label>Institution</label></th>
			<td><textarea id="bs_inst" name="bs_inst" cols="70" rows="1"></textarea>
			<span class="description">Write uni/dept name.</span>
			</td></tr>
			<tr>
			<th><label>Year</label></th>
			<td><textarea id="bs_year" name="bs_year" cols="4" rows="1"></textarea>
			<span class="description">Graduation year</span>
			</td></tr>
			<tr>
			</table>
	<?php
	 }

}
