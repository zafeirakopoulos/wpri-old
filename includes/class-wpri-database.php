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
		self::drop_tables();

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
		if( $GLOBALS['wpdb']->get_var( "SHOW TABLES LIKE '$this->member_table_name'") != $this->member_table_name ){
			$sql = "CREATE TABLE  $this->member_table_name (
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
	  			FOREIGN KEY (position) REFERENCES $this->le_name(id),
	  			FOREIGN KEY (title) REFERENCES $this->title_table_name(id)
				);";
			$GLOBALS['wpdb']->query( $GLOBALS['wpdb']->escape( $sql ) );
		}



		// Projects

		if( $GLOBALS['wpdb']->get_var( "SHOW TABLES LIKE '$this->project_table_name'") != $this->project_table_name ){
			$sql = "CREATE TABLE  $this->project_table_name (
				id INT AUTO_INCREMENT PRIMARY KEY,
				title tinytext,
				PI INT,
				budget INT,
				website tinytext,
				funding INT,
	 			FOREIGN KEY (PI) REFERENCES $this->member_table_name(id),
	 			FOREIGN KEY (funding) REFERENCES $this->agency_table_name(id)
				);";
			$GLOBALS['wpdb']->query( $GLOBALS['wpdb']->escape( $sql ) );
		}



		// Description
		if( $GLOBALS['wpdb']->get_var( "SHOW TABLES LIKE '$this->description_table_name'") != $this->description_table_name){
					$sql = "CREATE TABLE  $this->description_table_name(
						id INT AUTO_INCREMENT PRIMARY KEY,
						locale INT,
						project INT,
						description text,
						FOREIGN KEY (locale) REFERENCES $this->locale_table_name(id),
						FOREIGN KEY (project) REFERENCES $this->project_table_name(id)
					);";
					$GLOBALS['wpdb']->query( $GLOBALS['wpdb']->escape( $sql ) );
	 	}


	// Project Members
	 	if( $GLOBALS['wpdb']->get_var( "SHOW TABLES LIKE '$this->pr_mem_table_name'") != $this->pr_mem_table_name){
					$sql = "CREATE TABLE  $this->pr_mem_table_name(
						id INT AUTO_INCREMENT PRIMARY KEY,
						member INT,
						project INT,
						position INT,
						FOREIGN KEY (member) REFERENCES $this->member_table_name(id),
						FOREIGN KEY (project) REFERENCES $this->project_table_name(id),
						FOREIGN KEY (position) REFERENCES $this->le_name(id)
					);";
					$GLOBALS['wpdb']->query( $GLOBALS['wpdb']->escape( $sql ) );
	 	}



		// Publications
		if( $GLOBALS['wpdb']->get_var( "SHOW TABLES LIKE '$this->pubtype_table_name'") != $this->pubtype_table_name ){
			$sql = "CREATE TABLE  $this->pubtype_table_name (
				id INT AUTO_INCREMENT PRIMARY KEY,
				name tinytext
				);";
			$GLOBALS['wpdb']->query( $GLOBALS['wpdb']->escape( $sql ) );
		}


		if( $GLOBALS['wpdb']->get_var( "SHOW TABLES LIKE '$this->publication_table_name'") != $this->publication_table_name){
			$sql = "CREATE TABLE  $this->publication_table_name (
				id INT AUTO_INCREMENT PRIMARY KEY,
				type INT,
				title text,
				doi tinytext,
				international boolean,
				refereed boolean,
				bibentry text,
	 			FOREIGN KEY (type) REFERENCES $this->pubtype_table_name(id)
				);";
			$GLOBALS['wpdb']->query( $GLOBALS['wpdb']->escape( $sql ) );
		}



	 	if( $GLOBALS['wpdb']->get_var( "SHOW TABLES LIKE '$this->pub_mem_table_name'") != $this->pub_mem_table_name ){
					$sql = "CREATE TABLE  $this->pub_mem_table_name(
						id INT AUTO_INCREMENT PRIMARY KEY,
						member INT,
						pub INT,
						FOREIGN KEY (member) REFERENCES $this->member_table_name(id),
						FOREIGN KEY (pub) REFERENCES $this->publication_table_name (id)
					);";
					$GLOBALS['wpdb']->query( $GLOBALS['wpdb']->escape( $sql ) );
	 	}

	 	if( $GLOBALS['wpdb']->get_var( "SHOW TABLES LIKE '$this->pub_project_table_name'") != $this->pub_project_table_name){
					$sql = "CREATE TABLE  $this->pub_project_table_name (
						id INT AUTO_INCREMENT PRIMARY KEY,
						project INT,
						pub INT,
						FOREIGN KEY (project) REFERENCES $this->project_table_name (id),
						FOREIGN KEY (pub) REFERENCES $this->publication_table_name (id)
					);";
					$GLOBALS['wpdb']->query( $GLOBALS['wpdb']->escape( $sql ) );
	 	}

	    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        return $first_install;
	}



    public static function drop_tables() {

	    $tables_to_drop = array(
	    'pub_member',
	    'pub_project',
	    'publication',
	    'pubtype',
	    'locale_agency',
	    'locale_position',
	    'locale_title',
	    'locale_project_description',
	    'locale_agency',
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

	/*
	* Query Functions
	*/

	public static function get_wp_user( $user_id) {

	}
	public static function get_wp_user_metadata( $user_id) {

	}
	public static function get_wpri_member( $member_id) {

	}
	public static function get_wpri_members() {

	}
	public static function get_wpri_projects() {

	}
	public static function get_wp_project( $project_id) {

	}
	public static function get_wpri_projects_by_member( $member_id) {

	}
	public static function get_wpri_locales() {

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
			$GLOBALS['wpdb']->insert( $this->$locale_position_table_name , array(
				'name' => "Director",
				'locale' => 1,
				'position' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $this->$locale_position_table_name , array(
				'name' => "Müdür",
				'locale' => 2,
				'position' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "vice-director"));
			$insert_id = $GLOBALS['wpdb']->insert_id;
			$GLOBALS['wpdb']->insert( $this->$locale_position_table_name , array(
				'name' => "Vice Director",
				'locale' => 1,
				'position' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $this->$locale_position_table_name, array(
				'name' => "Yard. Müdür",
				'locale' => 2,
				'position' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "faculty"));
			$insert_id = $GLOBALS['wpdb']->insert_id;
			$GLOBALS['wpdb']->insert( $this->$locale_position_table_name , array(
				'name' => "Faculty",
				'locale' => 1,
				'position' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $this->$locale_position_table_name , array(
				'name' => "Faculty",
				'locale' => 2,
				'position' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "assistant"));
			$insert_id = $GLOBALS['wpdb']->insert_id;
			$GLOBALS['wpdb']->insert( $this->$locale_position_table_name , array(
				'name' => "Research Assistant",
				'locale' => 1,
				'position' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $this->$locale_position_table_name , array(
				'name' => "Ar Gör",
				'locale' => 2,
				'position' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "secretary"));
			$insert_id = $GLOBALS['wpdb']->insert_id;
			$GLOBALS['wpdb']->insert( $this->$locale_position_table_name , array(
				'name' => "Secretary",
				'locale' => 1,
				'position' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $this->$locale_position_table_name, array(
				'name' => "Secretary",
				'locale' => 2,
				'position' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "technician"));
			$insert_id = $GLOBALS['wpdb']->insert_id;
			$GLOBALS['wpdb']->insert( $this->$locale_position_table_name , array(
				'name' => "Technician",
				'locale' => 1,
				'position' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $this->$locale_position_table_name , array(
				'name' => "Technician",
				'locale' => 2,
				'position' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "collaborator"));
			$insert_id = $GLOBALS['wpdb']->insert_id;
			$GLOBALS['wpdb']->insert( $this->$locale_position_table_name , array(
				'name' => "Collaborator",
				'locale' => 1,
				'position' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $this->$locale_position_table_name , array(
				'name' => "Collaborator",
				'locale' => 2,
				'position' => $insert_id)
			);


			/* Create titles*/
			$table_name = $GLOBALS['wpdb']->prefix . "wpri_title";
			$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "professor"));
			$GLOBALS['wpdb']->insert_id;
			$insert_id = $GLOBALS['wpdb']->insert_id;
			$GLOBALS['wpdb']->insert( $this->locale_title_table_name , array(
				'name' => "Prof.",
				'locale' => 1,
				'title' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $this->locale_title_table_name , array(
				'name' => "Prof.",
				'locale' => 2,
				'title' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "associate-professor"));
			$insert_id = $GLOBALS['wpdb']->insert_id;
			$GLOBALS['wpdb']->insert( $this->locale_title_table_name , array(
				'name' => "Assoc. Prof.",
				'locale' => 1,
				'title' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $this->locale_title_table_name , array(
				'name' => "Doç.",
				'locale' => 2,
				'title' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "assistant-professor"));
			$insert_id = $GLOBALS['wpdb']->insert_id;
			$GLOBALS['wpdb']->insert( $this->locale_title_table_name , array(
				'name' => "Assist. Prof.",
				'locale' => 1,
				'title' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $this->locale_title_table_name , array(
				'name' => "Yard. Doç.",
				'locale' => 2,
				'title' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "doctor"));
			$insert_id = $GLOBALS['wpdb']->insert_id;
			$GLOBALS['wpdb']->insert( $this->locale_title_table_name , array(
				'name' => "Dr.",
				'locale' => 1,
				'title' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $this->locale_title_table_name , array(
				'name' => "Dr.",
				'locale' => 2,
				'title' => $insert_id)
			);


			/* Create funding agencies*/
			$table_name = $GLOBALS['wpdb']->prefix . "wpri_agency";
			$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "tubitak"));
			$insert_id = $GLOBALS['wpdb']->insert_id;
			$GLOBALS['wpdb']->insert( $this->locale_agency_table_name , array(
				'name' => "TUBITAK",
				'locale' => 1,
				'agency' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $this->locale_agency_table_name , array(
				'name' => "TÜBITAK",
				'locale' => 2,
				'agency' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "h2020"));
			$insert_id = $GLOBALS['wpdb']->insert_id;
			$GLOBALS['wpdb']->insert( $this->locale_agency_table_name , array(
				'name' => "Horizon 2020",
				'locale' => 1,
				'agency' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $this->locale_agency_table_name , array(
				'name' => "Ufuk 2020",
				'locale' => 2,
				'agency' => $insert_id)
			);

		}
}
