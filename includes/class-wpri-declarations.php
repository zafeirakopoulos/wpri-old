<?php

/**
 * Declarations of entities and relations.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    wpri
 * @subpackage wpri/includes
 */

/**
 * FDeclarations of entities and relations.
 *
 * FDeclarations of entities and relations.
 *
 * @since      1.0.0
 * @package    wpri
 * @subpackage wpri/includes
 * @author     Zafeirakis Zafeirakopoulos
 */
class WPRI_Declarations {



	public static function get_declarations() {
		ini_set("auto_detect_line_endings", true);
		$jsonfilename = plugin_dir_path( dirname( __FILE__ ) ) . "includes/declarations.json";
		$jsonfile = file($jsonfilename);
		$jsonstring =  implode($jsonfile);
 		# Parse the json string as an associative array
		$declarations = json_decode ($jsonstring , true );
		return $declarations["entities"];
	}

	public static function get_post_types() {
		ini_set("auto_detect_line_endings", true);
		$jsonfilename = plugin_dir_path( dirname( __FILE__ ) ) . "includes/declarations.json";
		$jsonfile = file($jsonfilename);
		$jsonstring =  implode($jsonfile);
		# Parse the json string as an associative array
		$declarations = json_decode ($jsonstring , true );
		return $declarations["post_types"];
	}

	public static function get_reports() {
		ini_set("auto_detect_line_endings", true);
		$jsonfilename = plugin_dir_path( dirname( __FILE__ ) ) . "includes/declarations.json";
		$jsonfile = file($jsonfilename);
		$jsonstring =  implode($jsonfile);
		# Parse the json string as an associative array
		$declarations = json_decode ($jsonstring , true );
		return $declarations["reports"];
	}

	public static function get_pages() {
		ini_set("auto_detect_line_endings", true);
		$jsonfilename = plugin_dir_path( dirname( __FILE__ ) ) . "includes/declarations.json";
		$jsonfile = file($jsonfilename);
		$jsonstring =  implode($jsonfile);
		# Parse the json string as an associative array
		$declarations = json_decode ($jsonstring , true );
		return $declarations["pages"];
	}
}
