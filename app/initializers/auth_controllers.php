<?php
//-----------------------------------------------
// Paths
//-----------------------------------------------
if (!defined('MAESTRANO_ROOT')) {
  define("MAESTRANO_ROOT", realpath(dirname(__FILE__) . '/../../'));
}
define('APP_ROOT', realpath(MAESTRANO_ROOT . '/../'));


//-----------------------------------------------
// Load and configure Maestrano
//-----------------------------------------------
require MAESTRANO_ROOT . '/app/initializers/maestrano.php';

//-----------------------------------------------
// Custom dependency loading
//-----------------------------------------------
//require APP_ROOT . '/include/initfunctions.php';
//require APP_ROOT . '/include/class.mylog.php';
//require APP_ROOT . '/include/class.user.php';

//-----------------------------------------------
// Custom initialization code (optional)
//-----------------------------------------------
// Set options to pass to the Maestrano_Sso_User
$opts = array();

// E.g:
// if (!empty($db_name) and !empty($db_user)) {
//     // $tdb = new datenbank();
//     $conn = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
//     
//     $opts['db_connection'] = $conn;
// }


