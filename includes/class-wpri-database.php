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
	 * Create database tables from the JSON description.
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function create_tables() {
		$first_install = ( $GLOBALS['wpdb']->get_var( "SHOW TABLES LIKE '".self::table_name("locale")."'") != self::table_name("locale")  );

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
						$sql = $sql .  $entity_name  ." INT,";
						$sql = $sql .  "name ". $element["type"] .",";
						$sql = $sql .  "FOREIGN KEY (locale) REFERENCES ".self::table_name("locale")."(id),";
						$sql = $sql .  "FOREIGN KEY (". $entity_name .") REFERENCES ".self::table_name($entity_name)."(id)";
						$sql = $sql . ");";
						// error_log($sql);
						$GLOBALS['wpdb']->query( $GLOBALS['wpdb']->query( $sql ) );
					}
				}
			}

			# Create relation tables for multiple-select elements
 			foreach ($entity["groups"] as $group ) {
				# One table with different "name" attributes
				foreach ($group["elements"] as $element ) {
					if ($element["type"]=="multiple-select") {
						$relation = $element["relation"];
						$table_name = $entity_name;
						foreach ($relation as $attribute ) {
							$table_name = $table_name."_".$attribute["table"] ;
						}
						$sql = "CREATE TABLE ".self::table_name($table_name)." ( id INT AUTO_INCREMENT PRIMARY KEY,	";
						$sql = $sql .  $entity_name ." INT,";
						$sql = $sql .  "FOREIGN KEY (".$entity_name.") REFERENCES ".self::table_name($entity_name)."(id)";
						foreach ($relation as $attribute ) {
							$sql = $sql . ",". $attribute["table"]." INT,";
							$sql = $sql .  "FOREIGN KEY (".$attribute["table"].") REFERENCES ".self::table_name($attribute["table"])."(id)";
						}
						$sql = $sql . ");";
						$GLOBALS['wpdb']->query( $GLOBALS['wpdb']->query( $sql ) );
					}
				}
			}
		}

	    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		return $first_install;
	}


	/**
	 * Drop database tables from the JSON description.
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */

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

			# Drop locale_entity_element tables
			foreach ($entity["groups"] as $group ) {
				foreach ($group["elements"] as $element ) {
					if (isset($element["localized"]) ){
						array_push($tables_to_drop,"locale_".$entity_name."_".$element["name"] );
					}
				}
			}

			# Drop relations
			foreach ($entity["groups"] as $group ) {
				foreach ($group["elements"] as $element ) {
					if ($element["type"]=="multiple-select") {
						$relation = $element["relation"];
						$table_name = $entity_name;
						foreach ($relation as $attribute ) {
							$table_name = $table_name."_".$attribute["table"] ;
						}
						array_push($tables_to_drop,$table_name);
					}
				}
			}
		}

		$tables_to_drop = array_reverse($tables_to_drop);
		// error_log("tables_to_drop ".implode($tables_to_drop));
		// array_push($tables_to_drop,"institute_info");

	    foreach($tables_to_drop as $table_name){
		    $GLOBALS['wpdb']->query( "DROP TABLE IF EXISTS  " . self::table_name($table_name) );
	    }
    }

	public static function  populate_tables() {
		$declarations = WPRI_Declarations::get_declarations();
		foreach ($declarations as $entity_name => $entity) {
			# Has to be in the loop because in the beginning locales are not defined.
			$locales= WPRI_Database::get_locales();

			if (isset($entity["default_values"]) ){
				foreach ($entity["default_values"] as $element) {
					if ($entity_name=="locale"){
						WPRI_Database::add("locale", array( "locale" => $element["locale"]));
					} else{
						if (isset($element["localized"])){
							$names = array();
							foreach ($locales as $value) {
								$names[$value["id"]]= $element[$value["locale"]] ;
							}
							WPRI_Database::add_localized($entity_name, $element[$entity_name] , $names);
						}else{
							// WPRI_Database::add($entity_name, array( $entity_name => $element[$entity_name] ));
						}
					}
				}
			}
		}
	}

/******************************************************************************************
*******************************************************************************************
***************    Query Functions  *******************************************************
*******************************************************************************************
*******************************************************************************************/

// TODO remove that.
				public static function get_roles() {
	 		 		return  $GLOBALS['wpdb']->get_results(
						$GLOBALS['wpdb']->prepare(
							"SELECT * FROM " . self::table_name("locale_role"). " WHERE locale= %d",
							$_SESSION['locale']
						)
					);
				}

				public static function add_member($member) {
							$GLOBALS['wpdb']->insert( self::table_name("member")  , $member);
							return $GLOBALS['wpdb']->insert_id;
						}

public static function get_all_members() {
	return $GLOBALS['wpdb']->get_results("SELECT * FROM " . self::table_name("member") );
}

public static function get_record($entity,$id) {
	$results=  $GLOBALS['wpdb']->get_results(
		$GLOBALS['wpdb']->prepare("SELECT * FROM " . self::table_name($entity). " WHERE id= %d ", $id)
	,"ARRAY_A");
	return $results[0];
}

