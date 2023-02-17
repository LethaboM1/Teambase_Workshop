<?php
require_once "includes/creds.php";

require_once "includes/functions.php";

if (isset($_POST['html_code'])) {
    $html = $_POST['html_code'];
    printPDF($html);
}
