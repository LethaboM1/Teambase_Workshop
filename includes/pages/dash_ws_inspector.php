<?php
if ($_SESSION['user']['role'] != 'ws_inspector') {
	exit();
}
