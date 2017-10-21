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
 * Functions managing the database.
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
	 * Returns the full name of a table, adding the correct prefix.
	 *
	 * Returns the full name of a table, adding the correct prefix.
	 *
	 * @since    1.0.0
	 */
	public static function table_name($name){
		$wp_prefix = $GLOBALS['wpdb']->prefix;
		return $wp_prefix."wpri_".$name ;
	}



/******************************************************************************************
*******************************************************************************************
***************    Table definitions  *****************************************************
*******************************************************************************************
*******************************************************************************************/

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function create_tables() {

		$first_install = ( $GLOBALS['wpdb']->get_var( "SHOW TABLES LIKE '$table_name'") != $table_name );


		$settings_list = array('locale','position','title','agency','projectrole','role');
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
				role INT,
				name tinytext,
				FOREIGN KEY (role) REFERENCES ".self::table_name("role")."(id)
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




		// Project Description
		if( $GLOBALS['wpdb']->get_var( "SHOW TABLES LIKE '".self::table_name("project_description")."'") != self::table_name("project_description")){
					$sql = "CREATE TABLE  ".self::table_name("project_description")."(
						id INT AUTO_INCREMENT PRIMARY KEY,
						locale INT,
						project INT,
						description text,
						title text,
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
						role INT,
						FOREIGN KEY (member) REFERENCES ".self::table_name("member")."(id),
						FOREIGN KEY (project) REFERENCES ".self::table_name("project")."(id),
						FOREIGN KEY (role) REFERENCES ".self::table_name("projectrole")."(id)
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
		'locale_projectrole',
		'locale_role',
		'projectrole',
	    'project',
	    'member',
		'role',
	    'title',
	    'position',
	    'agency',
	    'locale'
	    );
	    foreach($tables_to_drop as $table_name){
		    $GLOBALS['wpdb']->query( "DROP TABLE IF EXISTS  " . self::table_name($table_name) );
	    }
    }



