<?php
require_once "creds.php";
session_name($session_name);
session_start();

//echo "<pre>" . print_r($_SESSION, 1) . "</pre>";


if ($design) {
    $_SESSIOn['user'] = [
        'role' => 'production_manager',
        'department' => 'prodcution'
    ];
} else {
    if (!isset($_SESSION['user'])) header("location: index.php");
}


require_once "functions.php";

dbconn('localhost', $database_name, $database_user, $database_password);

$dash_roles = array("manager", "clerk", "buyer", "mechanic", "ws_inspector", "manager", "user");
