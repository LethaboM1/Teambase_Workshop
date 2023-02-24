<?php
require_once "includes/check.php";
if ($_SESSION['user']['role'] != 'user') {
	go('index.php');
}
switch ($_GET['page']) {
	case "profile":
		$page_title = 'Your Profile';
		$page_name = 'profile';
		require "includes/forms/profile.php";
		break;

	case "plants":
		$page_title = 'Plants';
		$page_name = 'user/plants-page';
		include "./includes/forms/user/plants-page.php";

		break;

	case 'checklist':
		$page_title = 'Checklist / Report';
		$page_name = 'user/checklist';
		break;

	case 'log-sheet':
		$page_title = 'Driver / Operator Log Sheet';
		$page_name = 'user/log-sheet';
		break;

		/*
	case 'add-job':
		$page_title = 'Request New Job Card';
		$page_name = 'user/add-job-card';
		break;
	*/
	default:
		$page_title = 'Plants';
		$page_name = 'user/plants-page';
		include "./includes/forms/user/plants-page.php";
}
