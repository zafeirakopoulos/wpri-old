<?php
nocache_headers();

// DO NOT, FOR ANY REASON, ACCESS DIRECTLY $_SESSION
// ONLY USE A VARIABLE WITHIN $_SESSION (here, "ajjx")
// OTHERWISE THIS MAY ALLOW ANYONE TO TAKE CONTROL OF YOUR INSTALLATION.
// Check if locale is set
$_SESSION['locale'] = $_REQUEST['data']['locale'];

error_log(plugin_dir_path( dirname( __FILE__ ) ) .'../languages/wpri-'.WPRI_Database::get_locale($_SESSION['locale']).'.mo');
// load_textdomain( "wpri", plugin_dir_path( dirname( __FILE__ ) ) .'../languages/wpri-'.WPRI_Database::get_locale($_SESSION['locale']).'.mo' );
load_plugin_textdomain( 'wpri', false, basename( dirname( __FILE__ ) ) . '/languages' ); 

/*
Header('Content-Type: application/json;charset=utf8');
die(json_encode(array(
    'result' => $_SESSION['locale'], // This in case you want to return something to the caller
)));
*/
 ?>
