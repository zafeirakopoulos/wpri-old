<?php

/**
 * Functions managing the database.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    wpri
 * @subpackage wpri/includes
 */

/**
 * Functions managing the database..
 *
 * Functions managing the database.
 *
 * @since      1.0.0
 * @package    wpri
 * @subpackage wpri/includes
 * @author     Zafeirakis Zafeirakopoulos
 */
class WPRI_Database {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function wpri_create_tables() {

		$first_install = ( $GLOBALS['wpdb']->get_var( "SHOW TABLES LIKE '$table_name'") != $table_name );

		$settings_list = array('locale','position','title','agency');
		foreach ($settings_list as $setting_name){
			$table_name = $GLOBALS['wpdb']->prefix . "wpri_" . $setting_name;
			//$GLOBALS['wpdb']->query( "DROP TABLE IF EXISTS  " . $table_name );

			if( $GLOBALS['wpdb']->get_var( "SHOW TABLES LIKE '$table_name'") != $table_name ){
				$sql = "CREATE TABLE  $table_name (
					id INT AUTO_INCREMENT PRIMARY KEY,
					name tinytext 
				);";	
				$GLOBALS['wpdb']->query( $GLOBALS['wpdb']->escape( $sql ) );
			}	
	 	}

		foreach ($settings_list as $setting_name){
			if ($setting_name!='locale'){
				$table_name = $GLOBALS['wpdb']->prefix . "wpri_locale_" . $setting_name;
				$locale_table_name = $GLOBALS['wpdb']->prefix . "wpri_locale" ;
				$other_table_name = $GLOBALS['wpdb']->prefix . "wpri_" . $setting_name;

	 
				if( $GLOBALS['wpdb']->get_var( "SHOW TABLES LIKE '$table_name'") != $table_name ){
					$sql = "CREATE TABLE  $table_name (
						id INT AUTO_INCREMENT PRIMARY KEY,
						locale INT,
						$setting_name INT,
						name tinytext, 
						FOREIGN KEY (locale) REFERENCES $locale_table_name(id),
						FOREIGN KEY ($setting_name) REFERENCES $other_table_name(id)
					);";	
					$GLOBALS['wpdb']->query( $GLOBALS['wpdb']->escape( $sql ) );
				}
			}	
	 	}


		$position_table_name = $GLOBALS['wpdb']->prefix . "wpri_position" ;
		$title_table_name = $GLOBALS['wpdb']->prefix . "wpri_title" ;
	 	$member_table_name = $GLOBALS['wpdb']->prefix . "wpri_member" ;
		$project_table_name = $GLOBALS['wpdb']->prefix . "wpri_project" ;
		$agency_table_name = $GLOBALS['wpdb']->prefix . "wpri_agency" ;
		$description_table_name = $GLOBALS['wpdb']->prefix . "wpri_project_description";
		$locale_table_name = $GLOBALS['wpdb']->prefix . "wpri_locale" ;
		$pr_mem_table_name = $GLOBALS['wpdb']->prefix . "wpri_project_member";
		$pubtype_table_name = $GLOBALS['wpdb']->prefix . "wpri_pubtype" ;
		$publication_table_name = $GLOBALS['wpdb']->prefix . "wpri_publication" ;
		$pub_mem_table_name = $GLOBALS['wpdb']->prefix . "wpri_pub_member";
		$pub_project_table_name = $GLOBALS['wpdb']->prefix . "wpri_pub_project";
		$wp_posts_table_name = $GLOBALS['wpdb']->prefix . "posts";


		// Members
		if( $GLOBALS['wpdb']->get_var( "SHOW TABLES LIKE '$member_table_name'") != $member_table_name ){
			$sql = "CREATE TABLE  $member_table_name (
				id INT AUTO_INCREMENT PRIMARY KEY,
				user INT,
				username tinytext,
				displayname tinytext,
				position INT,
				title INT, 
				advisor INT, 
				office tinytext, 
				phone tinytext,
				website text,
				wppage BIGINT,
				alumni BOOLEAN,
	  			FOREIGN KEY (position) REFERENCES $position_table_name(id),
	  			FOREIGN KEY (title) REFERENCES $title_table_name(id)
				);";	
			$GLOBALS['wpdb']->query( $GLOBALS['wpdb']->escape( $sql ) );
		}	

	 

		// Projects

		if( $GLOBALS['wpdb']->get_var( "SHOW TABLES LIKE '$project_table_name'") != $project_table_name ){
			$sql = "CREATE TABLE  $project_table_name (
				id INT AUTO_INCREMENT PRIMARY KEY,
				title tinytext,
				PI INT,
				budget INT,
				website tinytext,
				funding INT,
	 			FOREIGN KEY (PI) REFERENCES $member_table_name(id),
	 			FOREIGN KEY (funding) REFERENCES $agency_table_name(id)
				);";	
			$GLOBALS['wpdb']->query( $GLOBALS['wpdb']->escape( $sql ) );
		}	



		// Description
		if( $GLOBALS['wpdb']->get_var( "SHOW TABLES LIKE '$description_table_name'") != $description_table_name){
					$sql = "CREATE TABLE  $description_table_name(
						id INT AUTO_INCREMENT PRIMARY KEY,
						locale INT,
						project INT,
						description text, 
						FOREIGN KEY (locale) REFERENCES $locale_table_name(id),
						FOREIGN KEY (project) REFERENCES $project_table_name(id)
					);";	
					$GLOBALS['wpdb']->query( $GLOBALS['wpdb']->escape( $sql ) );
	 	}


	// Project Members	
	 	if( $GLOBALS['wpdb']->get_var( "SHOW TABLES LIKE '$pr_mem_table_name'") != $pr_mem_table_name){
					$sql = "CREATE TABLE  $pr_mem_table_name(
						id INT AUTO_INCREMENT PRIMARY KEY,
						member INT,
						project INT,
						position INT, 
						FOREIGN KEY (member) REFERENCES $member_table_name(id),
						FOREIGN KEY (project) REFERENCES $project_table_name(id),
						FOREIGN KEY (position) REFERENCES $position_table_name(id)
					);";	
					$GLOBALS['wpdb']->query( $GLOBALS['wpdb']->escape( $sql ) );
	 	}
	 


		// Publications
		if( $GLOBALS['wpdb']->get_var( "SHOW TABLES LIKE '$pubtype_table_name'") != $pubtype_table_name ){
			$sql = "CREATE TABLE  $pubtype_table_name (
				id INT AUTO_INCREMENT PRIMARY KEY,
				name tinytext
				);";	
			$GLOBALS['wpdb']->query( $GLOBALS['wpdb']->escape( $sql ) );
		}	

	 
		if( $GLOBALS['wpdb']->get_var( "SHOW TABLES LIKE '$publication_table_name'") != $publication_table_name){
			$sql = "CREATE TABLE  $publication_table_name (
				id INT AUTO_INCREMENT PRIMARY KEY,
				type INT,
				title text,
				doi tinytext,
				international boolean,
				refereed boolean,
				bibentry text,
	 			FOREIGN KEY (type) REFERENCES $pubtype_table_name(id)
				);";	
			$GLOBALS['wpdb']->query( $GLOBALS['wpdb']->escape( $sql ) );
		}	
	 


	 	if( $GLOBALS['wpdb']->get_var( "SHOW TABLES LIKE '$pub_mem_table_name'") != $pub_mem_table_name ){
					$sql = "CREATE TABLE  $pub_mem_table_name(
						id INT AUTO_INCREMENT PRIMARY KEY,
						member INT,
						pub INT,
						FOREIGN KEY (member) REFERENCES $member_table_name(id),
						FOREIGN KEY (pub) REFERENCES $publication_table_name (id)
					);";	
					$GLOBALS['wpdb']->query( $GLOBALS['wpdb']->escape( $sql ) );
	 	}
	 
	 	if( $GLOBALS['wpdb']->get_var( "SHOW TABLES LIKE '$pub_project_table_name'") != $pub_project_table_name){
					$sql = "CREATE TABLE  $pub_project_table_name (
						id INT AUTO_INCREMENT PRIMARY KEY,
						project INT,
						pub INT,
						FOREIGN KEY (project) REFERENCES $project_table_name (id),
						FOREIGN KEY (pub) REFERENCES $publication_table_name (id)
					);";	
					$GLOBALS['wpdb']->query( $GLOBALS['wpdb']->escape( $sql ) );
	 	}
	  	 	
	    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		return $first_install;
	};


	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function  wpri_populate_tables() {
		/* Create pubtypes */
		$table_name = $GLOBALS['wpdb']->prefix . "wpri_pubtype";
		$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "Journal"));
		$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "Conference"));
		$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "Poster"));
	
		/* Create locales */
		$table_name = $GLOBALS['wpdb']->prefix . "wpri_locale";
		$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "En_US"));
		$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "Tr_TR"));
	
		/* Create positions*/
		$table_name = $GLOBALS['wpdb']->prefix . "wpri_position";
		$locale_table_name = $GLOBALS['wpdb']->prefix . "wpri_locale_position";
		$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "director"));
		$insert_id = $GLOBALS['wpdb']->insert_id;
		$GLOBALS['wpdb']->insert( $locale_table_name , array( 
			'name' => "Director",
			'locale' => 1,
			'position' => $insert_id)
		);
		$GLOBALS['wpdb']->insert( $locale_table_name , array( 
			'name' => "Müdür",
			'locale' => 2,
			'position' => $insert_id)
		);
		$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "vice-director"));
		$insert_id = $GLOBALS['wpdb']->insert_id;
		$GLOBALS['wpdb']->insert( $locale_table_name , array( 
			'name' => "Vice Director",
			'locale' => 1,
			'position' => $insert_id)
		);
		$GLOBALS['wpdb']->insert( $locale_table_name , array( 
			'name' => "Yard. Müdür",
			'locale' => 2,
			'position' => $insert_id)
		);		
		$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "faculty"));
		$insert_id = $GLOBALS['wpdb']->insert_id;
		$GLOBALS['wpdb']->insert( $locale_table_name , array( 
			'name' => "Faculty",
			'locale' => 1,
			'position' => $insert_id)
		);
		$GLOBALS['wpdb']->insert( $locale_table_name , array( 
			'name' => "Faculty",
			'locale' => 2,
			'position' => $insert_id)
		);
		$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "assistant"));
		$insert_id = $GLOBALS['wpdb']->insert_id;
		$GLOBALS['wpdb']->insert( $locale_table_name , array( 
			'name' => "Research Assistant",
			'locale' => 1,
			'position' => $insert_id)
		);
		$GLOBALS['wpdb']->insert( $locale_table_name , array( 
			'name' => "Ar Gör",
			'locale' => 2,
			'position' => $insert_id)
		);
		$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "secretary"));
		$insert_id = $GLOBALS['wpdb']->insert_id;
		$GLOBALS['wpdb']->insert( $locale_table_name , array( 
			'name' => "Secretary",
			'locale' => 1,
			'position' => $insert_id)
		);
		$GLOBALS['wpdb']->insert( $locale_table_name , array( 
			'name' => "Secretary",
			'locale' => 2,
			'position' => $insert_id)
		);
		$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "technician"));
		$insert_id = $GLOBALS['wpdb']->insert_id;
		$GLOBALS['wpdb']->insert( $locale_table_name , array( 
			'name' => "Technician",
			'locale' => 1,
			'position' => $insert_id)
		);
		$GLOBALS['wpdb']->insert( $locale_table_name , array( 
			'name' => "Technician",
			'locale' => 2,
			'position' => $insert_id)
		);
		$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "collaborator"));
		$insert_id = $GLOBALS['wpdb']->insert_id;
		$GLOBALS['wpdb']->insert( $locale_table_name , array( 
			'name' => "Collaborator",
			'locale' => 1,
			'position' => $insert_id)
		);
		$GLOBALS['wpdb']->insert( $locale_table_name , array( 
			'name' => "Collaborator",
			'locale' => 2,
			'position' => $insert_id)
		);

	 
		/* Create titles*/
		$table_name = $GLOBALS['wpdb']->prefix . "wpri_title";
		$locale_table_name = $GLOBALS['wpdb']->prefix . "wpri_locale_title";
		$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "professor"));
		$GLOBALS['wpdb']->insert_id;
		$insert_id = $GLOBALS['wpdb']->insert_id;
		$GLOBALS['wpdb']->insert( $locale_table_name , array( 
			'name' => "Prof.",
			'locale' => 1,
			'title' => $insert_id)
		);
		$GLOBALS['wpdb']->insert( $locale_table_name , array( 
			'name' => "Prof.",
			'locale' => 2,
			'title' => $insert_id)
		);
		$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "associate-professor"));
		$insert_id = $GLOBALS['wpdb']->insert_id;
		$GLOBALS['wpdb']->insert( $locale_table_name , array( 
			'name' => "Assoc. Prof.",
			'locale' => 1,
			'title' => $insert_id)
		);
		$GLOBALS['wpdb']->insert( $locale_table_name , array( 
			'name' => "Doç.",
			'locale' => 2,
			'title' => $insert_id)
		);
		$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "assistant-professor"));
		$insert_id = $GLOBALS['wpdb']->insert_id;
		$GLOBALS['wpdb']->insert( $locale_table_name , array( 
			'name' => "Assist. Prof.",
			'locale' => 1,
			'title' => $insert_id)
		);
		$GLOBALS['wpdb']->insert( $locale_table_name , array( 
			'name' => "Yard. Doç.",
			'locale' => 2,
			'title' => $insert_id)
		);
		$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "doctor"));
		$insert_id = $GLOBALS['wpdb']->insert_id;
		$GLOBALS['wpdb']->insert( $locale_table_name , array( 
			'name' => "Dr.",
			'locale' => 1,
			'title' => $insert_id)
		);
		$GLOBALS['wpdb']->insert( $locale_table_name , array( 
			'name' => "Dr.",
			'locale' => 2,
			'title' => $insert_id)
		);

	 
		/* Create funding agencies*/
		$table_name = $GLOBALS['wpdb']->prefix . "wpri_agency";
		$locale_table_name = $GLOBALS['wpdb']->prefix . "wpri_locale_agency";
		$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "tubitak"));
		$insert_id = $GLOBALS['wpdb']->insert_id;
		$GLOBALS['wpdb']->insert( $locale_table_name , array( 
			'name' => "TUBITAK",
			'locale' => 1,
			'agency' => $insert_id)
		);
		$GLOBALS['wpdb']->insert( $locale_table_name , array( 
			'name' => "TÜBITAK",
			'locale' => 2,
			'agency' => $insert_id)
		);
		$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "h2020"));
		$insert_id = $GLOBALS['wpdb']->insert_id;
		$GLOBALS['wpdb']->insert( $locale_table_name , array( 
			'name' => "Horizon 2020",
			'locale' => 1,
			'agency' => $insert_id)
		);
		$GLOBALS['wpdb']->insert( $locale_table_name , array( 
			'name' => "Ufuk 2020",
			'locale' => 2,
			'agency' => $insert_id)
		);

	};


    public static function drop_tables() {
     
	    $tables_to_drop = array(
	    'wpri_pub_member',
	    'wpri_pub_project',
	    'wpri_publication',
	    'wpri_pubtype',
	    'wpri_locale_agency',
	    'wpri_locale_position',
	    'wpri_locale_title',
	    'wpri_locale_project_description',
	    'wpri_locale_agency',
	    'wpri_project_description',
	    'wpri_project_member',
	    'wpri_project',
	    'wpri_member',
	    'wpri_title',
	    'wpri_position',
	    'wpri_agency',
	    'wpri_locale'
	    );

	    $tables_to_drop = array();

	    foreach($tables_to_drop as $table_name){
		    $GLOBALS['wpdb']->query( "DROP TABLE IF EXISTS  " . $GLOBALS['wpdb']->prefix . $table_name );
	    }
 
    }
}