/******************************************************************************************
*******************************************************************************************
***************    Query Functions  *******************************************************
*******************************************************************************************
*******************************************************************************************/

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

				public static function get_title($user) {
					$locale=1;
	 		 		return  $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT name FROM " . self::table_name("locale_title"). " WHERE title = %d AND locale= %d",
							get_usermeta($user,'title'), $locale
						)
					)[0]->name;
				}

				public static function get_position($user) {
					$locale=1;
					return $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT name FROM " . self::table_name("locale_position"). " WHERE position = %d AND locale= %d",
							get_usermeta($user,'position'), $locale
						)
					)[0]->name;
				}

				// TODO decide what this should return if the advisor is not a user
				public static function get_advisor($user) {
					return 	get_usermeta($user,'advisor');
				}

				public static function get_projects_by_member($member) {
					$projects =  $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT * FROM " . self::table_name("project_member"). " WHERE member = %d",
							$member
						)
					);
					return $projects;
				}

				public static function get_publications_by_member($member) {
					return $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT * FROM " . self::table_name("publication_member"). " WHERE member = %d",
							$member
						)
					);
				}

				public static function get_roles() {
					$locale=1;

	 		 		return  $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT * FROM " . self::table_name("locale_role"). " WHERE locale= %d",
							$locale
						)
					);
				}

				public static function get_titles() {
					$locale=1;
	 		 		return  $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT * FROM " . self::table_name("locale_title"). " WHERE locale= %d",
							$locale
						)
					);
				}
				public static function get_positions() {
					$locale=1;
	 		 		return  $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT * FROM " . self::table_name("locale_position"). " WHERE locale= %d",
							$locale
						)
					);
				}

				public static function get_project_roles() {
					$locale=1;
	 		 		return  $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT * FROM " . self::table_name("locale_projectrole"). " WHERE locale= %d",
							$locale
						)
					);
				}

 				public static function get_member_from_user($user) {
					$member = $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT id FROM " . self::table_name("member"). " WHERE user = %d", $user
						)
					)[0];
					return $member;

				}

				///////////////////////////
				// Member
				///////////////////////////

				// For the thumbs in the faculty page
				public static function get_member_short($member_id) {
					$member = $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT * FROM " . self::table_name("member"). " WHERE id = %d", $member_id
						)
					)[0];
					$user = $member->user;
					return array(
						'user' => $user ,
						'title' => WPRI_Database::get_title($user),
						'website' => get_usermeta($user,'website'),
						'email' => get_usermeta($user,'email'),
						'position' => WPRI_Database::get_position($user),
						'name' =>  $member->name
					);
				}
				// This should return full information, gathered from different tables
				// For the main personal page
				public static function get_member($member_id) {
					$member = $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT * FROM " . self::table_name("member"). " WHERE id = %d", $member_id
						)
					)[0];
					$user = $member->user;

					return array(
						'user' => $user ,
						'name' =>  $member->name,
						'title' => WPRI_Database::get_title($user),
						'website' => get_usermeta($user,'website'),
						'email' => get_usermeta($user,'email'),
						'position' => WPRI_Database::get_position($user),
	 					'alumni' => get_usermeta($user,'alumni'),
						'office' => get_usermeta($user,'office'),
						'phone' => get_usermeta($user,'phone'),
						'advisor' =>  WPRI_Database::get_advisor(get_usermeta($user,'advisor')),
						'projects' => WPRI_Database::get_projects_by_member($member_id),
						'publications'=> WPRI_Database::get_publications_by_member($member_id)
					);
				}

				public static function get_member_ids() {
					$mids = $GLOBALS['wpdb']->get_results("SELECT id FROM " . self::table_name("member") );
					$ids = Array();
					foreach ( $mids as $id ) {
						array_push($ids,$id->id);
					}
					return $ids;
				}

				public static function add_member($member) {
					$GLOBALS['wpdb']->insert( self::table_name("member")  , $member);
					return $GLOBALS['wpdb']->insert_id;
				}

				public static function update_member($member_id,$member) {
					return $GLOBALS['wpdb']->update( self::table_name("member")  , $member, array('id' => $member_id) );
				}

				public static function delete_member($member_id) {
					return $GLOBALS['wpdb']->query(
						$GLOBALS['wpdb']->prepare(
							"DELETE FROM " . self::table_name("member") . " WHERE id = %d", $member_id)
						 );
				}

				public static function get_all_members() {
					return $GLOBALS['wpdb']->get_results("SELECT * FROM " . self::table_name("member") );
				}

				public static function member_participates_in_project_as($member,$project,$role) {

					return (0!=  $GLOBALS['wpdb']->query(
						$GLOBALS['wpdb']->prepare(
							"SELECT * FROM " . self::table_name("project_member"). " WHERE member = %d AND project = %d AND role = %d",
							 $member, $project, $role
						))
					);
				}
				/////////////////////////////////////////////////////////////////////////////////
				/////////////////////////////////////////////////////////////////////////////////


				public static function get_all_projects() {
					return $GLOBALS['wpdb']->get_results("SELECT * FROM " . self::table_name("project") );
				}

				public static function get_project( $project_id) {
					return $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT * FROM " . self::table_name("project"). " WHERE id = %d", $project_id
						)
					)[0];
 				}

				public static function add_project( $project) {
					$GLOBALS['wpdb']->insert( self::table_name("project"),
						array(
							'title' => $project["title"],
							'PI' => $project["PI"],
							'budget' => $project["budget"],
							'website' => $project["website"],
							'funding' => $project["funding"]
						)
					);
					$pid = $GLOBALS['wpdb']->insert_id;

					$locales = WPRI_Database::get_locales();
					foreach ( $locales as $locale ) {
						$GLOBALS['wpdb']->insert( self::table_name("project_description") , array(
							'locale' => $locale->id,
							'description' => $project["description"][$locale->id],
							'title' => $project["title"][$locale->id],
							'project' => $pid
						));
					}
	 				return $pid;
				}

				public static function add_project_member( $project, $member, $role) {

					return $GLOBALS['wpdb']->insert( self::table_name("project_member"),
						array(
							'project' => $project,
							'member' => $member,
							'role' => $role
						)
					);
				}

				public static function delete_project( $project_id) {

					$GLOBALS['wpdb']->query(
						$GLOBALS['wpdb']->prepare(
							"DELETE FROM " . self::table_name("project_description"). " WHERE project = %d", $project_id
						)
					);

					$GLOBALS['wpdb']->query(
						$GLOBALS['wpdb']->prepare(
							"DELETE FROM " . self::table_name("project_member"). " WHERE project = %d", $project_id
						)
					);

					$GLOBALS['wpdb']->query(
						$GLOBALS['wpdb']->prepare(
							"DELETE FROM " . self::table_name("publication_project"). " WHERE project = %d", $project_id
						)
					);

					return $GLOBALS['wpdb']->query(
						$GLOBALS['wpdb']->prepare(
							"DELETE FROM " . self::table_name("project"). " WHERE id = %d", $project_id
						)
					);
				}


				public static function get_locales() {
					return $GLOBALS['wpdb']->get_results("SELECT * FROM " . self::table_name("locale"));
				}

				public static function get_agencies() {
					return $GLOBALS['wpdb']->get_results("SELECT * FROM " . self::table_name("agency"));
				}



