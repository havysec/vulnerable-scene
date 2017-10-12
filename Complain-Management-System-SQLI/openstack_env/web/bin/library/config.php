<?php
ini_set('display_errors', 'Off');
//ob_start("ob_gzhandler");
//error_reporting(E_ALL);

// start the session
session_start();
// database connection config
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'complain_db';


//Prod DB
/*
$dbHost = 'localhost';
$dbUser = 'traffics_user01';
$dbPass = 'TNXPVDzm1_4D';
$dbName = 'traffics_complain_db';
*/

// setting up the web root and server root for
// this shopping cart application
$thisFile = str_replace('\\', '/', __FILE__);
$docRoot = $_SERVER['DOCUMENT_ROOT'];

$webRoot  = str_replace(array($docRoot, 'library/config.php'), '', $thisFile);
$srvRoot  = str_replace('library/config.php', '', $thisFile);

define('WEB_ROOT', $webRoot);
define('SRV_ROOT', $srvRoot);

if (!get_magic_quotes_gpc()) {
	if (isset($_POST)) {
		foreach ($_POST as $key => $value) {
			$_POST[$key] =  trim(addslashes($value));
		}
	}
	
	if (isset($_GET)) {
		foreach ($_GET as $key => $value) {
			$_GET[$key] = trim(addslashes($value));
		}
	}	
}

// since all page will require a database access
// and the common library is also used by all
// it's logical to load these library here
require_once 'database.php';
require_once 'common.php';

// get the shop configuration ( name, addres, etc ), all page need it
//$shopConfig = getShopConfig();
?>