<?php
session_name("TeamBase-Desktop-App");
session_start();

//echo "<pre>" . print_r($_SESSION, 1) . "</pre>";
require_once "includes/creds.php";
require_once "includes/functions.php";

if (isset($_SESSION['user'])) {
	go("dashboard.php");
}



include 'includes/csrf.php';

$csrf = new csrf();

// Generate Token Id and Valid
$token_id = $csrf->get_token_id();
$token_value = $csrf->get_token($token_id);

// Generate Random Form Names
$field_names = $csrf->form_names(array('username', 'password'), false);


if (isset($_POST[$field_names['username']], $_POST[$field_names['password']])) {
	if ($csrf->check_valid('post')) {

		dbconn('127.0.0.1', $database_name, $database_user, $database_password);

		$chk_user = dbq("select * from users_tbl where username='{$_POST[$field_names['username']]}'");
		if (dbr($chk_user) > 0) {
			$user_ = dbf($chk_user);
			if (password_verify($_POST[$field_names['password']], $user_['password'])) {
				$user_['password'] = '********';
				$_SESSION['user'] = $user_;
				go('dashboard.php');
			} else {
				$error[] = "Incorrect username or password! wrong-pass";
			}
		} else {
			$error[] = "Incorrect username or password! no-user";
		}
	} else {
		$error[] = "Incorrect username or password! csrf";
	}
	$field_names = $csrf->form_names(array('username', 'password'), true);
}

include "includes/inc.header.php";
?>
<!-- start: page -->
<section class="body-sign">
	<div class="center-sign">
		<div class="main_logo"><img src="img/logos/teambase_logo.png" height="169" alt="teambase" /></div>
		<div class="panel card-sign">
			<div class="card-title-sign mt-3 text-end">
				<h2 class="title text-uppercase font-weight-bold m-0"><i class="bx bx-user-circle me-1 text-6 position-relative top-5"></i>Sign In</h2>
			</div>
			<div class="card-body">
				<form method="post">
					<input type="hidden" name="<?= $token_id; ?>" value="<?= $token_value; ?>" />
					<div class="form-group mb-3">
						<label>Username</label>
						<div class="input-group">
							<input name="<?= $field_names['username'] ?>" type="text" class="form-control form-control-lg" />
							<span class="input-group-text">
								<i class="bx bx-user text-4"></i>
							</span>
						</div>
					</div>

					<div class="form-group mb-3">
						<div class="clearfix">
							<label class="float-left">Password</label>
							<a href="recover-password.php" class="float-end">Lost Password?</a>
						</div>
						<div class="input-group">
							<input name="<?= $field_names['password'] ?>" type="password" class="form-control form-control-lg" />
							<span class="input-group-text">
								<i class="bx bx-lock text-4"></i>
							</span>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-8">
							<div class="checkbox-custom checkbox-default">
								<input id="RememberMe" name="rememberme" type="checkbox" />
								<label for="RememberMe">Remember Me</label>
							</div>
						</div>
						<div class="col-sm-4 text-end">
							<button name="sign-in" type="submit" class="btn btn-primary mt-2">Sign In</button>
						</div>
					</div>
					<div class="row p-2">
						<?php
						require "includes/inc.alertmsg.php";
						?>
					</div>
				</form>
			</div>
		</div>

		<p class="text-center text-muted mt-3 mb-3">TeamBase &copy; Copyright 2022. All Rights Reserved. Alpha v2.0.2</p>
	</div>
</section>
<!-- end: page -->