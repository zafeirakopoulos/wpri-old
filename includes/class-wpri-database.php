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
						elseif ($element["type"]== "picture") {
						    $sql = $sql .  ", ".  $element["name"] ." text";
						}
						elseif ($element["type"]!= "multiple-select"){
							$sql = $sql .  ", ".  $element["name"] ." ". $element["type"];
						}
					}
				}
				$sql = $sql . ");";

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
		array_push($tables_to_drop,"vacancy_agency");

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
							WPRI_Database::add($entity_name, array( $entity_name => $element[$entity_name] ));
						}
					}
				}
			}
		}
	}

/******************************************************************************************
*******************************************************************************************
***************    ADD Functions  *******************************************************
*******************************************************************************************
*******************************************************************************************/



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





 public static function update_localized_relation($entityname, $elementame,$id,$names) {
	 $success = 1;

	foreach ( WPRI_Database::get_locales() as $locale ) {
		$success = $success * $GLOBALS['wpdb']->update( self::table_name("locale_".$entityname."_".$elementame) , array(
			'locale' => $locale["id"],
			$entityname => $id,
			'name' => $names[$locale["id"]]
		), array( 'locale' => $locale["id"], $entityname => $id));
		// $success = $success * $GLOBALS['wpdb']->insert_id;
	}
	if (!$success){
		# TODO Delete what was added
	}
	return $success;
}

# select
public static function update_simple_relation($left, $right, $id, $rightvalues) {
	$success = 1;
	foreach ( $rightvalues as $value ) {
	   $success = $success * $GLOBALS['wpdb']->update( self::table_name($left."_".$right) , array(
		   $left => $id,
		   $right => $value
	   ), array( $left => $id));
	  //  $success = $success * $GLOBALS['wpdb']->insert_id;
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
	   foreach ( $relation[$middle]  as $value ) {
		   $GLOBALS['wpdb']->insert( self::table_name($left."_".$middle."_".$right) , array(
			   $left => $id,
			   $middle => $value,
			   $right =>$relation[$right]
		   ));
		   $success = $success * $GLOBALS['wpdb']->insert_id;
	   }
   }
   if (!$success){
	   # TODO Delete what was added
   }
   return $success;
}

# foreach & select
public static function update_double_relation($left, $middle, $right, $id, $relations) {
	$success = 1;

   foreach ( $relations as $relation ) {
	   $success = 1;
	   foreach ( $relation[$middle]  as $value ) {
		   $success = $GLOBALS['wpdb']->update( self::table_name($left."_".$middle."_".$right) , array(
			   $left => $id,
			   $middle => $value,
			   $right =>$relation[$right]
		   ), array( $left => $id, $middle => $value) );
		   if ($success==false){
			  $success = WPRI_Database::add_double_relation($left, $middle, $right, $id, $relations) ;
		   }
	   }
   }

   return $success ;
}


public static function add_form($entity, $form) {

	$GLOBALS['wpdb']->insert( self::table_name($entity["table_name"]) , $form["plain"] );
	$new_id = $GLOBALS['wpdb']->insert_id;
	$success = $new_id;

	foreach (  $form["localized"]  as $localizedname => $names ) {
		WPRI_Database::add_localized_relation($entity["name"],$localizedname,$new_id , $names) ;
	}

	foreach (  $form["relations"]  as $name => $items ) {
		WPRI_Database::add_simple_relation($entity["name"],$name,$new_id,$items) ;
	}

	foreach (  $form["multirelations"]  as $name => $relation ) {
		 WPRI_Database::add_double_relation($entity["name"],array_keys($relation[0])[0],array_keys($relation[0])[1],$new_id,$relation) ;

	}


	if (!$success){
		# TODO Delete what was added
	}
	return $success;
}