public static function get_field($table,$field,$id) {
	$results=  $GLOBALS['wpdb']->get_results(
		$GLOBALS['wpdb']->prepare("SELECT ".$field." FROM " . self::table_name($table). " WHERE id= %d ", $id)
	,"ARRAY_A");
	return $results[0][$field];
}


public static function get_records($table, $where) {
	$values = array();
	$wherearray = array();
	foreach ($where as $key => $value) {
		# gettype
		array_push($wherearray," ".$key."= %d ");
		array_push($values,$value);
	}
	$query = "SELECT * FROM " . self::table_name($table). " WHERE ". join(" AND ", $wherearray);
	error_log($query);
	$results=  $GLOBALS['wpdb']->get_results($GLOBALS['wpdb']->prepare($query, $values),"ARRAY_A");
	return $results[0];
}

public static function get_localized($entity,$id) {
		$results=  $GLOBALS['wpdb']->get_results(
		$GLOBALS['wpdb']->prepare(
			"SELECT * FROM " . self::table_name("locale_".$entity). " WHERE ".$entity." = %d AND locale= %d",
			$id, $_SESSION['locale']
		)
	,"ARRAY_A");
	return $results[0];
}


public static function get_all($entity) {
	return $GLOBALS['wpdb']->get_results("SELECT * FROM " . self::table_name($entity),"ARRAY_A" );
}



public static function get_locales() {
	return $GLOBALS['wpdb']->get_results("SELECT * FROM " . self::table_name("locale"),"ARRAY_A");
}

# item is an associative array
public static function add($table,$item) {
	$GLOBALS['wpdb']->insert( self::table_name($table) , $item);
	return $GLOBALS['wpdb']->insert_id;
}

# The associcative array names is of the form locale_id => "translated name of table[id]"
public static function add_localized($table,$item,$names) {
	$GLOBALS['wpdb']->insert( self::table_name($table) , array( $table => $item ) );
	$new_id = $GLOBALS['wpdb']->insert_id;
	$success = $new_id;

	foreach ( WPRI_Database::get_locales() as $locale ) {
		$GLOBALS['wpdb']->insert( self::table_name("locale_".$table) , array(
			'locale' => $locale["id"],
			$table => $new_id,
			'name' => $names[$locale["id"]]
		));
		$success = $success * $GLOBALS['wpdb']->insert_id;
	}
	if (!$success){
		# TODO Delete what was added
	}
	return $success;
}

 public static function add_localized_relation($entityname, $elementame,$id,$names) {
	 $success = 1;

	foreach ( WPRI_Database::get_locales() as $locale ) {
		$GLOBALS['wpdb']->insert( self::table_name("locale_".$entityname."_".$elementame) , array(
			'locale' => $locale["id"],
			$entityname => $id,
			'name' => $names[$locale["id"]]
		));
		$success = $success * $GLOBALS['wpdb']->insert_id;
	}
	if (!$success){
		# TODO Delete what was added
	}
	return $success;
}

# select
public static function add_simple_relation($left, $right, $id, $rightvalues) {
	$success = 1;
	foreach ( $rightvalues as $value ) {
	   $GLOBALS['wpdb']->insert( self::table_name($left."_".$right) , array(
		   $left => $id,
		   $right => $value
	   ));
	   $success = $success * $GLOBALS['wpdb']->insert_id;
	}
	if (!$success){
	   # TODO Delete what was added
	}
	return $success;
}


# foreach & select
public static function add_double_relation($left, $middle, $right, $id, $relations) {
	$success = 1;

   foreach ( $relations as $relation ) {
	   $success = 1;
	   $GLOBALS['wpdb']->insert( self::table_name($left."_".$middle."_".$right) , array(
		   $left => $id,
		   $middle => $relation[$middle],
		   $right => $relation[$right]
	   ));
	   $success = $success * $GLOBALS['wpdb']->insert_id;
   }
   if (!$success){
	   # TODO Delete what was added
   }
   return $success;
}

public static function add_form($entity, $form) {

	$GLOBALS['wpdb']->insert( self::table_name($entity["table_name"]) , $form["plain"] );
	$new_id = $GLOBALS['wpdb']->insert_id;
	$success = $new_id;

	foreach (  $form["localized"]  as $localizedname => $names ) {
		WPRI_Database::add_localized_relation($entity["name"],$localizedname,$new_id , $names) ;
	}

	foreach (  $form["relations"]  as $name => $item ) {
		WPRI_Database::add_simple_relation($entity["name"],$name,$new_id,$item) ;
	}

	foreach (  $form["multirelations"]  as $name => $relation ) {
		 WPRI_Database::add_double_relation($entity["name"],array_keys($relation[0])[0],array_keys($relation[0])[1],$new_id,$relation) ;

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

	public static function delete_record($id,$entity) {



		return $success;
	}




}
