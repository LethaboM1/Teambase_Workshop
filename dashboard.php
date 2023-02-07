<?php
require_once "includes/check.php";

if (isset($_SESSION['request_parts'])) {
	if ($_GET['page'] != 'add-job-requisition') {
		unset($_SESSION['request_parts']);
	}
}

switch ($_SESSION['user']['role']) {
	case "system":
		$dashboard = 'admin';
		break;

	case "manager":
		$dashboard = 'admin';
		break;

	case "clerk":
		$dashboard = 'admin';
		break;

	case "buyer":
		$dashboard = 'buyer';
		break;

	case "user":
		$dashboard = 'user';
		break;
	case "mechanic":
		$dashboard = 'mechanic';
		break;
}

switch ($dashboard) {
	case "admin":
		include "includes/dashboard/admin.php";
		break;

	case "buyer":
		include "includes/dashboard/buyer.php";
		break;

	case "user":
		include "includes/dashboard/user.php";
		break;
	case "mechanic":
		include "includes/dashboard/mechanic.php";
		break;
}

include "includes/inc.header.php";
?>


<section role="main" class="content-body">
	<header class="page-header">
		<h2><?= $page_title ?></h2>
	</header>
	<?php include "includes/inc.alertmsg.php"; ?>
	<!-- start: page -->
	<?php
	if (strlen($page_name) > 0) {
		require_once("includes/pages/{$page_name}.php");
	}
	?>
	<!-- end: page -->
</section>


<?php
include "includes/inc.footer.php";
