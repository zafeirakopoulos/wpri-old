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


	public static function table_name($name){
		$wp_prefix = $GLOBALS['wpdb']->prefix;
		return $wp_prefix."wpri_".$name ;
	}

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function create_tables() {

		// TODO remove in production!!!
		//self::drop_tables();

		$first_install = ( $GLOBALS['wpdb']->get_var( "SHOW TABLES LIKE '$table_name'") != $table_name );


		$settings_list = array('locale','position','title','agency');
		foreach ($settings_list as $setting_name){
			if( $GLOBALS['wpdb']->get_var( "SHOW TABLES LIKE '".self::table_name($setting_name)."'") != self::table_name($setting_name) ){
				$sql = "CREATE TABLE  ". self::table_name($setting_name)."(
					id INT AUTO_INCREMENT PRIMARY KEY,
					name tinytext
				);";
				$GLOBALS['wpdb']->query( $GLOBALS['wpdb']->escape( $sql ) );
			}
	 	}

		foreach ($settings_list as $setting_name){
			if ($setting_name!='locale'){
				$table_name = self::table_name("locale_".$setting_name);
				$other_table_name = self::table_name($setting_name);

				if( $GLOBALS['wpdb']->get_var( "SHOW TABLES LIKE '$table_name'") != $table_name ){
					$sql = "CREATE TABLE  $table_name (
						id INT AUTO_INCREMENT PRIMARY KEY,
						locale INT,
						$setting_name INT,
						name tinytext,
						FOREIGN KEY (locale) REFERENCES $table_name(id),
						FOREIGN KEY ($setting_name) REFERENCES $other_table_name(id)
					);";
					$GLOBALS['wpdb']->query( $GLOBALS['wpdb']->escape( $sql ) );
				}
			}
	 	}



		// Members
		if( $GLOBALS['wpdb']->get_var( "SHOW TABLES LIKE '".self::table_name("member")."'") != self::table_name("member") ){
			$sql = "CREATE TABLE  ".self::table_name("member")." (
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
	  			FOREIGN KEY (position) REFERENCES ".self::table_name("position")."(id),
	  			FOREIGN KEY (title) REFERENCES ".self::table_name("title")."(id)
				);";
			$GLOBALS['wpdb']->query( $GLOBALS['wpdb']->escape( $sql ) );
		}



		// Projects

		if( $GLOBALS['wpdb']->get_var( "SHOW TABLES LIKE '".self::table_name("project")."'") != self::table_name("project") ){
			$sql = "CREATE TABLE ".self::table_name("project")." (
				id INT AUTO_INCREMENT PRIMARY KEY,
				title tinytext,
				PI INT,
				budget INT,
				website tinytext,
				funding INT,
	 			FOREIGN KEY (PI) REFERENCES ".self::table_name("member")."(id),
	 			FOREIGN KEY (funding) REFERENCES ".self::table_name("agency")."(id)
				);";
			$GLOBALS['wpdb']->query( $GLOBALS['wpdb']->escape( $sql ) );
		}




		// Description
		if( $GLOBALS['wpdb']->get_var( "SHOW TABLES LIKE '".self::table_name("description")."'") != self::table_name("description")){
					$sql = "CREATE TABLE  ".self::table_name("description")."(
						id INT AUTO_INCREMENT PRIMARY KEY,
						locale INT,
						project INT,
						description text,
						FOREIGN KEY (locale) REFERENCES ".self::table_name("locale")."(id),
						FOREIGN KEY (project) REFERENCES ".self::table_name("project")."(id)
					);";
					$GLOBALS['wpdb']->query( $GLOBALS['wpdb']->escape( $sql ) );
	 	}


	// Project Members
	 	if( $GLOBALS['wpdb']->get_var( "SHOW TABLES LIKE '".self::table_name("project_member")."'") != self::table_name("project_member")){
					$sql = "CREATE TABLE  ".self::table_name("project_member")."(
						id INT AUTO_INCREMENT PRIMARY KEY,
						member INT,
						project INT,
						position INT,
						FOREIGN KEY (member) REFERENCES ".self::table_name("member")."(id),
						FOREIGN KEY (project) REFERENCES ".self::table_name("project")."(id),
						FOREIGN KEY (position) REFERENCES ".self::table_name("position")."(id)
					);";
					$GLOBALS['wpdb']->query( $GLOBALS['wpdb']->escape( $sql ) );
	 	}



		// Publications
		if( $GLOBALS['wpdb']->get_var( "SHOW TABLES LIKE '".self::table_name("pubtype")."'") != self::table_name("pubtype") ){
			$sql = "CREATE TABLE  ".self::table_name("pubtype")." (
				id INT AUTO_INCREMENT PRIMARY KEY,
				name tinytext
				);";
			$GLOBALS['wpdb']->query( $GLOBALS['wpdb']->escape( $sql ) );
		}


		if( $GLOBALS['wpdb']->get_var( "SHOW TABLES LIKE '".self::table_name("publication")."'") != self::table_name("publication")){
			$sql = "CREATE TABLE ".self::table_name("publication")."(
				id INT AUTO_INCREMENT PRIMARY KEY,
				type INT,
				title text,
				doi tinytext,
				international boolean,
				refereed boolean,
				bibentry text,
	 			FOREIGN KEY (type) REFERENCES ".self::table_name("pubtype")."(id)
				);";
			$GLOBALS['wpdb']->query( $GLOBALS['wpdb']->escape( $sql ) );
		}



	 	if( $GLOBALS['wpdb']->get_var( "SHOW TABLES LIKE '".self::table_name("publication_member")."'") != self::table_name("publication_member") ){
					$sql = "CREATE TABLE  ".self::table_name("publication_member")."(
						id INT AUTO_INCREMENT PRIMARY KEY,
						member INT,
						pub INT,
						FOREIGN KEY (member) REFERENCES ".self::table_name("member")."(id),
						FOREIGN KEY (pub) REFERENCES ".self::table_name("publication")." (id)
					);";
					$GLOBALS['wpdb']->query( $GLOBALS['wpdb']->escape( $sql ) );
	 	}

	 	if( $GLOBALS['wpdb']->get_var( "SHOW TABLES LIKE '".self::table_name("publication_project")."'") != self::table_name("publication_project")){
					$sql = "CREATE TABLE ".self::table_name("publication_project")." (
						id INT AUTO_INCREMENT PRIMARY KEY,
						project INT,
						pub INT,
						FOREIGN KEY (project) REFERENCES ".self::table_name("project")." (id),
						FOREIGN KEY (pub) REFERENCES ".self::table_name("publication")."(id)
					);";
					$GLOBALS['wpdb']->query( $GLOBALS['wpdb']->escape( $sql ) );
	 	}

	    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        return $first_install;
	}



    public static function drop_tables() {

	    $tables_to_drop = array(
	    'publication_member',
	    'publication_project',
		'publication',
		'pubtype',
	    'locale_agency',
	    'locale_position',
	    'locale_title',
	    'locale_project_description',
	    'locale_agency',
		'description',
	    'project_description',
	    'project_member',
	    'project',
	    'member',
	    'title',
	    'position',
	    'agency',
	    'locale'
	    );
	    foreach($tables_to_drop as $table_name){
		    $GLOBALS['wpdb']->query( "DROP TABLE IF EXISTS  " . self::table_name($table_name) );
	    }
    }




		/**
		 * Short Description. (use period)
		 *
		 * Long Description.
		 *
		 * @since    1.0.0
		 */
		 // TODO make this short. Take an array and populate stuff
		public static function  populate_tables() {
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
			$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "director"));
			$insert_id = $GLOBALS['wpdb']->insert_id;
			$GLOBALS['wpdb']->insert( self::table_name("locale_position") , array(
				'name' => "Director",
				'locale' => 1,
				'position' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( self::table_name("locale_position") , array(
				'name' => "Müdür",
				'locale' => 2,
				'position' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "vice-director"));
			$insert_id = $GLOBALS['wpdb']->insert_id;
			$GLOBALS['wpdb']->insert( self::table_name("locale_position") , array(
				'name' => "Vice Director",
				'locale' => 1,
				'position' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( self::table_name("locale_position"), array(
				'name' => "Yard. Müdür",
				'locale' => 2,
				'position' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "faculty"));
			$insert_id = $GLOBALS['wpdb']->insert_id;
			$GLOBALS['wpdb']->insert( self::table_name("locale_position") , array(
				'name' => "Faculty",
				'locale' => 1,
				'position' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( self::table_name("locale_position") , array(
				'name' => "Faculty",
				'locale' => 2,
				'position' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "assistant"));
			$insert_id = $GLOBALS['wpdb']->insert_id;
			$GLOBALS['wpdb']->insert( self::table_name("locale_position") , array(
				'name' => "Research Assistant",
				'locale' => 1,
				'position' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( self::table_name("locale_position") , array(
				'name' => "Ar Gör",
				'locale' => 2,
				'position' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "secretary"));
			$insert_id = $GLOBALS['wpdb']->insert_id;
			$GLOBALS['wpdb']->insert( self::table_name("locale_position") , array(
				'name' => "Secretary",
				'locale' => 1,
				'position' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( self::table_name("locale_position"), array(
				'name' => "Secretary",
				'locale' => 2,
				'position' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "technician"));
			$insert_id = $GLOBALS['wpdb']->insert_id;
			$GLOBALS['wpdb']->insert( self::table_name("locale_position") , array(
				'name' => "Technician",
				'locale' => 1,
				'position' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( self::table_name("locale_position") , array(
				'name' => "Technician",
				'locale' => 2,
				'position' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "collaborator"));
			$insert_id = $GLOBALS['wpdb']->insert_id;
			$GLOBALS['wpdb']->insert( self::table_name("locale_position") , array(
				'name' => "Collaborator",
				'locale' => 1,
				'position' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( self::table_name("locale_position") , array(
				'name' => "Collaborator",
				'locale' => 2,
				'position' => $insert_id)
			);


			/* Create titles*/
			$table_name = $GLOBALS['wpdb']->prefix . "wpri_title";
			$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "professor"));
			$GLOBALS['wpdb']->insert_id;
			$insert_id = $GLOBALS['wpdb']->insert_id;
			$GLOBALS['wpdb']->insert( self::table_name("locale_title") , array(
				'name' => "Prof.",
				'locale' => 1,
				'title' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( self::table_name("locale_title") , array(
				'name' => "Prof.",
				'locale' => 2,
				'title' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "associate-professor"));
			$insert_id = $GLOBALS['wpdb']->insert_id;
			$GLOBALS['wpdb']->insert( self::table_name("locale_title") , array(
				'name' => "Assoc. Prof.",
				'locale' => 1,
				'title' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( self::table_name("locale_title") , array(
				'name' => "Doç.",
				'locale' => 2,
				'title' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "assistant-professor"));
			$insert_id = $GLOBALS['wpdb']->insert_id;
			$GLOBALS['wpdb']->insert( self::table_name("locale_title") , array(
				'name' => "Assist. Prof.",
				'locale' => 1,
				'title' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( self::table_name("locale_title") , array(
				'name' => "Yard. Doç.",
				'locale' => 2,
				'title' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "doctor"));
			$insert_id = $GLOBALS['wpdb']->insert_id;
			$GLOBALS['wpdb']->insert( self::table_name("locale_title") , array(
				'name' => "Dr.",
				'locale' => 1,
				'title' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( self::table_name("locale_title") , array(
				'name' => "Dr.",
				'locale' => 2,
				'title' => $insert_id)
			);


			/* Create funding agencies*/
			$table_name = $GLOBALS['wpdb']->prefix . "wpri_agency";
			$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "tubitak"));
			$insert_id = $GLOBALS['wpdb']->insert_id;
			$GLOBALS['wpdb']->insert( self::table_name("locale_agency") , array(
				'name' => "TUBITAK",
				'locale' => 1,
				'agency' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( self::table_name("locale_agency") , array(
				'name' => "TÜBITAK",
				'locale' => 2,
				'agency' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "h2020"));
			$insert_id = $GLOBALS['wpdb']->insert_id;
			$GLOBALS['wpdb']->insert( self::table_name("locale_agency") , array(
				'name' => "Horizon 2020",
				'locale' => 1,
				'agency' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( self::table_name("locale_agency") , array(
				'name' => "Ufuk 2020",
				'locale' => 2,
				'agency' => $insert_id)
			);

		}


			/*
			* Query Functions
			*/

			/*
				For every item we need:
				1. get_wp_ITEM_ids()
				2. get_wp_ITEM(id)
				3. add_wp_ITEM
				4. delete_wp_ITEM(id)
				5. update_wp_ITEM(id)

				Items:
				1. Member
				2. Project
				3. Publication
				4. OpenPosition
			*/


			///////////////////////////
			// Helper
			///////////////////////////

			// TODO: Join instead of two calls
			public static function get_title($member_id, $locale) {
				$title_id = $GLOBALS['wpdb']->query(
					$GLOBALS['wpdb']->prepare(
						"SELECT title FROM " . self::table_name("member"). " WHERE id = %d", $member_id
					)
				);

				$title = $GLOBALS['wpdb']->query(
					$GLOBALS['wpdb']->prepare(
						"SELECT name FROM " . self::table_name("locale_title"). " WHERE title = %d AND locale= %d", 
						$title, $locale
					)
				); 

				return $title;
			}

			// TODO: Join instead of two calls
			public static function get_position($member_id, $locale) {
				$position_id = $GLOBALS['wpdb']->query(
					$GLOBALS['wpdb']->prepare(
						"SELECT position FROM " . self::table_name("member"). " WHERE id = %d", $member_id
					)
				);

				$position = $GLOBALS['wpdb']->query(
					$GLOBALS['wpdb']->prepare(
						"SELECT name FROM " . self::table_name("locale_position"). " WHERE position = %d AND locale= %d", 
						$title, $locale
					)
				); 

				return $position;
			}

			///////////////////////////
			// Member
			///////////////////////////

			// This should return full information, gathered from different tables
			public static function get_member($member_id, $locale) {
				$member_data = $GLOBALS['wpdb']->query(
					$GLOBALS['wpdb']->prepare(
						"SELECT * FROM " . self::table_name("member"). " WHERE id = %d", $member_id
					)
				);

				echo $member_data;
				echo $member_data->user ;
/*
				$member_user =  $member_data->user ;		
				$member_title = WPRI_Database::get_title($member_id, $locale)
				$member_website =
				$member_email =
				$member_avatar =
				$member_position = WPRI_Database::get_position($member_id, $locale)
				$member_displayname =
				$member_wppage =
				$member_alumni =
				$member_office =
				$member_phone =
				$member_advisor =
 
				$member = Array(
					"title" = $member_title ,
					"website" = $member_website,
					"email" = $member_email,
					"avatar" = $member_avatar,
					"position" = $member_position,
					"name" = $member_displayname,
					"wppage" = $member_wppage,
					"alumni" = $member_alumni,
					"office" = $member_office,
					"phone" = $member_phone,
					"advisor" = $member_advisor
					)
				return $member
*/
			}

			public static function get_wpri_member_ids() {

				return $GLOBALS['wpdb']->get_results("SELECT id FROM " . self::table_name("member") );
			}

			public static function add_wpri_member($member) {

			}

			public static function update_wpri_member($member_id) {

			}

			public static function delete_wpri_member($member_id) {

			}
			/////////////////////////////////////////////////////////////////////////////////
			/////////////////////////////////////////////////////////////////////////////////


			public static function get_wpri_projects() {
				return $GLOBALS['wpdb']->get_results("SELECT * FROM " . self::table_name("project") );
			}

			public static function get_wpri_project( $project_id) {

			}

			public static function add_wpri_project( $project) {
				$GLOBALS['wpdb']->insert( self::table_name("project"),
					array(
						'title' => $project["title"],
						'PI' => $project["PI"],
						'budget' => $project["budget"],
						'website' => $project["website"],
						'funding' => $project["funding"]
					)
				);


								// 	foreach ( $locales as $locale ) {
								// 	$GLOBALS['wpdb']->insert( $mixed_table_name , array(
								// 		'locale' => $locale->id,
								// 		$setting_name => $new_id,
								// 		'name' => $_POST["setting_name_" . $locale->id],
								// 	));
								// }
								//

				return $GLOBALS['wpdb']->insert_id;
			}

			public static function delete_wpri_project( $project_id) {

				// foreach ( $locales as $locale ) {
				// 	$GLOBALS['wpdb']->query( $GLOBALS['wpdb']->prepare(
				// 		"DELETE FROM $mixed_table_name WHERE $setting_name = %d", $_POST['setting_id']
				// 	));
				// }

				return $GLOBALS['wpdb']->query(
					$GLOBALS['wpdb']->prepare(
						"DELETE FROM " . self::table_name("project"). " WHERE id = %d", $project_id
					)
				);
			}

			public static function get_wpri_projects_by_member( $member_id) {

			}
			public static function get_wpri_locales() {
				return $GLOBALS['wpdb']->get_results("SELECT * FROM " . self::table_name("locale"));
			}

			public static function get_wpri_agencies() {
				return $GLOBALS['wpdb']->get_results("SELECT * FROM " . self::table_name("agency"));
			}

}

// public static function get_wp_user( $user_id) {
//
// }
// public static function get_wp_user_metadata( $user_id) {
//
// }