/******************************************************************************************
*******************************************************************************************
***************    Populate tables  *******************************************************
*******************************************************************************************
*******************************************************************************************/

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


			/* Create  roles*/
			$table_name = $GLOBALS['wpdb']->prefix . "wpri_role";
			$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "admin"));
			$insert_id = $GLOBALS['wpdb']->insert_id;
			$GLOBALS['wpdb']->insert( self::table_name("locale_role") , array(
				'name' => "admin",
				'locale' => 1,
				'role' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( self::table_name("locale_role") , array(
				'name' => "admin",
				'locale' => 2,
				'role' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "manager"));
			$insert_id = $GLOBALS['wpdb']->insert_id;
			$GLOBALS['wpdb']->insert( self::table_name("locale_role") , array(
				'name' => "manager",
				'locale' => 1,
				'role' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( self::table_name("locale_role") , array(
				'name' => "manager",
				'locale' => 2,
				'role' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "member"));
			$insert_id = $GLOBALS['wpdb']->insert_id;
			$GLOBALS['wpdb']->insert( self::table_name("locale_role") , array(
				'name' => "member",
				'locale' => 1,
				'role' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( self::table_name("locale_role") , array(
				'name' => "member",
				'locale' => 2,
				'role' => $insert_id)
			);

			/* Create project roles*/
			$table_name = self::table_name("projectrole");
			$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "PI"));
			$insert_id = $GLOBALS['wpdb']->insert_id;
			$GLOBALS['wpdb']->insert( self::table_name("locale_projectrole") , array(
				'name' => "Principal Investigator",
				'locale' => 1,
				'role' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( self::table_name("locale_projectrole") , array(
				'name' => "Yurutuncu",
				'locale' => 2,
				'role' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "researcher"));
			$insert_id = $GLOBALS['wpdb']->insert_id;
			$GLOBALS['wpdb']->insert( self::table_name("locale_projectrole") , array(
				'name' => "Researcher",
				'locale' => 1,
				'role' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( self::table_name("locale_projectrole") , array(
				'name' => "Arastirmaci",
				'locale' => 2,
				'role' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "advisor"));
			$insert_id = $GLOBALS['wpdb']->insert_id;
			$GLOBALS['wpdb']->insert( self::table_name("locale_projectrole") , array(
				'name' => "Advisor",
				'locale' => 1,
				'role' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( self::table_name("locale_projectrole") , array(
				'name' => "Advisor",
				'locale' => 2,
				'role' => $insert_id)
			);



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

}

// public static function get_wp_user( $user_id) {
//
// }
// public static function get_wp_user_metadata( $user_id) {
//
// }
