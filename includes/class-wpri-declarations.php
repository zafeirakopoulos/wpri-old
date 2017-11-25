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
		$jsonstring =  file_get_contents($jsonfilename);
error_log(print_r("thestring".$jsonstring,true));
		# Parse the json string as an associative array
		$declarations = json_decode ($jsonstring , true );
 		return $declarations;
	}
}
