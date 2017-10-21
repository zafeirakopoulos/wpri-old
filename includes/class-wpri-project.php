<?php

/**
 * Functionality about project management.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    wpri
 * @subpackage wpri/includes
 */

/**
 * Functionality about project management.
 *
 * Functionality about project management.
 *
 * @since      1.0.0
 * @package    wpri
 * @subpackage wpri/includes
 * @author     Zafeirakis Zafeirakopoulos
 */
class WPRI_Project {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */

	public function project_menu() {

		function wpri_project_management() {
			$locales  = WPRI_Database::get_locales();
			$projects = WPRI_Database::get_all_projects();
			$members  = WPRI_Database::get_all_members();
			$agencies = WPRI_Database::get_agencies();


			echo '<div class="wrap">';
			echo '<h2>Manage Projects</h2>';
			echo '<div class="wrap wpa">';


			// If POST for deleting
			if( isset( $_POST['type']) && $_POST['type'] == 'delete_project') {
				$success = WPRI_Database::delete_project($_POST['project_id']);
				if($success) {
					echo "<div class='updated'><p><strong>Deleted.</strong></p></div>";
				} else {
			    	echo "<div class='error'><p>Unable to delete.</p></div>";
				}
			}

			echo '<h3> Existing Projects: </h3>';
			echo '<table>';
		 	foreach ( $projects as $project ) {
				echo '<form name="delete_project" method="post" action="">';
				echo '<tr>';
				echo '<td><label>' . $project->title . ': </label></td>';
				echo '<td> <input type="submit" name="delete_button' . $project->id  . '" value="Delete" class="button" />';
		    	echo '<input type="hidden" name="type" value="delete_project" />';
		   		echo '<input type="hidden" name="project_id" value=' . $project->id . '/></td>';
				echo '</tr>';
				echo '</form>';
		    }
			echo '</table>';
			echo '</div>';
			echo '</div>';
		}
		add_menu_page( 'Projects', 'Projects', 'read', 'wpri-project-menu','wpri_project_management');

		function wpri_project_add_management() {
			$locales  = WPRI_Database::get_locales();
			$projects = WPRI_Database::get_all_projects();
			$members  = WPRI_Database::get_all_members();
			$agencies = WPRI_Database::get_agencies();


			echo '<div class="wrap">';
			echo '<h2>Add new project</h2>';
			echo '<div class="wrap wpa">';

			// If POST for adding
			if( isset( $_POST['type']) && $_POST['type'] == 'add_project') {
				$project = array(
					'title' => $_POST["title"],
					'PI' => $_POST["pi"],
					'budget' => $_POST["budget"],
					'website' => $_POST["website"],
					'funding' => $_POST["agency"]
				);
				$success = WPRI_Database::add_project($project);
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
			echo '<td><input type="submit" name="add_button" value="Add Project" class="button-secondary" />';
			echo '<input type="hidden" name="type" value="add_project"/></td>';
			echo '</tr>';
			echo '</table>';

			echo '</form>';
			echo '</div>';
			echo '</div>';
		}
		add_submenu_page( 'wpri-project-menu','Project Add','Add' ,  'manage_options', 'wpri-project-add' , 'wpri_project_add_management');

		function wpri_project_participate_management() {

			if( isset( $_POST['type']) && $_POST['type'] == 'add_member') {
				foreach ( $projectroles as $role ) {
					echo $_POST[trim($role->name).'projects'];
					foreach ( $_POST[trim($role->name).'projects'] as $project ) {
						echo $project;
						echo "user:"+ get_user();
						$success = WPRI_Database::add_project_member($project,WPRI_Database::get_member_from_user(get_user()),$role);
						// Returns the new id. 0 on fail.
						if($success ) {
							echo "<div class='updated'><p><strong>Added as ".$role->name.".</strong></p></div>";
						} else {
							echo "<div class='error'><p>Unable to add.</p></div>";
						}
					}
				}
			}
		    echo '<h2>Project Participation</h2>';
 			$projectroles = WPRI_Database::get_project_roles();
			$projects = WPRI_Database::get_all_projects();

			echo '<form name="add_project" method="post" action="">';
			echo '<table class="form-table">';
			foreach ( $projectroles as $role ) {
				echo '<tr>';
				echo '<th><label">'.$role->name.' in:</label></th>';
				echo '<td><select size="4" multiple="multiple" name="'.trim($role->name).'projects[]">';
					foreach ( $projects as $project ) {
					echo '<option value='.$project->id. ' ' . ( WPRI_Database::member_participates_in_project_as(WPRI_Database::get_member_from_user($user)->id, $project->id,$role->role)? 'selected ' : ' ') .'>'.$project->title.'</option>';
					}
				echo '</select>';
				echo '<span class="description">Choose projects you participate as '.$role->name.'.</span>';
				echo '</td></tr>';
			}
			echo '<tr>';
			echo '<td><input type="submit" name="add_button" value="Add me as member in these projects" class="button-secondary" />';
			echo '<input type="hidden" name="type" value="add_member"/></td>';
			echo '</tr>';

	  		echo '</table>';
			echo '</form>';
		}
		add_submenu_page( 'wpri-project-menu','Project Participation','Participation' ,  'manage_options', 'wpri-project-participate' , 'wpri_project_participate_management');

	}

}
