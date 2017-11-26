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

		if ($name=="user"){
			return $wp_prefix."users" ;

		}else{
			return $wp_prefix."wpri_".$name ;
		}
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

		$declarations = WPRI_Declarations::get_declarations();

 		foreach ($declarations as $entity_name => $entity) {
			# Create the table
			if( $GLOBALS['wpdb']->get_var( "SHOW TABLES LIKE '".self::table_name($entity_name)."'") != self::table_name($entity_name) ){
				// error_log("Creating table ".$entity_name);
				$sql = "CREATE TABLE ".self::table_name($entity_name)." ( id INT AUTO_INCREMENT PRIMARY KEY";
				foreach ($entity["groups"] as $group ) {
					foreach ($group["elements"] as $element ) {
						if ($element["type"]== "select"){
							if ($element["name"]=="user"){
								$sql = $sql .  ", ". $element["name"] ." bigint(20) unsigned";
							}
							else{
								$sql = $sql .  ", ". $element["name"] ." INT";
							}
							$sql = $sql .  ", FOREIGN KEY (". $element["name"] .") REFERENCES ".self::table_name($element["table"])."(".$element["column"].")";
						}
						elseif (isset($element["localized"]) ){
							$sql = $sql .  ", ".  $element["name"] ." INT";
						}
						elseif ($element["type"]!= "multiple-select"){
							$sql = $sql .  ", ".  $element["name"] ." ". $element["type"];
						}
					}
				}
				$sql = $sql . ");";

			    // error_log($sql);
				$GLOBALS['wpdb']->query( $GLOBALS['wpdb']->query( $sql ) );
			}
			# Create locale_* tables for all_locales elements
			$with_all_locales=false;
			foreach ($entity["groups"] as $group ) {
				# One table with different "name" attributes
				foreach ($group["elements"] as $element ) {
					// if (isset($element["all_locales"]) && ($element["all_locales"]==true)){
					if (isset($element["all_locales"]) ){
						$with_all_locales=true;
					}
				}
			}
			if ($with_all_locales==true){
				$sql = "CREATE TABLE ".self::table_name("locale_".$entity_name)." ( id INT AUTO_INCREMENT PRIMARY KEY,	locale INT,	";
				$sql = $sql .  $element["name"] ." INT,";
				$sql = $sql .  "name ". $element["type"] .",";
				$sql = $sql .  "FOREIGN KEY (locale) REFERENCES ".self::table_name("locale")."(id),";
				$sql = $sql .  "FOREIGN KEY (". $element["name"] .") REFERENCES ".self::table_name($element["name"])."(id)";
				$sql = $sql . ");";
				// error_log($sql);
				$GLOBALS['wpdb']->query( $GLOBALS['wpdb']->query( $sql ) );
			}

			# Create locale_entity_element tables for localized elements
 			foreach ($entity["groups"] as $group ) {
				# One table with different "name" attributes
				foreach ($group["elements"] as $element ) {
					// if (isset($element["all_locales"]) && ($element["all_locales"]==true)){
					if (isset($element["localized"]) ){
						$sql = "CREATE TABLE ".self::table_name("locale_".$entity_name."_".$element["name"] )." ( id INT AUTO_INCREMENT PRIMARY KEY,	locale INT,	";
						$sql = $sql .  $element["name"] ." INT,";
						$sql = $sql .  "name ". $element["type"] .",";
						$sql = $sql .  "FOREIGN KEY (locale) REFERENCES ".self::table_name("locale")."(id),";
						$sql = $sql .  "FOREIGN KEY (". $element["name"] .") REFERENCES ".self::table_name($entity_name)."(".$element["name"].")";
						$sql = $sql . ");";
						// error_log($sql);
						$GLOBALS['wpdb']->query( $GLOBALS['wpdb']->query( $sql ) );
					}
				}
			}

		}

		// elseif ($element["type"]== "multiple-select"){
		// 	// echo "it is a relation";
		// }

	    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		return 0; #first install
	}



    public static function drop_tables() {

		$declarations = WPRI_Declarations::get_declarations();

	    $tables_to_drop = array();

		foreach ($declarations as $entity_name => $entity) {
			# Drop the table
			array_push($tables_to_drop,$entity_name);

			# Drop locale_* tables for all_locales elements
			$with_all_locales=false;
			foreach ($entity["groups"] as $group ) {
				# One table with different "name" attributes
				foreach ($group["elements"] as $element ) {
					// if (isset($element["all_locales"]) && ($element["all_locales"]==true)){
					if (isset($element["all_locales"]) ){
						$with_all_locales=true;
					}
				}
			}
			if ($with_all_locales==true){
				array_push($tables_to_drop,"locale_".$entity_name);
			}

		}

		$tables_to_drop = array_reverse($tables_to_drop);
		error_log("tables_to_drop ".implode($tables_to_drop));
		// array_push($tables_to_drop,"institute_info");

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


#################################################################################################
#################################################################################################
#################################################################################################
#################################################################################################
#################################################################################################
#################################################################################################
#################################################################################################

	public static function get_localized($table,$id) {
	 		$results=  $GLOBALS['wpdb']->get_results(
			$GLOBALS['wpdb']->prepare(
				"SELECT name FROM " . self::table_name("locale_".$table). " WHERE ".$table." = %d AND locale= %d",
				$id, $_SESSION['locale']
			)
		);
		return $results[0]->name;
	}

	# The associcative array names is of the form locale_id => "translated name of table[id]"
	public static function add_localized($table,$item,$names) {
		$GLOBALS['wpdb']->insert( self::table_name($table) , array( 'name' => $item ) );
		$new_id = $GLOBALS['wpdb']->insert_id;
		$success = $new_id;

			foreach ( WPRI_Database::get_locales() as $locale ) {
			$GLOBALS['wpdb']->insert( self::table_name("locale_".$table) , array(
				'locale' => $locale->id,
				$table => $new_id,
				'name' => $names[$locale->id]
			));
			$success = $success * $GLOBALS['wpdb']->insert_id;
		}
		if (!$success){
			# TODO Delete what was added
		}
		return $success;
	}

	public static function delete_localized($table,$id) {
			foreach ( WPRI_Database::get_locales() as $locale ) {
			$success = $GLOBALS['wpdb']->query(
				$GLOBALS['wpdb']->prepare(
					"DELETE FROM " . self::table_name("locale_".$table). " WHERE ".$table." = %d", $id
				)
			);
		}

		$success = $GLOBALS['wpdb']->query(
			$GLOBALS['wpdb']->prepare(
				"DELETE FROM " . self::table_name($table). " WHERE id = %d", $id
			)
		);

		return $success;
	}



#################################################################################################
#################################################################################################
#################################################################################################
#################################################################################################
#################################################################################################
#################################################################################################
#################################################################################################

				public static function get_title($user) {
	 		 		$titles=  $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT name FROM " . self::table_name("locale_title"). " WHERE title = %d AND locale= %d",
							get_usermeta($user,'title'), $_SESSION['locale']
						)
					);
					return $titles[0]->name;
				}

				public static function get_status($status) {
	 		 		$statuses =  $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT name FROM " . self::table_name("locale_project_status"). " WHERE project_status = %d AND locale= %d",
							$status, $_SESSION['locale']
						)
					);
					return $statuses[0]->name;
				}


				public static function get_requirement($requirement) {
	 		 		return  $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT name FROM " . self::table_name("locale_position_requirement"). " WHERE position_requirement = %d AND locale= %d",
							$requirement, $_SESSION['locale']
						)
					)[0]->name;
				}

				public static function get_funding_agency($agency) {
					return  $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT name FROM " . self::table_name("locale_agency"). " WHERE agency = %d AND locale= %d",
							$agency, $_SESSION['locale']
						)
					)[0]->name;
				}


				public static function get_project_role($role) {
	 		 		return  $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT name FROM " . self::table_name("locale_projectrole"). " WHERE projectrole = %d AND locale= %d",
							$role, $_SESSION['locale']
						)
					)[0]->name;
				}


				public static function get_position($user) {
					return $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT name FROM " . self::table_name("locale_position"). " WHERE position = %d AND locale= %d",
							get_usermeta($user,'position'), $_SESSION['locale']
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

				public static function get_open_position_ids_by_member($member) {
					$pids =  $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT position FROM " . self::table_name("open_position_contact"). " WHERE member = %d",
							$member
						)
					);
					$ids = Array();
					foreach ( $pids as $id ) {
						array_push($ids,$id->position);
					}
					return $ids;
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
	 		 		return  $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT * FROM " . self::table_name("locale_role"). " WHERE locale= %d",
							$_SESSION['locale']
						)
					);
				}

				public static function get_titles() {
	 		 		return  $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT * FROM " . self::table_name("locale_title"). " WHERE locale= %d",
							$_SESSION['locale']
						)
					);
				}
				public static function get_positions() {
	 		 		return  $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT * FROM " . self::table_name("locale_position"). " WHERE locale= %d",
							$_SESSION['locale']
						)
					);
				}

				public static function get_project_roles() {
	 		 		return  $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT * FROM " . self::table_name("locale_projectrole"). " WHERE locale= %d",
							$_SESSION['locale']
						)
					);
				}

				public static function get_publication_types() {
	 		 		return  $GLOBALS['wpdb']->get_results(
							"SELECT * FROM " . self::table_name("pubtype")
					);
				}

				public static function get_project_statuses() {
	 		 		return  $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT * FROM " . self::table_name("locale_project_status"). " WHERE locale= %d",
							$_SESSION['locale']
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

				// For the thumbs in the publications page
				public static function get_publication_short($publication_id) {
					$publication = $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT * FROM " . self::table_name("publication"). " WHERE id = %d", $publication_id
						)
					)[0];
					return array(
						'title' => $publication->title,
					);
				}


				public static function get_publication_full($publication_id) {
					$publication = $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT * FROM " . self::table_name("publication"). " WHERE id = %d", $publication_id
						)
					)[0];

					$authors = WPRI_Database::get_publication_authors($publication_id);
					$projects = WPRI_Database::get_publication_projects($publication_id);
					return array(
						'title' => $publication->title,
						'pubtype' => $publication->pubtype,
						'doi' => $publication->doi,
						'international' => $publication->international,
						'refereed' => $publication->refereed,
						'bibentry' => $publication->bibentry,
						'authors' => $authors,
						'projects' => $projects,
					);
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

				public static function get_locale_project_description($project_id) {
					return  $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT * FROM " . self::table_name("project_description"). " WHERE locale= %d AND project= %d",
							$_SESSION['locale'], $project_id
						)
					);
				}


 				public static function get_project_pi($project_id) {
					// Choose from users or collaborators
					return "TODO";

				}

				// For the thumbs in the projects page
				public static function get_project_short($project_id) {
					$project = $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT * FROM " . self::table_name("project"). " WHERE id = %d", $project_id
						)
					)[0];
					$project_locale_data = WPRI_Database::get_locale_project_description($project_id);
					return array(
						'title' => $project->title,
						'locale_title' => $project_locale_data->title,
						'locale_description' => $project_locale_data->description,
						'PI' => WPRI_Database::get_project_pi($project->pi, $project_id),
						'status' => WPRI_Database::get_status($project->status),
					);
				}

				// This should return full information, gathered from different tables
				// For the main project page
				public static function get_project_full($project_id) {
					$project = $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT * FROM " . self::table_name("project"). " WHERE id = %d", $project_id
						)
					)[0];
					$project_locale_data = WPRI_Database::get_locale_project_description($project_id);
					return array(
						'title' => $project->title,
						'locale_title' => $project_locale_data->title,
						'locale_description' => $project_locale_data->description,
						'PI' => WPRI_Database::get_project_pi($project->pi, $project_id),
						'budget' => $project->budget,
						'website' => $project->website,
						'startdate' => $project->startdate,
						'enddate' => $project->enddate,
						'status' => WPRI_Database::get_status($project->status),
						'funding' =>  WPRI_Database::get_funding_agency($project->funding)
					);
				}

				public static function get_project_ids() {
					$pids = $GLOBALS['wpdb']->get_results("SELECT id FROM " . self::table_name("project") );
					$ids = Array();
					foreach ( $pids as $id ) {
						array_push($ids,$id->id);
					}
					return $ids;
				}

				public static function get_publication_ids() {
					$pids = $GLOBALS['wpdb']->get_results("SELECT id FROM " . self::table_name("publication") );
					$ids = Array();
					foreach ( $pids as $id ) {
						array_push($ids,$id->id);
					}
					return $ids;
				}
				public static function add_member($member) {
					$GLOBALS['wpdb']->insert( self::table_name("member")  , $member);
					return $GLOBALS['wpdb']->insert_id;
				}




				public static function delete_member($member_id) {
					$projects = WPRI_Database::get_projects_by_member($member_id);
					foreach ($projects as $project){
						WPRI_Database::delete_project_member($project->id,$member_id);
					}

					$open_positions = WPRI_Database::get_open_position_ids_by_member($member_id);
					foreach ($open_positions as $position){
						WPRI_Database::delete_position_contact($position,$member_id);
					}

					return $GLOBALS['wpdb']->query(
						$GLOBALS['wpdb']->prepare(
							"DELETE FROM " . self::table_name("member") . " WHERE id = %d", $member_id)
						 );
				}

				public static function get_all($table) {
					return $GLOBALS['wpdb']->get_results("SELECT * FROM " . self::table_name($table),"ARRAY_A" );
				}

				public static function get_all_members() {
					return $GLOBALS['wpdb']->get_results("SELECT * FROM " . self::table_name("member") );
				}

				public static function get_project_members($project_id) {
					return  $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT * FROM " . self::table_name("project_member"). " WHERE project = %d",
							 $project_id
						)
					);
 				}

				public static function get_member_publications($member_id) {
					return  $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT * FROM " . self::table_name("publication_member"). " WHERE member = %d",
							 $member_id
						)
					);
 				}

				public static function get_publication_authors($pub_id) {
					return  $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT * FROM " . self::table_name("publication_member"). " WHERE pub = %d",
							 $pub_id
						)
					);
 				}

				public static function get_project_publications($project_id) {
					return  $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT * FROM " . self::table_name("publication_project"). " WHERE project = %d",
							 $project_id
						)
					);
 				}

				public static function get_publication_projects($pub_id) {
					return  $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT * FROM " . self::table_name("publication_project"). " WHERE pub = %d",
							 $pub_id
						)
					);
				}

				public static function member_participates_in_project_as($member,$project,$role) {

					return (0!=  $GLOBALS['wpdb']->query(
						$GLOBALS['wpdb']->prepare(
							"SELECT * FROM " . self::table_name("project_member"). " WHERE member = %d AND project = %d AND role = %d",
							 $member, $project, $role
						))
					);
				}

				public static function get_all_open_positions() {
					return $GLOBALS['wpdb']->get_results("SELECT * FROM " . self::table_name("open_position") );
				}

				/////////////////////////////////////////////////////////////////////////////////
				/////////////////////////////////////////////////////////////////////////////////

				public static function get_all_publications() {
					return $GLOBALS['wpdb']->get_results("SELECT * FROM " . self::table_name("publication") );
				}

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

				public static function get_publication( $publication_id) {
					return $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT * FROM " . self::table_name("publication"). " WHERE id = %d", $publication_id
						)
					)[0];
 				}

				public static function add_publication($publication) {
				$GLOBALS['wpdb']->insert( self::table_name("publication"),
					array(
						'title' => $publication["title"],
						'pubtype' => $publication["type"],
						'doi' => $publication["doi"],
						'international' => $publication["international"],
						'refereed' => $publication["refereed"],
						'bibentry' => $publication["bibentry"],
					)
				);
				$pid = $GLOBALS['wpdb']->insert_id;

				return $pid;
				}

				public static function add_open_position($position) {
					$GLOBALS['wpdb']->insert( self::table_name("open_position"),
						array(
							'title' => $position["title"],
							'postype' => $position["type"],
							'startdate' => $position["startdate"],
							'enddate' => $position["enddate"],
							'agency' => $position["agency"],
							'description' => $position["description"],
							'deadline' => $position["deadline"]
						)
					);
					$pid = $GLOBALS['wpdb']->insert_id;

					return $pid;
				}
				public static function get_open_position_ids() {
					$mids = $GLOBALS['wpdb']->get_results("SELECT id FROM " . self::table_name("open_position") );
					$ids = Array();
					foreach ( $mids as $id ) {
						array_push($ids,$id->id);
					}
					return $ids;
				}


				public static function get_open_position($position_id) {
					$position= $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT * FROM " . self::table_name("open_position"). " WHERE id = %d", $position_id
						)
					)[0];

					return array(
						'title' => $position->title,
						'postype' => $position->type,
						'startdate' => $position->startdate,
						'enddate' => $position->enddate,
						'agency' => $position->agency,
						'description' => $position->description,
						'deadline' => $position->deadline,
						'projects' => WPRI_Database::get_open_position_projects($position_id),
						'contacts' => WPRI_Database::get_open_position_contacts($position_id),
						'requirements' => WPRI_Database::get_open_position_requirements($position_id)
					);
				}


				public static function add_open_position_contact( $member, $position) {
					return $GLOBALS['wpdb']->insert( self::table_name("open_position_contact"),
						array(
							'position' => $position,
							'member' => $member,
						)
					);
				}

				public static function get_open_position_contacts($position_id) {
					return $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT * FROM " . self::table_name("open_position_contact"). " WHERE position = %d", $position_id
						)
					);
				}

				public static function add_open_position_requirement( $requirement, $position) {
					return $GLOBALS['wpdb']->insert( self::table_name("open_position_requirement"),
						array(
							'position' => $position,
							'requirement' => $requirement,
						)
					);
				}

				public static function get_open_position_requirements($position_id) {
					return $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT * FROM " . self::table_name("open_position_requirement"). " WHERE position = %d", $position_id
						)
					);
				}

				public static function get_position_requirement($requirement_id) {
					return $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT name FROM " . self::table_name("position_requirement"). " WHERE position = %d", $requirement_id
						)
					)[0];
				}

				public static function add_open_position_project( $project, $position) {
					return $GLOBALS['wpdb']->insert( self::table_name("open_position_project"),
						array(
							'position' => $position,
							'project' => $project,
						)
					);
				}

				public static function get_open_position_projects($position_id) {
					return $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT * FROM " . self::table_name("open_position_project"). " WHERE position = %d", $position_id
						)
					);
				}


				public static function add_project( $project) {
					$GLOBALS['wpdb']->insert( self::table_name("project"),
						array(
							'title' => $project["title"],
							'PI' => $project["PI"],
							'budget' => $project["budget"],
							'website' => $project["website"],
							'funding' => $project["funding"],
							'startdate' => $project["startdate"],
							'enddate' => $project["enddate"],
							'status' => $project["status"]
						)
					);
					$pid = $GLOBALS['wpdb']->insert_id;

					$locales = WPRI_Database::get_locales();
					foreach ( $locales as $locale ) {
						$GLOBALS['wpdb']->insert( self::table_name("project_description") , array(
							'locale' => $locale["id"],
							'description' => $project["description"][$locale["id"]],
							'title' => $project["title"][$locale["id"]],
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

				public static function delete_project_member($project, $member) {
					return $GLOBALS['wpdb']->query(
						$GLOBALS['wpdb']->prepare(
							"DELETE FROM " . self::table_name("project_member"). " WHERE project = %d AND member= %d",
							$project_id, $member
						)
					);
				}



				public static function delete_position_contact($position,$member) {
					return $GLOBALS['wpdb']->query(
						$GLOBALS['wpdb']->prepare(
							"DELETE FROM " . self::table_name("open_position_contact"). " WHERE position = %d AND member= %d",
							$position, $member
						)
					);
				}
				public static function add_project_publication( $project, $publication) {
					return $GLOBALS['wpdb']->insert( self::table_name("publication_project"),
						array(
							'project' => $project,
							'pub' => $publication,
						)
					);
				}


				public static function add_member_publication( $member, $publication) {
					return $GLOBALS['wpdb']->insert( self::table_name("publication_member"),
						array(
							'member' => $member,
							'pub' => $publication,
						)
					);
				}


				public static function add_agency_publication( $agency, $publication) {
					return $GLOBALS['wpdb']->insert( self::table_name("publication_agency"),
						array(
							'agency' => $agency,
							'pub' => $publication,
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


				public static function delete_open_position($position_id) {

					$GLOBALS['wpdb']->query(
						$GLOBALS['wpdb']->prepare(
							"DELETE FROM " . self::table_name("open_position_project"). " WHERE position = %d", $position_id
						)
					);

					$GLOBALS['wpdb']->query(
						$GLOBALS['wpdb']->prepare(
							"DELETE FROM " . self::table_name("open_position_contact"). " WHERE position = %d", $position_id
						)
					);

					$GLOBALS['wpdb']->query(
						$GLOBALS['wpdb']->prepare(
							"DELETE FROM " . self::table_name("open_position_requirement"). " WHERE position = %d", $position_id
						)
					);

					return $GLOBALS['wpdb']->query(
						$GLOBALS['wpdb']->prepare(
							"DELETE FROM " . self::table_name("open_position"). " WHERE id = %d", $position_id
						)
					);
				}

				public static function get_locales() {
					return $GLOBALS['wpdb']->get_results("SELECT * FROM " . self::table_name("locale"),"ARRAY_A");
				}

				public static function get_agencies() {
					return $GLOBALS['wpdb']->get_results("SELECT * FROM " . self::table_name("agency"));
				}

				public static function get_requirements() {
					return $GLOBALS['wpdb']->get_results("SELECT * FROM " . self::table_name("position_requirement"));
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
			return 0;
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
				'projectrole' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( self::table_name("locale_projectrole") , array(
				'name' => "Yurutuncu",
				'locale' => 2,
				'projectrole' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "researcher"));
			$insert_id = $GLOBALS['wpdb']->insert_id;
			$GLOBALS['wpdb']->insert( self::table_name("locale_projectrole") , array(
				'name' => "Researcher",
				'locale' => 1,
				'projectrole' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( self::table_name("locale_projectrole") , array(
				'name' => "Arastirmaci",
				'locale' => 2,
				'projectrole' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "advisor"));
			$insert_id = $GLOBALS['wpdb']->insert_id;
			$GLOBALS['wpdb']->insert( self::table_name("locale_projectrole") , array(
				'name' => "Advisor",
				'locale' => 1,
				'projectrole' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( self::table_name("locale_projectrole") , array(
				'name' => "Advisor",
				'locale' => 2,
				'projectrole' => $insert_id)
			);

			/* Create project status*/
			$table_name = self::table_name("project_status");
			$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "ongoing"));
			$insert_id = $GLOBALS['wpdb']->insert_id;
			$GLOBALS['wpdb']->insert( self::table_name("locale_project_status") , array(
				'name' => "ongoing",
				'locale' => 1,
				'project_status' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( self::table_name("locale_project_status") , array(
				'name' => "ongoing",
				'locale' => 2,
				'project_status' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "ended"));
			$insert_id = $GLOBALS['wpdb']->insert_id;
			$GLOBALS['wpdb']->insert( self::table_name("locale_project_status") , array(
				'name' => "ended",
				'locale' => 1,
				'project_status' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( self::table_name("locale_project_status") , array(
				'name' => "ended",
				'locale' => 2,
				'project_status' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "submitted"));
			$insert_id = $GLOBALS['wpdb']->insert_id;
			$GLOBALS['wpdb']->insert( self::table_name("locale_project_status") , array(
				'name' => "submitted",
				'locale' => 1,
				'project_status' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( self::table_name("locale_project_status") , array(
				'name' => "submitted",
					'locale' => 2,
					'project_status' => $insert_id)
				);
			$GLOBALS['wpdb']->insert( $table_name , array( 'name' => "in preparation"));
			$insert_id = $GLOBALS['wpdb']->insert_id;
			$GLOBALS['wpdb']->insert( self::table_name("locale_project_status") , array(
				'name' => "in preparation",
				'locale' => 1,
				'project_status' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( self::table_name("locale_project_status") , array(
				'name' => "in preparation",
				'locale' => 2,
				'project_status' => $insert_id)
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
			$GLOBALS['wpdb']->insert( $table_name , array( 'name' => " "));
			$GLOBALS['wpdb']->insert_id;
			$insert_id = $GLOBALS['wpdb']->insert_id;
			$GLOBALS['wpdb']->insert( self::table_name("locale_title") , array(
				'name' => " ",
				'locale' => 1,
				'title' => $insert_id)
			);
			$GLOBALS['wpdb']->insert( self::table_name("locale_title") , array(
				'name' => " ",
				'locale' => 2,
				'title' => $insert_id)
			);

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
