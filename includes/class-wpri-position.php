<?php

/**
 * Functionality about open positions management.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    wpri
 * @subpackage wpri/includes
 */

/**
 * Functionality about open positions management.
 *
 * Functionality about open positions management.
 *
 * @since      1.0.0
 * @package    wpri
 * @subpackage wpri/includes
 * @author     Zafeirakis Zafeirakopoulos
 */
class WPRI_Position {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */

	public function position_menu() {

			function wpri_position_management() {
				$locales  = WPRI_Database::get_locales();
				$members  = WPRI_Database::get_all_members();
				$agencies = WPRI_Database::get_agencies();
				$positions  = WPRI_Database::get_all_open_positions();

				echo '<div class="wrap">';
				echo '<h2>Manage Open Positions</h2>';
				echo '<div class="wrap wpa">';


				// If POST for deleting
				if( isset( $_POST['type']) && $_POST['type'] == 'delete_position') {
					$success = WPRI_Database::delete_open_position($_POST['position_id']);
					if($success) {
						echo "<div class='updated'><p><strong>Deleted.</strong></p></div>";
					} else {
				    	echo "<div class='error'><p>Unable to delete.</p></div>";
					}
				}

				echo '<h3> Open Positions: </h3>';
				echo '<table>';
			 	foreach ( $positions as $position) {
					echo '<form name="delete_position" method="post" action="">';
					echo '<tr>';
					echo '<td><label>' . $position->title . ': </label></td>';
					echo '<td> <input type="submit" name="delete_button' . $position->id  . '" value="Delete" class="button" />';
			    	echo '<input type="hidden" name="type" value="delete_position" />';
			   		echo '<input type="hidden" name="position_id" value=' . $position->id . '/></td>';
					echo '</tr>';
					echo '</form>';
			    }
				echo '</table>';
				echo '</div>';
				echo '</div>';
			}
			add_menu_page( 'Positions', 'Open Positions', 'read', 'wpri-position-menu','wpri_position_management');

			function wpri_position_add_management() {
				$locales  = WPRI_Database::get_locales();
				$members  = WPRI_Database::get_all_members();
				$agencies = WPRI_Database::get_agencies();


				echo '<div class="wrap">';
				echo '<h2>Add new open position</h2>';
				echo '<div class="wrap wpa">';

				// If POST for adding
				if( isset( $_POST['type']) && $_POST['type'] == 'add_position') {
					$position = array(
						'title' => $_POST["title"],
						'type' => $_POST["position_type"],
						'startdate' => $_POST["startdate"],
						'enddate' => $_POST["enddate"],
						'agency' => $_POST["funding"],
						'description' => $_POST["description"],
						'deadline' => $_POST["deadline"]
					);
					$success = WPRI_Database::add_open_position($position);

					// Returns the new id. 0 on fail.
					if($success ) {
						foreach ($_POST["members"] as $member) {
							WPRI_Database::add_open_position_contact($member,$success);
						}
						foreach ($_POST["projects"] as $project) {
							WPRI_Database::add_open_position_project($project,$success);
						}
						foreach ($_POST["requirements"] as $requirement) {
							WPRI_Database::add_open_position_requirement($requirement,$success);
						}

						echo "<div class='updated'><p><strong>Added.</strong></p></div>";
					} else {
						echo "<div class='error'><p>Unable to add.</p></div>";
					}
				}

				echo '<h3> Add new open position: </h3>';

				$positiontypes = WPRI_Database::get_positions();

			 	echo '<form name="add_position" method="post" action="">';
				echo '<table class="form-table">';
				echo '<tr>';
				echo '<th><label for="position_type">Type</label></th>';
				echo '<td><select name="position_type">';
					foreach ( $positiontypes  as $positiontype ) {
						echo '<option value='.$positiontype->id.'>'.$positiontype->name.'</option>';
					}
				echo '</select>';
				echo '<span class="description">Please enter position type.</span>';
				echo '</td></tr>';

				$projects = WPRI_Database::get_all_projects();

				echo '<tr>';
				echo '<th><label for="projects[]">Projects related to the open position</label></th>';
				echo '<td><select size="4" multiple="multiple" name="projects[]">';
					foreach ( $projects as $project ) {
					echo '<option value='.$project->id.'>'.$project->title.'</option>';
					}
				echo '</select>';
				echo '<span class="description">Choose related projects.</span>';
				echo '</td></tr>';

				echo '</td></tr>';
				echo '<tr>';
				echo '<th><label for="title">Title</label></th>';
				echo '<td><textarea id="title" name="title" cols="70" rows="2"></textarea>';
				echo '<span class="description">140 characters.</span>';
				echo '</td></tr>';


				$agencies = WPRI_Database::get_agencies();

				echo '<tr>';
				echo '<th><label for="funding">Funding agency</label></th>';
				echo '<td><select name="funding">';
					foreach ( $agencies as $agency ) {
						echo '<option value='.$agency->id.'>'.$agency->name.'</option>';
					}
				echo '</select>';
				echo '<span class="description">Choose funding agency if any.</span>';
				echo '</td></tr>';

				$members = WPRI_Database::get_all_members();

				echo '<tr>';
				echo '<th><label for="members[]">Contact person(s)</label></th>';
			    echo '<td><select size="4" multiple="multiple" name="members[]">';
					foreach ( $members as $member ) {
					echo '<option value='.$member->id.'>'.$member->name.'</option>';
					}
				echo '</select>';
				echo '<span class="description">Choose members that should receive applications.</span>';
				echo '</td></tr>';

				echo '<tr>';
				echo '<th><label for="description">Job description</label></th>';
				echo '<td><textarea id="description" name="description" cols="70" rows="10"></textarea>';
				echo '<span class="description">In the language of the main audience.</span>';
				echo '</td></tr>';

				echo '</td></tr>';
				echo '<tr>';
				echo '<th><label for="startdate">Title</label></th>';
				echo '<td><textarea id="startdate" name="startdate" cols="70" rows="2"></textarea>';
				echo '<span class="description">When the position starts.</span>';
				echo '</td></tr>';

				echo '</td></tr>';
				echo '<tr>';
				echo '<th><label for="enddate">Title</label></th>';
				echo '<td><textarea id="enddate" name="enddate" cols="70" rows="2"></textarea>';
				echo '<span class="description">When the position ends.</span>';
				echo '</td></tr>';

				echo '</td></tr>';
				echo '<tr>';
				echo '<th><label for="deadline">Title</label></th>';
				echo '<td><textarea id="deadline" name="deadline" cols="70" rows="2"></textarea>';
				echo '<span class="description">Application deadline.</span>';
				echo '</td></tr>';

			    echo '<tr>';
			    echo '<td><input type="submit" name="add_button" value="Add Open Position" class="button-secondary" />';
			    echo '<input type="hidden" name="type" value="add_position"/></td>';
			    echo '</tr>';
				echo '</table>';

				echo '</form>';
				echo '</div>';
				echo '</div>';
			}
			add_submenu_page( 'wpri-position-menu','Add Position','Add' ,  'manage_options', 'wpri-position-add' , 'wpri_position_add_management');
 		}



}
