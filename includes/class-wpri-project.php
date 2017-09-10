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
			echo '<div class="wrap">';
			echo '<h2>Manage Projects</h2>';
		 	$table_name = $GLOBALS['wpdb']->prefix . 'wpri_project';
			$locale_table_name = $GLOBALS['wpdb']->prefix . 'wpri_locale';
			$locales = WPRI_Database::get_wpri_locales();

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
				$new_id = WPRI_Database::add_wpri_project($project);

				if($GLOBALS['wpdb']->insert_id) {
					?>
			    <div class="updated"><p><strong>Added.</strong></p></div>
				<?php
				} else {
					?>
			    <div class="error"><p>Unable to add.</p></div>
			    <?php
				}

		/*
		 		foreach ( $locales as $locale ) {
					$GLOBALS['wpdb']->insert( $mixed_table_name , array(
						'locale' => $locale->id,
						$setting_name => $new_id,
						'name' => $_POST["setting_name_" . $locale->id],
					));
				}
		*/
			}

			// If POST for deleting
			if( isset( $_POST['type']) && $_POST['type'] == 'delete_project') {
				/*
		 		foreach ( $locales as $locale ) {
					$GLOBALS['wpdb']->query( $GLOBALS['wpdb']->prepare(
						"DELETE FROM $mixed_table_name WHERE $setting_name = %d", $_POST['setting_id']
					));
				}
				*/
				$result = $GLOBALS['wpdb']->query( $GLOBALS['wpdb']->prepare(
					"DELETE FROM " . $table_name . " WHERE id = %d", $_POST['project_id']
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


			echo '<h3> Existing ' . $setting_name . ': </h3>';

			$all_entries = $GLOBALS['wpdb']->get_results("SELECT * FROM " . $table_name );
			echo '<table>';
		 	foreach ( $all_entries as $dbitem ) {
				echo '<form name="delete_project" method="post" action="">';
				echo '<tr>';
				echo '<td><label>' . $dbitem->title . ': </label></td>';
				echo '<td> <input type="submit" name="delete_button' . $dbitem->id  . '" value="Delete" class="button" />';
		    	echo '<input type="hidden" name="type" value="delete_project" />';
		   		echo '<input type="hidden" name="project_id" value=' . $dbitem->id . '/></td>';
				echo '</tr>';
				echo '</form>';
		    }
			echo '</table>';

			echo '<h3> Add new project: </h3>';
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


			$member_table_name = $GLOBALS['wpdb']->prefix . "wpri_member" ;
			$members = $GLOBALS['wpdb']->get_results("SELECT * FROM " . $member_table_name );

			echo '<tr>';
			echo '<th><label>Principal Investigator</label></th>';
			echo '<td>';
			echo '<select name="pi">';
				foreach ( $members as $member ) {
					echo '<option value='.$member->id.'>'.$member->username.'</option>';
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

			$agency_table_name = $GLOBALS['wpdb']->prefix . "wpri_agency" ;
			$agencies = $GLOBALS['wpdb']->get_results("SELECT * FROM " . $agency_table_name );
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
		add_menu_page( 'Projects', 'Projects', 'read', 'wpri-project-menu','wpri_project_management');
	}

}
