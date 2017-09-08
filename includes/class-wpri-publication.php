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
			echo '<div class="wrap">';
			echo '<h2>Manage Publications</h2>';
			$pubtype_table_name = $GLOBALS['wpdb']->prefix . "wpri_pubtype" ;
			$publication_table_name = $GLOBALS['wpdb']->prefix . "wpri_publication" ;
			$pub_mem_table_name = $GLOBALS['wpdb']->prefix . "wpri_pub_member";
			$pub_project_table_name = $GLOBALS['wpdb']->prefix . "wpri_pub_project";

			echo '<div class="wrap wpa">';

			// If POST for adding
			if( isset( $_POST['type']) && $_POST['type'] == 'add_pub') {
				$GLOBALS['wpdb']->insert( $publication_table_name , array( 
					'title' => $_POST["title"], 
					'type' => $_POST["pubtype"],
					'doi' => $_POST["doi"],
					'international' => $_POST["international"],
					'refereed' => $_POST["refereed"],
					'bibentry' => $_POST["bibentry"],
				));

				$new_id = $GLOBALS['wpdb']->insert_id;
				if($GLOBALS['wpdb']->insert_id) {
					?>
			    <div class="updated"><p><strong>Added.</strong></p></div>
				<?php
				} else {
					?>
			    <div class="error"><p>Unable to add.</p></div>
			    <?php
				}

				if (!empty($_POST["members"])){
					foreach ( $_POST["members"] as $member){
						$GLOBALS['wpdb']->insert( $pub_mem_table_name , array( 
							'member' => $member, 
							'pub' => $new_id
						));	
					}
				}		

				if (!empty($_POST["projects"])){
					foreach ( $_POST["projects"] as $project ){
						$GLOBALS['wpdb']->insert( $pub_project_table_name , array( 
							'project' => $project, 
							'pub' => $new_id
						));	
					}	
				}


 

				// Add page for publication
			    $publication_page_title = $_POST["title"];
    			$publication_page_content = $_POST["bibentry"];
  			 	$publication_page_check = get_page_by_title($blog_page_title);
 			  	$publication_page = array(
				    'post_type' => 'page',
				    'post_title' => $publication_page_title,
				    'post_content' => $publication_page_content,
				    'post_status' => 'publish',
				    'post_author' => 1,
				    'post_slug' => $_POST["doi"]
			    );
		   	  	$publication_page_id = wp_insert_post($publication_page);
				update_post_meta( $publication_page_id, '_visibility', 'visible' );
			}
	
			// If POST for deleting
			if( isset( $_POST['type']) && $_POST['type'] == 'delete_pub') {
		 

				$result2 = $GLOBALS['wpdb']->query( $GLOBALS['wpdb']->prepare( 
					"DELETE FROM " . $pub_mem_table_name . " WHERE pub = %d", $_POST['pub_id'] 
					));

				$result3 = $GLOBALS['wpdb']->query( $GLOBALS['wpdb']->prepare( 
					"DELETE FROM " . $pub_project_table_name . " WHERE pub = %d", $_POST['pub_id'] 
					));
		  
				$result1 = $GLOBALS['wpdb']->query( $GLOBALS['wpdb']->prepare( 
					"DELETE FROM " . $publication_table_name . " WHERE id = %d", $_POST['pub_id'] 
					));

				if($result1) {
					echo '<div class="updated"><p><strong>Deleted.</strong></p></div>';
				} else {
			    echo '<div class="error"><p>Unable to delete.</p></div>';
				}
			}
		 

			echo '<h3> Existing ' . $setting_name . ': </h3>';

		 	$pubtype_table_name = $GLOBALS['wpdb']->prefix . "wpri_pubtype" ;
			$publication_table_name = $GLOBALS['wpdb']->prefix . "wpri_publication" ;
			$pub_mem_table_name = $GLOBALS['wpdb']->prefix . "wpri_pub_member";
			$pub_project_table_name = $GLOBALS['wpdb']->prefix . "wpri_pub_project";
		 	$member_table_name = $GLOBALS['wpdb']->prefix . "wpri_member" ;

			$all_entries = $GLOBALS['wpdb']->get_results(
		"SELECT " . $publication_table_name . ".* FROM " . $publication_table_name . " INNER JOIN " .  $pub_mem_table_name . " ON " . $pub_mem_table_name .".pub=" . $publication_table_name . ".id INNER JOIN " .  $member_table_name . " ON " . $member_table_name . ".id=" . $pub_mem_table_name . ".member WHERE " .  $member_table_name . ".user = " . get_current_user_id() . ";");

			echo '<table>';
		 	foreach ( $all_entries as $dbitem ) {
				echo '<form name="delete_pub" method="post" action="">';
				echo '<tr>';
				echo '<td><label>' . $dbitem->title . ': </label></td>';
				echo '<td> <input type="submit" name="delete_button' . $dbitem->id  . '" value="Delete" class="button" />';
		    	echo '<input type="hidden" name="type" value="delete_pub" />';
		   		echo '<input type="hidden" name="pub_id" value=' . $dbitem->id . '/></td>';
				echo '</tr>';
				echo '</form>';
		    }
			echo '</table>';

			echo '<h3> Add new publication: </h3>';



			$pubtypes = $GLOBALS['wpdb']->get_results("SELECT * FROM " . $pubtype_table_name);

		 	echo '<form name="add_pub" method="post" action="">'; 
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

			$agency_table_name = $GLOBALS['wpdb']->prefix . "wpri_agency" ;
			$agencies = $GLOBALS['wpdb']->get_results("SELECT * FROM " . $agency_table_name );

			echo '<tr>';
			echo '<th><label for="funding">Funding agency</label></th>';
			echo '<td><select name="funding">';
				foreach ( $agencies as $agency ) {
					echo '<option value='.$agency->id.'>'.$agency->name.'</option>';
				}
			echo '</select>';
			echo '<span class="description">Choose funding agency if any.</span>';
			echo '</td></tr>';

			$members = $GLOBALS['wpdb']->get_results("SELECT * FROM " . $member_table_name );

			echo '<tr>';
			echo '<th><label for="members[]">Members that are authors</label></th>';
		    echo '<td><select size="4" multiple="multiple" name="members[]">';
				foreach ( $members as $member ) {
				echo '<option value='.$member->id.'>'.$member->username.'</option>';
				}
			echo '</select>';
			echo '<span class="description">Choose (multiple) members that are authors.</span>';
			echo '</td></tr>';

		 	$project_table_name = $GLOBALS['wpdb']->prefix . "wpri_project" ;
			$projects = $GLOBALS['wpdb']->get_results("SELECT * FROM " . $project_table_name );

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
		add_menu_page( 'Publications', 'Publications', 'read', 'wpri-publication-menu','wpri_publication_management');
	}



	 
}