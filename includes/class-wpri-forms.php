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
		WPRI_Form::wpri_form_handle_request($form);
		?>
		<div class="container"><h1><?php echo $form["title"] ?> </h1></div>
	    	<div id="exTab1" class="container">
				<ul  class="nav nav-pills">
					<li  class="active"><a href="#show" data-toggle="tab">Existing</a></li>
					<li><a href="#add" data-toggle="tab">Add New</a></li>
			   	</ul>

	   			<div class="tab-content clearfix">
					<div class="tab-pane active" id="show">
						<?php
						WPRI_Form::wpri_form_show_existing($form);
					   ?>
					</div>
		   			<div class="tab-pane" id="update">
						<?php
					    WPRI_Form::wpri_form_update($form);
					   ?>
		   			</div>
					<div class="tab-pane" id="add">
						<?php
					    WPRI_Form::wpri_form_add($form);
					   ?>
		   			</div>
			 	</div>
			</div>
		<?php
	}

	public static function wpri_form_handle_request($entity) {
		$locales= WPRI_Database::get_locales();

		// If POST for adding
		if( isset( $_POST['type']) && $_POST['type'] == 'add') {
			$to_add = array();
			$plain = array();
			$local = array();
			$relations = array();
			$multiplerelations = array();

			foreach ($entity["groups"] as $group ) {
				foreach ($group["elements"] as $element ) {
					if (isset($element["localized"]) ){
						$localized =array();
						foreach ($locales as $locale) {
							$localized[$locale["id"]] = $_POST[$element["name"].$locale["id"]] ;
						}
						$local[$element["name"]] = $localized;
					}
					elseif ($element["type"]== "multiple-select"){
						$relation = $element["relation"];
						if (isset($relation["select"])) {
							$tmp = array();
							$all_options = WPRI_Database::get_all($relation["select"]["table"]);
							foreach ($all_options as $option){
                                if ($_POST[$element["name"].$option["id"]]!=NULL){
                                    array_push($tmp, array( $relation["select"]["table"] => $option["id"], $relation["foreach"]["table"] => $_POST[$element["name"].$option["id"]] ));                                    
                                }
							}
							$multiplerelations[$element["name"]] = $tmp;
						} else {
							$relations[$element["name"]] =  array( $relation["foreach"]["table"] => $_POST[$element["name"].$option["id"]] );
						}
					} elseif ($element["type"]== "select"){
						$relations[$element["name"]] =  $_POST[$element["name"]] ;
					} else{
						$plain[$element["name"]] = $_POST[$element["name"]];
					}
				}
			}

			$to_add["plain"]=$plain;
			$to_add["relations"]=$relations;
			$to_add["multirelations"]=$multiplerelations;
			$to_add["localized"]=$local;
			$success = WPRI_Database::add_form($entity,$to_add);
			if($success ) {
				echo "<div class='updated'><p><strong>Added.</strong></p></div>";
			} else {
				echo "<div class='error'><p>Unable to add.</p></div>";
			}
		}
		if( isset( $_POST['type']) && $_POST['type'] == 'update') {

		}
		if( isset( $_POST['delete_button'])) {
			$success = WPRI_Database::delete_record($_POST["id"],$entity);
			if($success ) {
				echo "<div class='updated'><p><strong>Deleted.</strong></p></div>";
			} else {
				echo "<div class='error'><p>Unable to delete.</p></div>";
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
					foreach ($group["elements"] as $element) {?>
						<div class='row'>
						<?php
						if ($element["type"]=="text"){
							if (isset($element["all_locales"])!=true){
								if (isset($element["localized"])){
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
			 					}else{ ?>
								<label class='col-sm-12 form-element-caption'> <?php echo $element["caption"] ?></label>
								<div class='col-sm-3 form-element-value'>
									<textarea id='<?php echo $element["name"]?>'
											  name='<?php echo $element["name"]?>'
											  cols='80>'
											  rows='3'>
										 <?php echo $element["value"]?>
									</textarea>
								</div>
							<?php
								}
							}
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
 							echo "<h3>".$element["caption"]."</h3>";
 							$all_entries = WPRI_Database::get_all($relation["foreach"]["table"]);
							?>
							<ul id="input<?php echo $element["name"]?>" class="list-group">
								<?php
								foreach ( $all_entries as $item ) {
									echo "<li
										class='list-group-item' optionname='".$item["id"]."'>
										<span class='glyphicon glyphicon-move' aria-hidden='true'></span>".	$item[$relation["foreach"]["display_column"]]."</li>";
								}
								?>
							</ul>
							<?php

								if (isset($relation["select"]["table"])){
									$all_options = WPRI_Database::get_all($relation["select"]["table"]);
									foreach ($all_options as $option){
										echo "<div>".$option[$relation["select"]["display_column"]];
										echo "<ul id='output".$element["name"].$option["id"]."' class='list-group' style='min-height:100px'></ul>";
										echo "</div>";
										echo "<input type='hidden' name='".$element["name"].$option["id"]."' id='".$element["name"].$option["id"]."'/>";
									}
								} else {
									echo "<div> Selected:";
									echo "<ul id='output".$element["name"]."' class='list-group' style='min-height:100px'></ul>";
									echo "</div>";
									echo "<input type='hidden' name='".$element["name"]."' id='".$element["name"]."'/>";
								}
							?>
 							<script>
 								var input = document.getElementById('input<?php echo $element["name"]?>');
							    Sortable.create(input,{sort:true,
									dataIdAttr: "optionname",
									group:"<?php echo $element["name"]?>"});
								<?php
									if (isset($relation["select"]["table"])){
										foreach ($all_options as $option){
											echo "var output = document.getElementById('output".$element["name"].$option["id"]."');";
											echo "
										    Sortable.create(output,{sort:true,
												dataIdAttr: 'optionname',
												group:'".$element["name"]."',
												onAdd: function(event) {
													var order = this.toArray();
													var inputel = document.getElementById('".$element["name"].$option["id"]."');
													inputel.setAttribute('value', order.reduce(function(a,b){if(a.indexOf(b)<0)a.push(b);return a;},[]));
													console.log(inputel);
											  	},
												onRemove: function (event) {
														var order = this.toArray();
														var inputel = document.getElementById('".$element["name"].$option["id"]."');
														inputel.setAttribute('value', order.reduce(function(a,b){if(a.indexOf(b)<0)a.push(b);return a;},[]));
														console.log(inputel);
												},
												onMove:
												function(event, ui) {
													var order = this.toArray();
													var inputel = document.getElementById('".$element["name"].$option["id"]."');
													inputel.setAttribute('value', order.reduce(function(a,b){if(a.indexOf(b)<0)a.push(b);return a;},[]));
													console.log(inputel);
												}
												});
											";
										}
									} else {
										echo "var output = document.getElementById('output".$element["name"]."');";
										echo "
										Sortable.create(output,{sort:true,
											dataIdAttr: 'optionname',
											group:'".$element["name"]."',
											onAdd: function(event) {
												var order = this.toArray();
												var inputel = document.getElementById('".$element["name"]."');
												inputel.setAttribute('value', order.reduce(function(a,b){if(a.indexOf(b)<0)a.push(b);return a;},[]));
												console.log(inputel);
											},
											onRemove: function (event) {
													var order = this.toArray();
													var inputel = document.getElementById('".$element["name"]."');
													inputel.setAttribute('value', order.reduce(function(a,b){if(a.indexOf(b)<0)a.push(b);return a;},[]));
													console.log(inputel);
											},
											onMove:
											function(event, ui) {
												var order = this.toArray();
												var inputel = document.getElementById('".$element["name"]."');
												inputel.setAttribute('value', order.reduce(function(a,b){if(a.indexOf(b)<0)a.push(b);return a;},[]));
												console.log(inputel);
											}
											});
										";
									}
								?>
							</script>
							<?php

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
		</div>
	<?php }


	public static function wpri_form_delete($form) {
		$all_entries = WPRI_Database::get_all($form["table_name"]);
		if (empty($all_entries)){
			echo "<h2>No entries found.</h2>";
		}else{
		?>
		<form name='id' method="post" action="">
				  <?php foreach ( $all_entries as $item ) {
					  echo "<div class='form-check'>";
					  echo "<label class='form-check-label'>";
					  echo "<input class='form-check-input' type='checkbox' name='ids[]' value='".$item["id"]."'>  ";
					  echo $item[$form["display_element"]];
					  echo "</label>";
					  echo "</div>";
  			  } ?>
			<button type="submit" class="btn btn-primary">Delete selected</button>
			<input type="hidden" name="type" value="delete"/>
		</form>
	<?php }
	}

	public static function wpri_form_show_existing($form) {
		$all_entries = WPRI_Database::get_all($form["table_name"]);
		if (empty($all_entries)){
			echo "<h2>No entries found.</h2>";
		}else{
		?>
			<ul>

				  <?php
				  	foreach ( $all_entries as $item ) {
					  echo "<li>";
					  echo "<form name='id' method='post' action=''>";
					  echo $item[$form["display_element"]];
					  echo "<input type='submit' name='delete_button' value='Delete' class='btn btn-primary' /> ";
					  echo "<input type='submit' name='update_button' value='Update' class='btn btn-primary' /> ";
					  // echo '<input type="hidden" name="type" value="delete" />';
					  echo '<input type="hidden" name="id" value="'.$item["id"].'"/>';
					  echo "</form>";
					  echo "</li>";
  			  		}
				 ?>
		  	</ul>
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