public static function update_form($id, $entity, $form) {

	$success=1;
	$GLOBALS['wpdb']->update( self::table_name($entity["table_name"]) , $form["plain"], array("id"=>$id) );

	foreach (  $form["localized"]  as $localizedname => $names ) {
		WPRI_Database::update_localized_relation($entity["name"],$localizedname,$id , $names) ;
	}

	foreach (  $form["relations"]  as $name => $items ) {
		WPRI_Database::update_simple_relation($entity["name"],$name,$id,$items) ;
	}

	foreach (  $form["multirelations"]  as $name => $relation ) {
		 WPRI_Database::update_double_relation($entity["name"],array_keys($relation[0])[0],array_keys($relation[0])[1],$id,$relation) ;
	}


	if (!$success){
		# TODO Delete what was added
	}
	return $success;
}

/******************************************************************************************
*******************************************************************************************
***************    DELETE Functions  *******************************************************
*******************************************************************************************
*******************************************************************************************/



	public static function delete_record($id,$entity) {
		$declarations = WPRI_Declarations::get_declarations();

		if (isset($entity["related"])){
			foreach ( $entity["related"] as $related ) {
				if (is_array($related)){
					$tablename = $related[0]."_".$entity["name"]."_".$related[1];
					$related= $related[0];
				}
				else{
					$tablename = $related."_".$entity["name"];
				}
 				if (isset($declarations[$related]["groups"][0]["elements"][0]["all_locales"])){
					$success = $GLOBALS['wpdb']->query(
						$GLOBALS['wpdb']->prepare(
							"DELETE FROM " . self::table_name($tablename). " WHERE ".$entity["name"]." = %d", $id
						)
					);
				} else{
					$success = $GLOBALS['wpdb']->query(
						$GLOBALS['wpdb']->prepare(
								"DELETE FROM " . self::table_name($tablename). " WHERE ".$entity["name"]." = %d", $id
							)
						);
				}
		}
	}


		foreach ($entity["groups"] as $group) {
			foreach ($group["elements"] as $element) {
				if ($element["type"]=="multiple-select"){
					$relation = $element["relation"];
					if (isset($relation["select"]["table"])){
						$success = $GLOBALS['wpdb']->query(
							$GLOBALS['wpdb']->prepare(
								"DELETE FROM " . self::table_name($entity["name"]."_".$relation["foreach"]["table"]."_".$relation["select"]["table"]). " WHERE ".$entity["name"]." = %d", $id
							)
						);
					} else {
						$success = $GLOBALS['wpdb']->query(
							$GLOBALS['wpdb']->prepare(
								"DELETE FROM " . self::table_name($entity["name"]."_".$relation["foreach"]["table"]). " WHERE ".$entity["name"]." = %d", $id
							)
						);
					}
				}
				if (isset($element["localized"])){
					$success = $GLOBALS['wpdb']->query(
						$GLOBALS['wpdb']->prepare(
							"DELETE FROM " . self::table_name("locale_".$entity["name"]."_".$element["name"]). " WHERE ".$entity["name"]." = %d", $id
						)
					);
				}
			}
		 }

		 $success = $GLOBALS['wpdb']->query(
 			$GLOBALS['wpdb']->prepare(
 				"DELETE FROM " . self::table_name($entity["name"]). " WHERE id = %d", $id
 			)
 		);
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


	/******************************************************************************************
	*******************************************************************************************
	***************    GET Functions  *******************************************************
	*******************************************************************************************
	*******************************************************************************************/



// TODO remove that.
	// public static function get_roles() {
	// 	if (!isset($_SESSION['locale'])){
	// 		$_SESSION['locale']=1;
	// 	}
	//  		return  $GLOBALS['wpdb']->get_results(
	// 		$GLOBALS['wpdb']->prepare(
	// 			"SELECT * FROM " . self::table_name("locale_role"). " WHERE locale= %d",
	// 			$_SESSION['locale']
	// 		)
	// 	);
	// }

	public static function add_member($member) {
				$GLOBALS['wpdb']->insert( self::table_name("member")  , $member);
				return $GLOBALS['wpdb']->insert_id;
			}
    //
	// public static function get_all_members() {
	// 	return $GLOBALS['wpdb']->get_results("SELECT * FROM " . self::table_name("member") );
	// }

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
		$results=  $GLOBALS['wpdb']->get_results($GLOBALS['wpdb']->prepare($query, $values),"ARRAY_A");
		return $results[0];
		// TODO is [0] correct????
	}


	public static function get_localized($entity,$id) {
			$results=  $GLOBALS['wpdb']->get_results(
			$GLOBALS['wpdb']->prepare(
				"SELECT * FROM " . self::table_name("locale_".$entity). " WHERE ".$entity." = %d AND locale= %d",
				$id, $_SESSION['locale']
			)
		,"ARRAY_A");
		return $results[0]["name"];
	}


	public static function get_localized_element($entity,$element,$id) {
		$results=  $GLOBALS['wpdb']->get_results(
			$GLOBALS['wpdb']->prepare(
				"SELECT * FROM " . self::table_name("locale_".$entity."_".$element). " WHERE ".$entity." = %d AND locale= %d",
				$id, $_SESSION['locale']
			)
		,"ARRAY_A")[0];
		return $results["name"];
	}

	public static function get_element_by_locale($entity,$element,$id,$locale) {
		$results=  $GLOBALS['wpdb']->get_results(
			$GLOBALS['wpdb']->prepare(
				"SELECT * FROM " . self::table_name("locale_".$entity."_".$element). " WHERE ".$entity." = %d AND locale= %d",
				$id, $locale
			)
		,"ARRAY_A")[0];
		return $results["name"];
	}


	public static function get_all($entity) {
		return $GLOBALS['wpdb']->get_results("SELECT * FROM " . self::table_name($entity),"ARRAY_A" );
	}


	public static function get_locales() {
		return $GLOBALS['wpdb']->get_results("SELECT * FROM " . self::table_name("locale"),"ARRAY_A");
	}

	public static function get_locale($id) {

	$results=  $GLOBALS['wpdb']->get_results($GLOBALS['wpdb']->prepare(
		"SELECT locale FROM " . self::table_name("locale"). " WHERE id = %d", $id),"ARRAY_A");
	return $results[0]["locale"];



		return $GLOBALS['wpdb']->get_results("SELECT locale FROM " . self::table_name("locale"),"ARRAY_A");
	}

	public static function get_relation($left, $right, $lid, $rid) {
 		if ($rid==""){
			$query = "SELECT * FROM " . self::table_name($left."_".$right). " WHERE ".$left." = %d";
			$value = $lid;
		} else{
			$query = "SELECT * FROM " . self::table_name($left."_".$right). " WHERE ".$right." = %d";
			$value = $rid;
		}
 		$results=  $GLOBALS['wpdb']->get_results($GLOBALS['wpdb']->prepare($query, $value),"ARRAY_A");
		return $results;

   }

   public static function get_double_relation($left, $middle, $right, $lid, $mid, $rid) {
	   $values= array();
	   $where = array();
	   $query = "SELECT * FROM " . self::table_name($left."_".$middle."_".$right). " WHERE ";
	   if ($lid!=""){
		   array_push($where, $left." = %d");
		   array_push($values,$lid);
	   }
	   if ($mid!=""){
		   array_push($where, $middle." = %d");
		   array_push($values,$mid);
	   }
	   if ($rid!=""){
		   array_push($where, $right." = %d");
		   array_push($values,$rid);
	   }
	   $query =$query . join(" AND ", $where);
	   $results=  $GLOBALS['wpdb']->get_results($GLOBALS['wpdb']->prepare($query, $values),"ARRAY_A");
	   return $results;

	 }


	 public static function get_entity($entity_name, $id) {

		 $declarations = WPRI_Declarations::get_declarations();
		 $entity = $declarations[$entity_name];

		 $local = array();
		 $relations = array();
		 $multiplerelations = array();
		 $select = array();

		 foreach ($entity["groups"] as $group ) {
		 	foreach ($group["elements"] as $element ) {
		 		if (isset($element["localized"]) ){
		 			$local[] = $element["name"];
		 		}
		 		elseif ($element["type"]== "multiple-select"){
		 			$relation = $element["relation"];
		 			if (isset($relation["select"])) {
						$multiplerelations[] = array($element["name"],$relation["foreach"]["table"],$relation["select"]["table"]);
 		 			} else {
						array_push($relations, $relation["foreach"]["table"]);
		 			}
		 		}
				elseif ($element["type"]== "select"){
					array_push($select, $element["table"]);
				}
		 	}
		 }

		 $results=  $GLOBALS['wpdb']->get_results($GLOBALS['wpdb']->prepare(
			 "SELECT * FROM " . self::table_name($entity_name). " WHERE id = %d", $id) ,"ARRAY_A"
		 )[0];


	 	foreach (  $local  as $localizedname) {
	 		$results[$localizedname] = WPRI_Database::get_localized_element($entity_name,$localizedname,$id);
	 	}

	 	foreach (  $relations  as $name ) {
			$tmp=array();
			if (isset($declarations[$name]["groups"][0]["elements"][0]["all_locales"])){
				foreach (WPRI_Database::get_relation($entity_name,$name,$id,"") as $row) {
					$tmp[] = WPRI_Database::get_localized($name,$row[$name]) ;
				}
			} else{
				foreach (WPRI_Database::get_relation($entity_name,$name,$id,"") as $row) {
					$tmp[] = $row[$name];
				}
			}
			$results[$name]= $tmp;
	 	}

		foreach (  $select  as $selection ) {
			if (isset($declarations[$selection]["groups"][0]["elements"][0]["all_locales"])){
				$results[$selection]=  WPRI_Database::get_localized($selection,$results[$selection]) ;
			}
		}


	 	foreach ( $multiplerelations as $relation ) {
	 		 $results[$relation[0]] = WPRI_Database::get_double_relation($entity_name,$relation[1],$relation[2],$id,"","") ;

	 	}

		if (isset($entity["related"])){
			foreach ( $entity["related"] as $related ) {
				$tmp=array();
				if (isset($declarations[$related]["groups"][0]["elements"][0]["all_locales"])){
					foreach (WPRI_Database::get_relation($related,$entity_name,"",$id) as $row) {
						$tmp[] = WPRI_Database::get_localized($related,$row[$related]) ;
					}
				} else{
					foreach (WPRI_Database::get_relation($related,$entity_name,"",$id) as $row) {
						$tmp[] = $row[$related];
					}
				}
				$results[$related]= $tmp;
			}
	 	}

		// error_log(print_r($results));
	 	return $results;
	 }


	 	 public static function get_entity_raw($entity_name, $id) {

	 		 $declarations = WPRI_Declarations::get_declarations();
	 		 $entity = $declarations[$entity_name];

	 		 $local = array();
	 		 $relations = array();
	 		 $multiplerelations = array();
	 		 $select = array();

	 		 foreach ($entity["groups"] as $group ) {
	 		 	foreach ($group["elements"] as $element ) {
	 		 		if (isset($element["localized"]) ){
	 		 			$local[] = $element["name"];
	 		 		}
	 		 		elseif ($element["type"]== "multiple-select"){
	 		 			$relation = $element["relation"];
	 		 			if (isset($relation["select"])) {
	 						$multiplerelations[] = array($element["name"],$relation["foreach"]["table"],$relation["select"]["table"]);
	  		 			} else {
	 						array_push($relations, $relation["foreach"]["table"]);
	 		 			}
	 		 		}
	 				elseif ($element["type"]== "select"){
	 					array_push($select, $element["table"]);
	 				}
	 		 	}
	 		 }

	 		 $results=  $GLOBALS['wpdb']->get_results($GLOBALS['wpdb']->prepare(
	 			 "SELECT * FROM " . self::table_name($entity_name). " WHERE id = %d", $id) ,"ARRAY_A"
	 		 )[0];


	 	 	foreach (  $local  as $localizedname) {
	 	 		$results[$localizedname] = WPRI_Database::get_localized_element($entity_name,$localizedname,$id);
	 	 	}

	 	 	foreach (  $relations  as $name ) {
	 			$tmp=array();
	 			if (isset($declarations[$name]["groups"][0]["elements"][0]["all_locales"])){
	 				foreach (WPRI_Database::get_relation($entity_name,$name,$id,"") as $row) {
	 					$tmp[] = $row[$name] ;
	 				}
	 			} else{
	 				foreach (WPRI_Database::get_relation($entity_name,$name,$id,"") as $row) {
	 					$tmp[] = $row[$name];
	 				}
	 			}
	 			$results[$name]= $tmp;
	 	 	}



	 	 	foreach ( $multiplerelations as $relation ) {
	 	 		 $results[$relation[0]] = WPRI_Database::get_double_relation($entity_name,$relation[1],$relation[2],$id,"","") ;

	 	 	}

	 		if (isset($entity["related"])){
	 			foreach ( $entity["related"] as $related ) {
	 				$tmp=array();
	 				if (isset($declarations[$related]["groups"][0]["elements"][0]["all_locales"])){
	 					foreach (WPRI_Database::get_relation($related,$entity_name,"",$id) as $row) {
	 						$tmp[] = $row[$related] ;
	 					}
	 				} else{
	 					foreach (WPRI_Database::get_relation($related,$entity_name,"",$id) as $row) {
	 						$tmp[] = $row[$related];
	 					}
	 				}
	 				$results[$related]= $tmp;
	 			}
	 	 	}

	 		// error_log(print_r($results));
	 	 	return $results;
	 	 }

	 public static function get_ids($entity) {
		 $ids =array();
		 foreach ($GLOBALS['wpdb']->get_results("SELECT id FROM " . self::table_name($entity),"ARRAY_A") as $key => $value) {
		 	$ids[] = $value["id"];
		 }
		 return $ids;
	 }


	 	 	 public static function get_entity_with_data($entity_name, $id) {

	 	 		 $declarations = WPRI_Declarations::get_declarations();
	 	 		 $entity = $declarations[$entity_name];
				 $locales =  WPRI_Database::get_locales();

	 	 		 $local = array();
	 	 		 $relations = array();
	 	 		 $multiplerelations = array();
	 	 		 $select = array();

				 $results=  $GLOBALS['wpdb']->get_results($GLOBALS['wpdb']->prepare(
	 	 			 "SELECT * FROM " . self::table_name($entity_name). " WHERE id = %d", $id) ,"ARRAY_A"
	 	 		 )[0];

	 	 		 foreach ($entity["groups"] as &$group ) {
	 	 		 	foreach ($group["elements"] as &$element ) {
						if (isset($element["localized"]) ){
							$localdata = array();
							foreach ($locales as $locale) {
								$localdata[$locale["id"]] = WPRI_Database::get_element_by_locale($entity_name,$element["name"],$id,$locale["id"]);
							}
							$element["data"] = $localdata;
						}
	 	 		 		elseif  ($element["type"]== "multiple-select"){
	 	 		 			$relation = $element["relation"];
	 	 		 			if (isset($relation["select"])) {

								$element["data"] = WPRI_Database::get_double_relation($entity_name,$relation["foreach"]["table"],$relation["select"]["table"],$id,"","") ;

 	 	  		 			} else {
								$tmp = array();
 								foreach (WPRI_Database::get_relation($entity_name,$relation["foreach"]["table"],$id,"") as $row) {
			 	 					$tmp[] = $row[$relation["foreach"]["table"]];
			 	 				}
								$element["data"] =$tmp;
	 	 		 			}
	 	 		 		}
						else {
							$element["data"] = $results[$element["name"]];
						}
	 	 		 	}
	 	 		 }

                //

                //
	 	 		// if (isset($entity["related"])){
	 	 		// 	foreach ( $entity["related"] as $related ) {
	 	 		// 		$tmp=array();
	 	 		// 		if (isset($declarations[$related]["groups"][0]["elements"][0]["all_locales"])){
	 	 		// 			foreach (WPRI_Database::get_relation($related,$entity_name,"",$id) as $row) {
	 	 		// 				$tmp[] = $row[$related] ;
	 	 		// 			}
	 	 		// 		} else{
	 	 		// 			foreach (WPRI_Database::get_relation($related,$entity_name,"",$id) as $row) {
	 	 		// 				$tmp[] = $row[$related];
	 	 		// 			}
	 	 		// 		}
	 	 		// 		$results[$related]= $tmp;
	 	 		// 	}
	 	 	 	// }

	 	 		// error_log(print_r($entity));
	 	 	 	return $entity;
	 	 	 }



	 	 public static function get_members_full() {
			 $declarations = WPRI_Declarations::get_declarations();
			 $entity = $declarations["member"];
			 $local = array();
	 		 $relations = array();
	 		 $multiplerelations = array();
	 		 $select = array();

	 		 foreach ($entity["groups"] as $group ) {
	 		 	foreach ($group["elements"] as $element ) {
	 		 		if (isset($element["localized"]) ){
	 		 			$local[] = $element["name"];
	 		 		}
	 		 		elseif ($element["type"]== "multiple-select"){
	 		 			$relation = $element["relation"];
	 		 			if (isset($relation["select"])) {
	 						$multiplerelations[] = array($element["name"],$relation["foreach"]["table"],$relation["select"]["table"]);
	  		 			} else {
	 						array_push($relations, $relation["foreach"]["table"]);
	 		 			}
	 		 		}
	 				elseif ($element["type"]== "select"){
	 					array_push($select, $element["table"]);
	 				}
	 		 	}
	 		 }

			 $results = array();
			 $members = $GLOBALS['wpdb']->get_results("SELECT * FROM " . self::table_name("member"),"ARRAY_A" );

			 foreach ($members as $member) {
				   $results[$member["id"]] = WPRI_Database::get_member_full_precomputed_entity($member["id"],$local,$relations ,$multiplerelations, $select);
		 		}

				// error_log(print_r($results));
				return $results;
			 }


	 	 	 public static function get_member_full($id) {
	 			 $declarations = WPRI_Declarations::get_declarations();
	 			 $entity = $declarations["member"];
	 			 $local = array();
	 	 		 $relations = array();
	 	 		 $multiplerelations = array();
	 	 		 $select = array();

	 	 		 foreach ($entity["groups"] as $group ) {
	 	 		 	foreach ($group["elements"] as $element ) {
	 	 		 		if (isset($element["localized"]) ){
	 	 		 			$local[] = $element["name"];
	 	 		 		}
	 	 		 		elseif ($element["type"]== "multiple-select"){
	 	 		 			$relation = $element["relation"];
	 	 		 			if (isset($relation["select"])) {
	 	 						$multiplerelations[] = array($element["name"],$relation["foreach"]["table"],$relation["select"]["table"]);
	 	  		 			} else {
	 	 						array_push($relations, $relation["foreach"]["table"]);
	 	 		 			}
	 	 		 		}
	 	 				elseif ($element["type"]== "select"){
	 	 					array_push($select, $element["table"]);
	 	 				}
	 	 		 	}
	 	 		 }


 			   	 $result=  $GLOBALS['wpdb']->get_results($GLOBALS['wpdb']->prepare(
 			   			 "SELECT * FROM " . self::table_name("member"). " WHERE id = %d", $id) ,"ARRAY_A"
 			   		 )[0];

 		 		   foreach (  $local  as $localizedname) {
 		 			   $result[$localizedname] = WPRI_Database::get_localized_element("member",$localizedname,$id);
 		 		   }

 		 		   foreach (  $relations  as $name ) {
 		 			   $tmp=array();
 		 			   if (isset($declarations[$name]["groups"][0]["elements"][0]["all_locales"])){
 		 				   // error_log("in the if all_locales for ".$name);
 		 				   foreach (WPRI_Database::get_relation("member",$name,$id,"") as $row) {
 		 					   $tmp[] = WPRI_Database::get_localized($name,$row[$name]) ;
 		 				   }
 		 			   } else{
 		 				   foreach (WPRI_Database::get_relation("member",$name,$id,"") as $row) {
 		 					   $tmp[] = $row[$name];
 		 				   }
 		 			   }
 		 			   $result[$name]= $tmp;
 		 		   }

 		 		   foreach (  $select  as $selection ) {
 		 			   if (isset($declarations[$selection]["groups"][0]["elements"][0]["all_locales"])){
 		 				   // error_log("in the if all_locales for ".$selection);
 		 				   $result[$selection]=  WPRI_Database::get_localized($selection,$result[$selection]) ;
 		 			   }
 		 		   }


 		 		   foreach ( $multiplerelations as $relation ) {
 		 				$result[$relation[0]] = WPRI_Database::get_double_relation("member",$relation[1],$relation[2],$id,"","") ;

 		 		   }

 		 		   if (isset($entity["related"])){
 		 			   foreach ( $entity["related"] as $related ) {
						   if (is_array($related)){
							   $left = $related[0];
							   $right = $related[1];
							   $tmp=array();
							   if (isset($declarations[$right]["groups"][0]["elements"][0]["all_locales"])){
								   foreach (WPRI_Database::get_double_relation($left,"member",$right,"",$id,"") as $row) {
									   $tmp[] = array($row[$left],WPRI_Database::get_localized($right,$row[$right]));
								   }
							   } else{
								   foreach (WPRI_Database::get_double_relation($left,"member",$right,"",$id,"") as $row) {
									   $tmp[] = array($row[$left],$row[$right]);
								   }
							   }
							   $result[$left] = $tmp;
						   } else{
	 		 				   $tmp=array();
	 		 				   if (isset($declarations[$related]["groups"][0]["elements"][0]["all_locales"])){
	 		 					   foreach (WPRI_Database::get_relation($related,"member","",$id) as $row) {
	 		 						   $tmp[] = WPRI_Database::get_localized($related,$row[$related]) ;
	 		 					   }
	 		 				   } else{
	 		 					   foreach (WPRI_Database::get_relation($related,"member","",$id) as $row) {
	 		 						   $tmp[] = $row[$related];
	 		 					   }
	 		 				   }
	 		 				   $result[$related]= $tmp;
						   }
 		 			   }
 		 		   }

 				   $result["title"]= WPRI_Database::get_localized("title",get_user_meta($result["user"],"title",true)) ;
 				   $result["position"]= WPRI_Database::get_localized("position",get_user_meta($result["user"],"position",true));
 				   $result["name"]= get_user_meta($result["user"],"first_name",true)." ".get_user_meta($result["user"],"last_name",true);
				   $result["email"]= get_user_meta($result["user"],"email",true);
				   $result["website"]= get_user_meta($result["user"],"website",true);
				   $result["advisor"]= get_user_meta($result["user"],"advisor",true);
				   $result["undergrad"]= array(
					   "university" => get_user_meta($result["user"],"bs_uni",true),
					   "program" => get_user_meta($result["user"],"bs_prog",true),
					   "year" => get_user_meta($result["user"],"bs_year",true),
					   "title" => get_user_meta($result["user"],"bs_title",true)
				   );
				   $result["masters"]= array(
					   "university" => get_user_meta($result["user"],"ms_uni",true),
					   "program" => get_user_meta($result["user"],"ms_prog",true),
					   "year" => get_user_meta($result["user"],"ms_year",true),
					   "title" => get_user_meta($result["user"],"ms_title",true)
				   );
				   $result["phd"]= array(
					   "university" => get_user_meta($result["user"],"phd_uni",true),
					   "program" => get_user_meta($result["user"],"phd_prog",true),
					   "year" => get_user_meta($result["user"],"phd_year",true),
					   "title" => get_user_meta($result["user"],"phd_title",true)

				   );
				   $result["office"]= get_user_meta($result["user"],"office",true);
				   $result["phone"]= get_user_meta($result["user"],"phone",true);

	 				// error_log(print_r($result));
	 				return $result;
	 			 }


	 	 	 public static function get_member_full_precomputed_entity($id,$local,$relations ,$multiplerelations, $select) {

			   	 $result=  $GLOBALS['wpdb']->get_results($GLOBALS['wpdb']->prepare(
			   			 "SELECT * FROM " . self::table_name("member"). " WHERE id = %d", $id) ,"ARRAY_A"
			   		 )[0];

		 		   foreach (  $local  as $localizedname) {
		 			   $result[$localizedname] = WPRI_Database::get_localized_element("member",$localizedname,$id);
		 		   }

		 		   foreach (  $relations  as $name ) {
		 			   $tmp=array();
		 			   if (isset($declarations[$name]["groups"][0]["elements"][0]["all_locales"])){
		 				   // error_log("in the if all_locales for ".$name);
		 				   foreach (WPRI_Database::get_relation("member",$name,$id,"") as $row) {
		 					   $tmp[] = WPRI_Database::get_localized($name,$row[$name]) ;
		 				   }
		 			   } else{
		 				   foreach (WPRI_Database::get_relation("member",$name,$id,"") as $row) {
		 					   $tmp[] = $row[$name];
		 				   }
		 			   }
		 			   $result[$name]= $tmp;
		 		   }

		 		   foreach (  $select  as $selection ) {
		 			   if (isset($declarations[$selection]["groups"][0]["elements"][0]["all_locales"])){
		 				   // error_log("in the if all_locales for ".$selection);
		 				   $result[$selection]=  WPRI_Database::get_localized($selection,$result[$selection]) ;
		 			   }
		 		   }


		 		   foreach ( $multiplerelations as $relation ) {
		 				$result[$relation[0]] = WPRI_Database::get_double_relation("member",$relation[1],$relation[2],$id,"","") ;

		 		   }

		 		   if (isset($entity["related"])){
		 			   foreach ( $entity["related"] as $related ) {
		 				   $tmp=array();
		 				   if (isset($declarations[$related]["groups"][0]["elements"][0]["all_locales"])){
		 					   // error_log("in the if all_locales for ".$related);
		 					   foreach (WPRI_Database::get_relation($related,"member","",$id) as $row) {
		 						   $tmp[] = WPRI_Database::get_localized($related,$row[$related]) ;
		 					   }
		 				   } else{
		 					   foreach (WPRI_Database::get_relation($related,"member","",$id) as $row) {
		 						   $tmp[] = $row[$related];
		 					   }
		 				   }
		 				   $result[$related]= $tmp;
		 			   }
		 		   }
				   $result["title"]= WPRI_Database::get_localized("title",get_user_meta($result["user"],"title",true)) ;
				   $result["position"]= WPRI_Database::get_localized("position",get_user_meta($result["user"],"position",true));
				   $result["name"]= get_user_meta($result["user"],"first_name",true)." ".get_user_meta($result["user"],"last_name",true);

	 				// error_log(print_r($result));
	 				return $result;
	 			 }

		 public static function get_full_entity_within_activity_period($entity, $date_constraints) {
			 $where = array();
			 foreach ($date_constraints as $key => $value) {
			 	$where[] = "$key>$value[0] AND $key<$value[1]";
			 }
			 $where = join("AND", $where);
			 $ids =array();
			 foreach ($GLOBALS['wpdb']->get_results("SELECT id FROM " . self::table_name($entity). "WHERE ".$where,"ARRAY_A") as $key => $value) {
			 	$ids[] = $value["id"];
			 }
			 error_log(print_r($ids));
			 return $ids;
		 }


}
