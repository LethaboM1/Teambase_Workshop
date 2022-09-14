<?php
require_once "includes/check.php";

switch ($_SESSION['user']['role']) {
	case "system":
		$dashboard = 'admin';
		break;

	case "manager":
		$dashboard = 'admin';
		break;

	case "user":
		$dashboard = 'user';
		break;
}

switch ($dashboard) {
	case "admin":
		include "includes/dashboard/admin.php";
		break;
	case "user":
		include "includes/dashboard/user.php";
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
	require_once("includes/pages/{$page_name}.php");
	?>
	<!-- end: page -->
</section>


<?php
include "includes/inc.footer.php";
