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
			 	foreach ( $publications as $ppublication) {
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
					$publication = array(
						'title' => $_POST["title"],
						'type' => $_POST["pubtype"],
						'doi' => $_POST["doi"],
						'international' => $_POST["international"],
						'refereed' => $_POST["refereed"],
						'bibentry' => $_POST["bibentry"],
					);
					$success = WPRI_Database::add_publication($publication);

					// TODO add project publication
					// TODO Add member publication
					// TODO Add funding publication
					// Returns the new id. 0 on fail.
					if($success ) {
						echo "<div class='updated'><p><strong>Added.</strong></p></div>";
					} else {
						echo "<div class='error'><p>Unable to add.</p></div>";
					}
				}

				echo '<h3> Add new publication: </h3>';

				$pubtypes = WPRI_Database::get_publication_types();

			 	echo '<form name="add_publication" method="post" action="">';
				echo '<table class="form-table">';
				echo '<tr>';
				echo '<th><label for="pubtype">Type</label></th>';
				echo '<td><select name="pubtype">';
					foreach ( $pubtypes  as $pubtype ) {
						echo '<option value='.$pubtype->id.'>'.$pubtype->name.'</option>';
					}
				echo '</select>';
				echo '<span class="description">Please enter publication type.</span>';
				echo '</td></tr>';
				echo '<tr>';
				echo '<th><label for="international">International</label></th>';
				echo '<td><input type="checkbox" name="international" value=1>';
				echo '<span class="description">Check if publication appeared in international venue.</span>';
				echo '</td></tr>';
				echo '<tr>';
				echo '<th><label for="refereed">Refereed</label></th>';
				echo '<td><input type="checkbox" name="refereed" value=1>';
				echo '<span class="description">Check if publication was refereed.</span>';
				echo '</td></tr>';

				echo '</td></tr>';
				echo '<tr>';
				echo '<th><label for="title">Title</label></th>';
				echo '<td><textarea id="title" name="title" cols="70" rows="2"></textarea>';
				echo '<span class="description">140 characters.</span>';
				echo '</td></tr>';
				echo '<tr>';
				echo '<th><label for="doi">DOI</label></th>';
				echo '<td><textarea id="doi" name="doi" cols="70" rows="1"></textarea>';
				echo '<span class="description">The DOI identifier.</span>';
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
				echo '<th><label for="members[]">Members that are authors</label></th>';
			    echo '<td><select size="4" multiple="multiple" name="members[]">';
					foreach ( $members as $member ) {
					echo '<option value='.$member->id.'>'.$member->username.'</option>';
					}
				echo '</select>';
				echo '<span class="description">Choose (multiple) members that are authors.</span>';
				echo '</td></tr>';

				$projects = WPRI_Database::get_all_projects();

				echo '<tr>';
				echo '<th><label for="projects[]">Projects related to the publication</label></th>';
				echo '<td><select size="4" multiple="multiple" name="projects[]">';
					foreach ( $projects as $project ) {
					echo '<option value='.$project->id.'>'.$project->title.'</option>';
					}
				echo '</select>';
				echo '<span class="description">Choose related projects.</span>';
				echo '</td></tr>';


				echo '<tr>';
				echo '<th><label for="bibentry">bibentry</label></th>';
				echo '<td><textarea id="bibentry" name="bibentry" cols="70" rows="10"></textarea>';
				echo '<span class="description">Make sure it parses correctly</span>';
				echo '</td></tr>';

			    echo '<tr>';
			    echo '<td><input type="submit" name="add_button" value="Add Publication" class="button-secondary" />';
			    echo '<input type="hidden" name="type" value="add_pub"/></td>';
			    echo '</tr>';
				echo '</table>';

				echo '</form>';
				echo '</div>';
				echo '</div>';
			}
			add_submenu_page( 'wpri-publication-menu','Publication Add','Add' ,  'manage_options', 'wpri-publication-add' , 'wpri_publication_add_management');
 		}



}
