<?php
require_once "creds.php";
session_name($session_name);
session_start();

//echo "<pre>" . print_r($_SESSION, 1) . "</pre>";


if (!isset($_SESSION['user'])) header("location: index.php");

require_once "functions.php";

dbconn('localhost', $database_name, $database_user, $database_password);

$dash_roles = array("manager", "clerk", "buyer", "mechanic", "manager", "user");
