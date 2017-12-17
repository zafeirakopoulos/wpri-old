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
					<li  <?php echo ( isset( $_POST['update_button'])? "" : "class='active'") ?>><a href="#show" data-toggle="tab">Existing</a></li>
					<li  <?php echo ( isset( $_POST['update_button'])? "class='active'" : "") ?>><a href="#add_update" data-toggle="tab">Add</a></li>
			   	</ul>

	   			<div class="tab-content clearfix">
					<?php echo "<div class='tab-pane ".( isset($_POST["update_button"]) ? "": "active")."' id='show'>";?>
						<?php
						WPRI_Form::wpri_form_show_existing($form);
					   ?>
					</div>
                    <?php echo "<div class='tab-pane ".( isset($_POST["update_button"]) ?  "active": "")."' id='add_update'>";?>
						<?php
					    WPRI_Form::wpri_form_add_update($form);
					   ?>
		   			</div>
			 	</div>
			</div>
		<?php
	}

	public static function wpri_form_handle_request($entity) {
		$locales= WPRI_Database::get_locales();

		// If POST for adding
		if( isset( $_POST['type']) && ($_POST['type'] == 'add' || $_POST['type'] == 'update'))  {
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

                                    $tmptmp = explode(",", $_POST[$element["name"].$option["id"]]);
                                     if (is_array($tmp)){
                                        array_push($tmp, array(  $relation["foreach"]["table"] => $tmptmp,$relation["select"]["table"] => $option["id"] ));
                                    }
                                    else{
                                        array_push($tmp, array(  $relation["foreach"]["table"] => array($tmptmp),$relation["select"]["table"] => $option["id"] ));
                                    }

                                }
							}
                            if (empty($tmp)!=1){
                                $multiplerelations[$element["name"]] = $tmp;
                            }
						} else {
                            if (empty($_POST[$element["name"]])!=1) {
                                $tmp = explode(",", $_POST[$element["name"]]);
                                if (is_array($tmp)){
                                    $relations[$relation["foreach"]["table"]] = $tmp;
                                }
                                else{
                                    $relations[$relation["foreach"]["table"]] = array($tmp) ;
                                }
                            }
						}
					} elseif ($element["type"]== "select"){
                        if (empty($_POST[$element["name"]] )!=1){
                            $plain[$element["name"]] =  $_POST[$element["name"]] ;
                        }
					} else{
						$plain[$element["name"]] = $_POST[$element["name"]];
					}
				}
			}

			$to_add["plain"]=$plain;
			$to_add["relations"]=$relations;
			$to_add["multirelations"]=$multiplerelations;
			$to_add["localized"]=$local;

              if($_POST['type'] == 'add'){
                $success = WPRI_Database::add_form($entity,$to_add);
              }
              elseif($_POST['type'] == 'update'){
                $success = WPRI_Database::update_form($_POST['id'],$entity,$to_add);
              }

			if($success ) {
                if($_POST['type'] == 'add'){
                    echo "<div class='updated'><p><strong>Added.</strong></p></div>";
                }
                elseif($_POST['type'] == 'update'){
                    echo "<div class='updated'><p><strong>Updated.</strong></p></div>";
                }
			} else {
                if($_POST['type'] == 'add'){
                    echo "<div class='error'><p>Unable to add.</p></div>";
                }
                elseif($_POST['type'] == 'update'){
                    echo "<div class='error'><p>Unable to update.</p></div>";
                }
			}
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

	public static function wpri_form_add_update($form) {

        $update = false;
        if (isset($_POST["update_button"]) ){
            $update = true;
            $form = WPRI_Database:: get_entity_with_data($form["name"],$_POST["id"]);
        }

		$locales= WPRI_Database::get_locales();
		?>
		<div>
			<div class='row'>
			<form name='<?php echo $form["name"]?>' method="post" action="">
                <!-- Entity title -->
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
										<label class='col-sm-12 form-element-caption'> <?php echo $locale["locale"] ?></label>
										<div class='col-sm-12 form-element-value'>
											<textarea id='<?php echo $element["name"]?>'
													  name='<?php echo $element["name"].$locale["id"] ?>'
													  cols='80'
													  rows='3'>
                                                      <?php echo ( isset($element["data"]) ? $element["data"][$locale["id"]] : $element["value"] ) ?>
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
                                              <?php echo ( isset($element["data"]) ? $element["data"] : $element["value"] ) ?>
									</textarea>
								</div>
							<?php
								}
							}
							else{?>
								<label class='col-sm-12 form-element-caption'> <?php echo $element["caption"] ?></label>
								<?php
								foreach ($locales as $locale) {?>
									<label class='col-sm-12 form-element-caption'> <?php echo $locale["name"] ?></label>
									<div class='col-sm-12 form-element-value'>
										<textarea id='<?php echo $element["id"]?>'
												  name='<?php echo $element["name"].$locale["id"] ?>'
												  cols='80'
												  rows='3'>
                                                  <?php echo ( isset($element["data"]) ? $element["data"][$locale["id"]] : $element["value"] ) ?>
										</textarea>
									</div>
								<?php
								}
							}
						}
						elseif ($element["type"]=="tinytext"){?>
                            <label class='col-sm-12 form-element-caption'> <?php echo $element["caption"] ?></label>
							<textarea id='<?php echo $element["name"]?>'
									  name='<?php echo $element["name"] ?>'
									  cols='40'
									  rows='1'>
                                      <?php echo ( isset($element["data"]) ? $element["data"] : $element["value"] ) ?>
							</textarea>
						<?php }
						elseif ($element["type"]=="INT"){?>
                            <label class='col-sm-12 form-element-caption'> <?php echo $element["caption"] ?></label>
                            <textarea id='<?php echo $element["name"]?>'
                                      name='<?php echo $element["name"] ?>'
                                      cols='12'
                                      rows='1'>
                                      <?php echo ( isset($element["data"]) ? $element["data"] : $element["value"] ) ?>
                            </textarea>
						<?php }
						elseif ($element["type"]=="multiple-select"){
							$relation = $element["relation"];
 							echo "<h3>".$element["caption"]."</h3>";
 							$all_entries = WPRI_Database::get_all($relation["foreach"]["table"]);
							?>
							<ul id="input<?php echo $element["name"]?>" class="list-group">
								<?php
								 // foreach ( $all_entries as $item ) {
                                //     if ( !isset($element["data"]) || !in_array( $item["id"],$element["data"])){
    							// 		echo "<li
    							// 			class='list-group-item' optionname='".$item["id"]."'>
    							// 			<span class='glyphicon glyphicon-move' aria-hidden='true'></span>".	$item[$relation["foreach"]["display_column"]]."</li>";
    							// 	}
// }

                                if (isset($relation["select"]["table"])){
                                    // $ids_to_add = array();
                                    // foreach ($all_options as $option){
                                    //     array_push($ids_to_add, $option["id"] => array());
                                    // }
                                    $all_options = WPRI_Database::get_all($relation["select"]["table"]);
                                    foreach ($all_options as $option){
                                          if ( isset($element["data"])){
                                             foreach ( $all_entries as $item ) {
                                                 foreach ( $element["data"] as $dato) {
                                                     if (!( $item["id"]==$dato[$relation["foreach"]["table"]] &&  $option["id"]==$dato[$relation["select"]["table"]])){
                                                       echo "<li
                                                           class='list-group-item' optionname='".$item["id"]."'>
                                                           <span class='glyphicon glyphicon-move' aria-hidden='true'></span>".	$item[$relation["foreach"]["display_column"]]."</li>";
                                                     }
                                                }
                                            }
                                        } else{
                                            echo "<li
                                                class='list-group-item' optionname='".$item["id"]."'>
                                                <span class='glyphicon glyphicon-move' aria-hidden='true'></span>".	$item[$relation["foreach"]["display_column"]]."</li>";
                                          }

                                     }
                                } else {
                                      foreach ( $all_entries as $item ) {
                                         if ( isset($element["data"])) {
                                             if (!in_array( $item["id"],$element["data"])){
                                             echo "<li
                                                 class='list-group-item' optionname='".$item["id"]."'>
                                                 <span class='glyphicon glyphicon-move' aria-hidden='true'></span>".	$item[$relation["foreach"]["display_column"]]."</li>";
                                             }
                                         }
                                         else{
                                            echo "<li
                                                class='list-group-item' optionname='".$item["id"]."'>
                                                <span class='glyphicon glyphicon-move' aria-hidden='true'></span>".	$item[$relation["foreach"]["display_column"]]."</li>";
                                          }

                                    }
                                 }

								?>
							</ul>
							<?php




								if (isset($relation["select"]["table"])){
									$all_options = WPRI_Database::get_all($relation["select"]["table"]);
									foreach ($all_options as $option){
										echo "<div>".$option[$relation["select"]["display_column"]];
										echo "<ul id='output".$element["name"].$option["id"]."' class='list-group' style='min-height:100px'>";
                                         if ( isset($element["data"])){
                                             foreach ( $all_entries as $item ) {
                                                 foreach ( $element["data"] as $dato) {
                                                     if ( $item["id"]==$dato[$relation["foreach"]["table"]] &&  $option["id"]==$dato[$relation["select"]["table"]]){
                                                       echo "<li
                                                           class='list-group-item' optionname='".$item["id"]."'>
                                                           <span class='glyphicon glyphicon-move' aria-hidden='true'></span>".	$item[$relation["foreach"]["display_column"]]."</li>";
                                                     }
                                                }
                                            }
                                         }
                                        echo "</ul>";
										echo "</div>";
										echo "<input type='hidden' name='".$element["name"].$option["id"]."' id='".$element["name"].$option["id"]."'/>";
									}
								} else {
									echo "<div> Selected:";
									echo "<ul id='output".$element["name"]."' class='list-group' style='min-height:100px'>";
                                     foreach ( $all_entries as $item ) {
                                         if ( isset($element["data"]) && in_array( $item["id"],$element["data"])){
        									echo "<li
        										class='list-group-item' optionname='".$item["id"]."'>
        										<span class='glyphicon glyphicon-move' aria-hidden='true'></span>".	$item[$relation["foreach"]["display_column"]]."</li>";
        								}
                                    }
                                    echo "</ul>";
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
										$display_name = WPRI_Database::get_field($element["display_column"][0],$element["display_column"][1],$dbitem["id"]);

									}else{
										$display_name = $dbitem[$element["display_column"]];
									}
   								}
								array_push($all_entries, array($dbitem,$display_name));
							}

							foreach ( $all_entries as $item ) {
                                if ( isset($element["data"]) && $item[0]["id"]==$element["data"]) {
                                    echo "<option selected name='".$item[0]["id"]."' value='".$item[0]["id"]."'>".$item[1]."</option>";
                                }
                                else{
                                    echo "<option name='".$item[0]["id"]."' value='".$item[0]["id"]."'>".$item[1]."</option>";
                                }
							}
							echo "</select>";
						}
						elseif ($element["type"]=="datetime") {
							echo "<h3>".$element["caption"]."</h3>";
                            $thedate = ( isset($element["data"]) ? date('Y-m-d', strtotime($element["data"])) : "");
							echo "<input type='date' name='".$element["name"]."' value='".$thedate."'/>";

						}?>
						</div>
					 <?php }
				 } ?>

         <?php if( isset( $_POST['update_button']))
         {
          ?>
          <div class='col-sm-12 form-element-caption'>
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
          <input type="hidden" name="id" value="<?php echo $_POST["id"]?>"/>
          <input type="hidden" name="type" value="update"/>
        <?php
      } else {?>
				<div class='col-sm-12 form-element-caption'>
					<button type="submit" class="btn btn-primary">Add</button>
				</div>
				<input type="hidden" name="type" value="add"/>
        <?php
      } ?>
			</form>
			</div>
		</div>
	<?php }


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
					  echo $item[$form["display_element"]];
                      echo "<form name='id' method='post' action=''>";
					  echo "<input type='submit' name='delete_button' value='Delete' class='btn btn-primary' /> ";
					  echo '<input type="hidden" name="id" value="'.$item["id"].'"/>';
					  echo "</form>";
                      echo "<form name='id' method='post' action='#add_update'>";
					  echo "<input type='submit' name='update_button' value='Update' class='btn btn-primary' /> ";
					  echo '<input type="hidden" name="id" value="'.$item["id"].'"/>';
					  echo "</form>";
					  echo "</li>";
  			  		}
				 ?>
		  	</ul>
	<?php }
	}

}
