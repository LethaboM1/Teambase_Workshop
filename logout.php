<?php
require_once "includes/creds.php";
session_name($session_name);
session_start();
session_unset();
session_destroy();
//$date_of_expiry = time() - 60;
//setcookie("userlogin", "", $date_of_expiry);
header("Location: index.php");
