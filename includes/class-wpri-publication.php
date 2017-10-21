<?php

/**
 * Functionality about publication management.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    wpri
 * @subpackage wpri/includes
 */

/**
 * Functionality about publication management.
 *
 * Functionality about publication management.
 *
 * @since      1.0.0
 * @package    wpri
 * @subpackage wpri/includes
 * @author     Zafeirakis Zafeirakopoulos
 */
class WPRI_Publication {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */

	public function publication_menu() {

			function wpri_publication_management() {
				$locales  = WPRI_Database::get_locales();
				$publications = WPRI_Database::get_all_publications();
				$members  = WPRI_Database::get_all_members();
				$agencies = WPRI_Database::get_agencies();


				echo '<div class="wrap">';
				echo '<h2>Manage Publications</h2>';
				echo '<div class="wrap wpa">';


				// If POST for deleting
				if( isset( $_POST['type']) && $_POST['type'] == 'delete_publication') {
					$success = WPRI_Database::delete_publication($_POST['publication_id']);
					if($success) {
						echo "<div class='updated'><p><strong>Deleted.</strong></p></div>";
					} else {
				    	echo "<div class='error'><p>Unable to delete.</p></div>";
					}
				}

				echo '<h3> Existing Publications: </h3>';
				echo '<table>';
			 	foreach ( $projects as $project ) {
					echo '<form name="delete_publication" method="post" action="">';
					echo '<tr>';
					echo '<td><label>' . $publication->title . ': </label></td>';
					echo '<td> <input type="submit" name="delete_button' . $publication->id  . '" value="Delete" class="button" />';
			    	echo '<input type="hidden" name="type" value="delete_publication" />';
			   		echo '<input type="hidden" name="publication_id" value=' . $publication->id . '/></td>';
					echo '</tr>';
					echo '</form>';
			    }
				echo '</table>';
				echo '</div>';
				echo '</div>';
			}
			add_menu_page( 'Publications', 'Publications', 'read', 'wpri-publication-menu','wpri_publication_management');

			function wpri_publication_add_management() {
				$locales  = WPRI_Database::get_locales();
				$publications = WPRI_Database::get_all_publications();
				$members  = WPRI_Database::get_all_members();
				$agencies = WPRI_Database::get_agencies();


				echo '<div class="wrap">';
				echo '<h2>Add new publication</h2>';
				echo '<div class="wrap wpa">';

				// If POST for adding
				if( isset( $_POST['type']) && $_POST['type'] == 'add_publication') {
					$project = array(
						'title' => $_POST["title"],
						'PI' => $_POST["pi"],
						'budget' => $_POST["budget"],
						'website' => $_POST["website"],
						'funding' => $_POST["agency"],
						'startdate' => $_POST["startdate"],
						'enddate' => $_POST["enddate"],
						'status' => $_POST["status"]
					);
					$success = WPRI_Database::add_project($project);
				    // Add PI as a member
					WPRI_Database::add_project_member($success,WPRI_Database::get_member_from_user($_POST["pi"])->id,1);

					// Returns the new id. 0 on fail.
					if($success ) {
						echo "<div class='updated'><p><strong>Added.</strong></p></div>";
					} else {
						echo "<div class='error'><p>Unable to add.</p></div>";
					}
				}

				echo '</table>';
				echo '<form name="add_project" method="post" action="">';
				echo '<table class="form-table">';
				echo '<tr>';
				echo '<th><label>Official Title</label></th>';
				echo '<td><textarea id="title_' . $locale->id . '" name="title" cols="60" rows="1"></textarea>';
				echo '<span class="description">As appears for funding agency.</span>';
				echo '</td></tr>';

				foreach ( $locales as $locale ) {
					echo '<tr>';
					echo '<th><label>' . $locale->name . '</label></th>';
					echo '<td><textarea id="title_' . $locale->id . '" name="title_' . $locale->id . '" cols="60" rows="1"></textarea>';
					echo '<span class="description">other locales</span>';
					echo '</td></tr>';
				}

				foreach ( $locales as $locale ) {
					echo '<tr>';
					echo '<th><label>Description (' . $locale->name . ')</label></th>';
					echo '<td><textarea id="description_' . $locale->id . '" name="description_' . $locale->id . '" cols="70" rows="6"></textarea>';
					echo '<span class="description">other locales</span>';
					echo '</td></tr>';
				}

				echo '<tr>';
				echo '<th><label>Principal Investigator</label></th>';
				echo '<td>';
				echo '<select name="pi">';
					foreach ( $members as $member ) {
						echo '<option value='.$member->id.'>'.$member->name.'</option>';
					}
				echo '</select>';
				echo '<span class="description">As appears for funding agency.</span>';
				echo '</td></tr>';

				echo '<tr>';
				echo '<th><label>Budget</label></th>';
				echo '<td><textarea id="budget" name="budget" cols="15" rows="1"></textarea>';
				echo '<span class="description">As appears for funding agency.</span>';
				echo '</td></tr>';

				echo '<tr>';
				echo '<th><label>Website</label></th>';
				echo '<td><textarea id="website" name="website" cols="70" rows="1"></textarea>';
				echo '<span class="description">A URL</span>';
				echo '</td></tr>';

				echo '<tr>';
				echo '<th><label>Funding agency</label></th>';
				echo '<td>';
				echo '<select name="funding">';
					foreach ( $agencies as $agency ) {
						echo '<option value='.$agency->id.'>'.$agency->name.'</option>';
					}
				echo '</select>';
				echo '<span class="description">Choose funding agency.</span>';
				echo '</td></tr>';

				echo '<tr>';
				echo '<th><label>Status</label></th>';
				echo '<td>';
				echo '<select name="status">';
					foreach ( WPRI_Database::get_project_statuses() as $status ) {
						echo '<option value='.$status->project_status.'>'.$status->name.'</option>';
					}
				echo '</select>';
				echo '<span class="description">Current status.</span>';
				echo '</td></tr>';

				echo '<tr>';
				echo '<th><label>Start date</label></th>';
				echo '<td><textarea id="startdate" name="startdate" cols="25" rows="1"></textarea>';
				echo '<span class="description">Starting date.</span>';
				echo '</td></tr>';

				echo '<tr>';
				echo '<th><label>End date</label></th>';
				echo '<td><textarea id="enddate" name="enddate" cols="25" rows="1"></textarea>';
				echo '<span class="description">Ending date.</span>';
				echo '</td></tr>';

				echo '<tr>';
				echo '<td><input type="submit" name="add_button" value="Add Project" class="button-secondary" />';
				echo '<input type="hidden" name="type" value="add_project"/></td>';
				echo '</tr>';
				echo '</table>';

				echo '</form>';
				echo '</div>';
				echo '</div>';
			}
			add_submenu_page( 'wpri-publication-menu','Publication Add','Add' ,  'manage_options', 'wpri-publication-add' , 'wpri_publication_add_management');
 		}



}
