<?php
if (isset($_GET['msg'])) {
	$msg[] = $_GET['msg'];
}
if (isset($_GET['error'])) {
	$error[] = $_GET['error'];
}
if (isset($_SESSION['msg'])) {
	$msg = $_SESSION['msg'];
	unset($_SESSION['msg']);
}
if (isset($_SESSION['error'])) {
	$error = $_SESSION['error'];
	unset($_SESSION['error']);
}
echo "<div id='alertMsg'></div>";
if (isset($error)) {
	foreach ($error as $m) {
		echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
					<strong>Error!</strong>&nbsp;{$m}
					<button type='button' class='btn-close' data-bs-dismiss='alert' aria-hidden='true' aria-label='Close'></button>
				</div>";

		//echo "<div class='alert alert-danger fade in'><a href='#' class='close' data-dismiss='alert' aria-label='close' title='close'>×</a><strong>Error!</strong>&nbsp;".$m."</div>";
	}
}

if (isset($msg)) {
	foreach ($msg as $m) {
		echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
					<strong>Success!</strong>&nbsp;{$m}
					<button type='button' class='btn-close' data-bs-dismiss='alert' aria-hidden='true' aria-label='Close'></button>
				</div>";

		//echo "<div class='alert alert-success fade in'><a href='#' class='close' data-dismiss='alert' aria-label='close' title='close'>×</a>".$m."</div>";
	}
}


if (isset($form)) {
	echo "<div><form method='post' enctype='multipart/form-data'>" . $form . "</form></div>";
}
