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
	$jsonfilename = "includes/declarations.json"
	$jsonfile = fopen($jsonfilename, "r") or die("Unable to open file!");
	$jsonstring =  fread($jsonfile,filesize($jsonfilename));
	fclose($jsonfile);
	
	# Parse the json string as an associative array
	$declarations = json_decode ($jsonstring , true )
	echo $declarations;

	function get($name) {
		return $declarations[$name];
	}

	function get_declarations() {
		return $declarations;
	}
}
