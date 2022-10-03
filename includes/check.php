<?php
require_once "creds.php";
session_name($session_name);
session_start();

//echo "<pre>" . print_r($_SESSION, 1) . "</pre>";


if (!isset($_SESSION['user'])) {
	//$jscript .= 'console.log(`$_SERVER[\'PHP_SELF\'] = ' . pathinfo($_SERVER['PHP_SELF'], PATHINFO_BASENAME) . "`);";
	$current_page = basename($_SERVER['PHP_SELF']);
	if ($current_page != 'index.php') {
		$current_page = base64_encode($current_page);
		$cur_pg = "?pg={$current_page}";
	} else {
		$cur_pg = "";
	}

	header("location: index.php{$cur_pg}");
}

require_once "functions.php";

dbconn('127.0.0.1', $database_name, $database_user, $database_password);

$dash_roles = array("manager", "clerk", "mechanic", "manager", "user");
