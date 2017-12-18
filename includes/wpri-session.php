<?php
nocache_headers();

// DO NOT, FOR ANY REASON, ACCESS DIRECTLY $_SESSION
// ONLY USE A VARIABLE WITHIN $_SESSION (here, "ajjx")
// OTHERWISE THIS MAY ALLOW ANYONE TO TAKE CONTROL OF YOUR INSTALLATION.
// Check if locale is set
// error_log("about to change locale");
$_SESSION['locale'] = $_REQUEST['data']['locale'];

WPRI_Public::change_textdomain();

// Header('Content-Type: application/json;charset=utf8');
// die(json_encode(array(
//     'result' => 'about to change locale', // This in case you want to return something to the caller
// )));
  ?>
