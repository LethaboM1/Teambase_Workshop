<?php

if (file_exists('vendor/autoload.php')) {
	require_once 'vendor/autoload.php';
} else {
	require_once '../vendor/autoload.php';
}

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

function validateDate($date, $format = 'Y-m-d')
{
	$d = DateTime::createFromFormat($format, $date);
	// The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
	return $d && $d->format($format) === $date;
}

function sms_($number, $message)
{

	$to = $number . "@e-mail2sms.co.za";     //Add a recipient                    
	$subject = "#duncanm@digitalextreme.co.za,dx0392781#";
	$body = $message;
	@mail($to, $subject, $body);
}

function csvToArray($file, $has_header = 0, $delimiter = ',')
{
	$rows = array();
	$headers = array();
	if (file_exists($file) && is_readable($file)) {
		$handle = fopen($file, 'r');
		while (!feof($handle)) {
			if ($delimiter == 'tab') {
				$row = fgetcsv($handle, 10240, "\t");
			} else {
				$row = fgetcsv($handle, 10240, $delimiter);
			}

			$row[0] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $row[0]);

			if ($has_header) {
				if (empty($headers)) {
					$headers = $row;
				} else if (is_array($row)) {
					array_splice($row, count($headers));
					$rows[] = $row;
				}
			} else {
				if (is_array($row)) {
					//array_splice($row, count($headers));
					$rows[] = $row;
				}
			}
		}
		fclose($handle);
	} else {
		throw new Exception($file . ' doesn`t exist or is not readable.');
	}
	return $rows;
}

function dbconn($server, $database, $user, $pass)
{
	global $db, $error;
	$db = mysqli_connect($server, $user, $pass, $database);
	if ($db->connect_error) {
		$error[] = "Connection Error. " . $db->connect_error;
	}
}

function error($msg)
{
	$_SESSION['error'][] = $msg;
}

function msg($msg)
{
	$_SESSION['msg'][] = $msg;
}

function sqlError($userMsg = 'SQL Error', $debugMsg = 'SQL error')
{
	global $debug;
	global $error;

	if ($debug) {
		$error[] = $debugMsg . ": " . dbe();
	} else {
		$error[] = $userMsg;
	}
}


function validPass($password)
{
	$uppercase = preg_match('@[A-Z]@', $password);
	$lowercase = preg_match('@[a-z]@', $password);
	$number    = preg_match('@[0-9]@', $password);
	$specialChars = preg_match('@[^\w]@', $password);

	if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
		return false;
	} else {
		return true;
	}
}

function cleanPost()
{
	global $raw_post;
	$raw_post = $_POST;
	if (isset($_POST)) {
		foreach ($_POST as $key => $val) {
			if (!is_array($_POST[$key])) {
				$_POST[$key] = esc($_POST[$key]);
			}
		}
	}
}

function open_modal($modal_id)
{
	global $jscript;
	$jscript .= "
				$('#{$modal_id}').modal('show');
				";
}



/*
function modal($id, $header, $body, $type = 'form', $size = 'lg', $ajax = 0, $disableEnter = 1)
{
	global $modal, $jscript;

	$jscript .= "
				dragElement(document.getElementById(`{$id}`));
			";
	/* 
	
	modal-dialog-centered
	*//*
	$form = "<!-- Modal -->
			<div style='position: fixed;' class='modal fade animated' id='" . $id . "' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
			<div class='modal-dialog modal-{$size} ' role='document'>
				<div class='modal-content'>
				<div style='cursor: move;' id='{$id}header' class='modal-header'>
					<h5 class='modal-title' id='exampleModalLongTitle'>" . $header . "</h5>
					<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
					<span aria-hidden='true'>&times;</span>
					</button>
				</div>
				<div class='modal-body'>";

	if ($type == "form") {
		if ($disableEnter) {
			$class = 'disableEnter';
		} else {
			$class = '';
		}
		$form .= "<form class='{$class}' method='post' enctype='multipart/form-data'>$body</form>";
	} else {
		$form .= $body;
	}

	$form .= "			</div>
				<div class='modal-footer'>
					
				</div>
				</div>
			</div>
			</div>"; //<button type='button' class='btn btn-danger' data-dismiss='modal'>Close</button>

	$modal .=  $form;


	if ($ajax) {
		$_SESSION['modal'] = $modal;
	}
}
*/


function modal($id, $header, $body, $btn_name = '', $btn_value = '', $type = 'form', $size = 'lg', $ajax = 0, $disableEnter = 1)
{
	global $modal, $jscript;

	$jscript .= "
				dragElement(document.getElementById(`{$id}`));
			";
	/* 
	
	modal-dialog-centered
	*/
	$form = "<div id='" . $id . "' class='modal-block modal-block-lg mfp-hide'>";
	if ($type == "form") {
		if ($disableEnter) {
			$class = 'disableEnter';
		} else {
			$class = '';
		}
		$form .= "<form class='{$class}' method='post' enctype='multipart/form-data'>";
	}
	$form .= "<section class='card'>
				<header id='{$id}header' class='card-header'>
					<h2 class='card-title'>" . $header . "</h2>
				</header>
				<div class='card-body'>
					<div class='modal-wrapper'>
						<div class='modal-text'>
							{$body}
						</div>
					</div>
				</div>
				<footer class='card-footer'>
					<div class='row'>
						<div class='col-md-12 text-right'>";
	if (strlen($btn_name) > 0) {
		$form .= "<button type='submit' name='{$btn_value}' value='{$btn_name}' class='btn btn-primary'>{$btn_name}</button>";
	}
	$form .= "
							<button class='btn btn-default modal-dismiss'>Cancel</button></div>
					</div>
				</footer>
			</section>";

	if ($type == "form") {
		$form .= "</form>";
	}

	$form .= "</div>"; //<button type='button' class='btn btn-danger' data-dismiss='modal'>Close</button>

	$modal .=  $form;


	if ($ajax) {
		$_SESSION['modal'] = $modal;
	}
}




function add_log($message, $type = "error")
{

	if (file_exists("../logs")) {
		$log_file = "../logs/app_{$type}.log";
	} else if (file_exists("../../logs")) {
		$log_file = "../../logs/app_{$type}.log";
	} else if (file_exists("logs")) {
		$log_file = "logs/app_{$type}.log";
	}

	if (strlen($message) > 0) {
		file_put_contents($log_file, date("Y-m-d H:i:s : ") . $message . PHP_EOL, FILE_APPEND);
	}
}


//mysqli_fetch_array to dbf
function dbf($sql)
{
	return mysqli_fetch_array($sql);
}

//mysqli_query($db, to dbq
function dbq($query)
{
	global $db;
	return mysqli_query($db, $query);
}

// header("location: to go
function go($url)
{
	header("location: $url");
}

//mysqli_num_rows to dbr
function dbr(mysqli_result $sql)
{
	return mysqli_num_rows($sql);
}

function dbe()
{
	global $db;
	return mysqli_error($db);
}

function esc($text, $db_connect = "")
{
	global $db, $hire;
	if (strlen($db_connect) > 0) {
		return mysqli_real_escape_string($hire, $text);
	} else {
		global $db;
		return mysqli_real_escape_string($db, $text);
	}
}

function inp($name, $label, $type = 'text', $value = '', $class = '', $required = false, $select_list = '', $extra = '')
{ //insp('name','Name');
	$type = strtolower($type);
	global $time_mask;

	switch ($type) {

		case "datalist":
			$form = "<datalist id='datalist_{$name}'>";
			if (is_array($select_list)) {
				foreach ($select_list as $option) {
					$form .= "<option value='{$option['value']}'>{$option['name']}</option>";
				}
			}
			$form .= "</datalist>";
			/* 
			<label class="col-form-label">Plant Number</label>
							<input type="text" name="plantNumber" placeholder="HP5885" class="form-control">
			*/
			$form .= "<label class='col-form-label'>Plant Number</label>
					<input list='datalist_{$name}' autoComplete='off' class='form-control ";
			if ($required) {
				$form .=  "required";
				$extra .= ' required';
			}
			$form .=  "' name='datalist_" . $name . "_input' id ='datalist_" . $name . "_input' value='" . $value . "' " . $extra . ">";
			$jscript = "
					<script>
						document.querySelector('#datalist_{$name}_input').addEventListener('input', function(e) {
							var input = e.target,   
								list = input.getAttribute('list'),
								options = document.querySelectorAll('#' + list + ' option[value=\"'+input.value+'\"]'),
								hiddenInput = document.getElementById('{$name}');
						
							if (options.length > 0) {
								hiddenInput.value = input.value;
								$('#{$name}').trigger('change');
								input.value = options[0].innerText;
							}						
						});
					</script>
			";
			$form .= "<input type='hidden' name='{$name}' id='{$name}'>";

			return $form . $jscript;
			break;


		case "multi_select":
			$form = "<div class='form-group'>
		<label>" . $label . "</label>
				<select {$extra} name='$name' id='$name' class='form-control $class' multiple searchable='Search here..'>";
			if (is_array($select_list)) {
				foreach ($select_list as $row) {
					$form .= "<option ";
					if ($row['value'] == $value) {
						$form .= "selected='selected' ";
					}
					$form .= "value='" . $row['value'] . "'>" . $row['name'] . "</option>";
				}
			}


			$form .= "</select>
				</div>
                ";
			return $form;
			break;

		case "radio":
			$form = "<div class='form-group'>
			<label>
			<input type='radio'";
			if (isset($class)) {
				$form .=  " class='$name $class' $extra";
			}
			if ($select_list) {
				$form .= " checked='checked'";
			}
			$form .=  " name='" . $name . "' id ='$name' value='$value'>&nbsp;" . $label . "</label>
			</div>";

			return $form;
			break;

		case "select":



			$form = "<div class='col-sm-12 col-md-4 pb-sm-3 pb-md-0'>";

			if (strlen($label) > 0) {
				$form .= "<label class='col-form-label'>" . $label . "</label>";
			}


			$form .= "<select {$extra} class='form-control mb-3 $class ";
			if ($required) {
				$form .=  "required";
			}
			$form .=  "' name='" . $name . "' id ='" . $name . "' autocomplete='off'>";
			if (isset($select_list) && is_array($select_list)) {
				foreach ($select_list as $select) {
					if ($select['style'] == 'bold') {
						$style = "style='font-weight: {$select['style']};'";
					} else if ($select['style'] == 'italic') {
						$style = "style='font-style: {$select['style']};'";
					} else {
						$style = "";
					}
					if ($select['value'] == $value) {
						$form .= "<option {$style} selected='selected' value='" . $select['value'] . "'>" . $select['name'] . "</option>";
					} else {
						$form .= "<option {$style} value='" . $select['value'] . "'>" . $select['name'] . "</option>";
					}
				}
			}


			$form .= "</select>";


			$form .= "</div>";


			return $form;
			break;

		case "text":
			$form = '';
			if (strlen($label) > 0) {
				$form .= "<div class='form-group'>
						<label>" . $label . "</label>";
			}

			$form .= "<input type='" . $type . "' class='form-control ";
			if ($required) {
				$form .=  "required";
				$extra .= ' required';
			}
			$form .=  "' name='" . $name . "' id ='" . $name . "' value='" . $value . "' " . $extra . ">";

			if (strlen($label) > 0) {
				$form .= "</div>";
			}

			return $form;
			break;

		case "email":
			$form = '';
			if (strlen($label) > 0) {
				$form .= "<div class='form-group'>
						<label>" . $label . "</label>";
			}

			$form .= "<input type='" . $type . "' class='form-control ";
			if ($required) {
				$form .=  "required";
			}
			$form .=  "' name='" . $name . "' id ='" . $name . "' value='" . $value . "' " . $extra . ">";

			if (strlen($label) > 0) {
				$form .= "</div>";
			}

			return $form;
			break;

		case "password":
			$form = '';
			if (strlen($label) > 0) {
				$form .= "<div class='form-group'>
						<label>" . $label . "</label>";
			}

			$form .= "<input type='" . $type . "' class='form-control ";
			if ($required) {
				$form .=  "required";
			}
			$form .=  "' name='" . $name . "' id ='" . $name . "'>";

			if (strlen($label) > 0) {
				$form .= "</div>";
			}

			return $form;
			break;

		case "fake-creds":
			$form = '';
			$form .= "<input style='display:none;' type='email' class='form-control' name='fake_username' id ='fake_username'>";
			$form .= "<input style='display:none;' type='password' class='form-control' name='fake_password' id ='fake_password'>";


			return $form;
			break;

		case "price":
			$form = '';
			$form .= "<div class='form-group'>
				<label>" . $label . "</label>
				<input data-inputmask=\" 'alias': 'decimal', 'groupSeparator': '', 'autoGroup': true, 'rightAlign' : false, 'digits': 2, 'digitsOptional': false, 'placeholder': '0.00'\" type='text' class='form-control ";
			if ($required) {
				$form .=  " required";
			}
			$form .=  "' name='" . $name . "' id='price_field_$name' value='" . $value . "' " . $extra . ">
				</div>";

			return $form;
			break;


		case "price-td":
			$form = '';
			$form .= "<input data-inputmask=\" 'alias': 'decimal', 'groupSeparator': '', 'autoGroup': true, 'rightAlign' : false, 'digits': 2, 'digitsOptional': false, 'placeholder': '0.00'\" type='text' class='{$class}";
			if ($required) {
				$form .=  " required";
			}
			$form .=  "' name='" . $name . "' id='price_field_$name' value='" . $value . "' " . $extra . "/>";

			return $form;
			break;


		case "time":
			$form = '';
			$form .= "<div class='form-group'>
				<label>" . $label . "</label>
				<input data-inputmask=\"'alias':'datetime','inputFormat': 'HH:MM'\" type='text' class='form-control ";
			if ($required) {
				$form .=  " required'";
			}
			$form .=  "' name='" . $name . "' id='price_field_$name' value='" . $value . "' " . $extra . ">
				</div>";

			return $form;
			break;

		case "date":
			$form = '';
			$form .= "<div class='form-group'>
		 <label>" . $label . "</label>
		 <input type='" . $type . "' class='form-control ";
			if ($required) {
				$form .=  "required";
			}
			$form .=  "' name='" . $name . "' id ='" . $name . "' value='" . $value . "' " . $extra . ">
		</div>";

			return $form;
			break;


		case "datetime":
			$form = '';
			$form .= "<div class='form-group'>
			 <label>" . $label . "</label>
			 <input type='datetime-local' class='form-control ";
			if ($required) {
				$form .=  "required";
			}
			$form .=  "' name='" . $name . "' id ='" . $name . "' value='" . $value . "' " . $extra . ">
			</div>";

			return $form;
			break;

		case "number":
			$form = '';
			$form .= "<div class='form-group'>";
			if (strlen($label) > 0) {
				$form .= "<label>" . $label . "</label>";
			}

			$form .= "<input type='" . $type . "'  class='form-control $class";
			if ($required) {
				$form .=  " required";
			}
			$form .=  "' name='" . $name . "' id ='" . $name . "' value='" . $value . "' " . $extra . ">
		</div>";

			return $form;
			break;

		case "percentage":
			$form = '';
			$form .= "<div class='form-group'>
		 <label>" . $label . "</label>
		 <input data-inputmask=\"'mask':'[9][9]'\" type='number' min='0' max='99' class='form-control $class' ";
			if ($required) {
				$form .=  "required";
			}
			$form .=  " name='" . $name . "' id ='" . $name . "' value='" . $value . "' " . $extra . ">
		</div>";

			return $form;
			break;

		case "checkbox":
			$form = '';
			$form .= "<div class='form-group'>
		 <label>
		 <input type='checkbox'";
			if (isset($class)) {
				$form .=  " class='$class' $extra";
			}
			if ($select_list) {
				$form .= " checked='checked'";
			}
			$form .=  " name='" . $name . "' id ='" . $name . "' value='$value'>&nbsp;" . $label . "</label>
		</div>";

			return $form;
			break;

		case "active-toggle":
			$form = '';
			$form .= "<div class='form-group'>
				<label>{$label}</label><br>
				<input type='checkbox'  data-toggle='toggle' data-on='Active' data-off='Suspend' data-width='95px' data-offstyle='danger' data-onstyle='success'";
			if (isset($class)) {
				$form .=  " class='$class' $extra";
			}
			if ($select_list) {
				$form .= " checked='checked'";
			}
			$form .=  " name='" . $name . "' id ='" . $name . "' value='$value'></div>";
			return $form;
			break;

		case "choice-toggle":
			$form = '';
			$form .= "<div class='form-group'>
				<label>{$label}</label><br>
				<input type='checkbox' data-toggle='toggle' data-on='Yes' data-off='No'  data-width='80px' data-offstyle='danger' data-onstyle='success'";
			if (isset($class)) {
				$form .=  " class='$class' $extra";
			}
			if ($select_list) {
				$form .= " checked='checked'";
			}
			$form .=  " name='" . $name . "' id ='" . $name . "' value='$value'>
		 </div>";
			return $form;
			break;

		case "hidden":
			$form = '';
			$form .= "<input type='" . $type . "' id='" . $name . "'  name='" . $name . "' value='" . $value . "'>";

			return $form;
			break;

		case "submit":
			$form = '';
			$form .= "<div class='form-group'>";
			if (strlen($label) > 0) {
				$form .= "<label>" . $label . "</label><br>";
			}
			$form .= "<input type='" . $type . "' class='btn $class' name='" . $name . "' id ='" . $name . "' value='" . $value . "' " . $extra . "></div>";


			return $form;
			break;

		case "inline-submit":
			$form = '';

			if (strlen($label) > 0) {
				$form .= "<label>" . $label . "</label>";
			}
			$form .= "<input type='submit' class='btn $class' name='" . $name . "' id ='" . $name . "' value='" . $value . "'  " . $extra . ">&nbsp;";

			return $form;
			break;

		case "button":
			$form = '';
			if (strlen($label) > 0) {
				$form .= "<label>" . $label . "</label>";
			}
			$form .= "<button " . $extra . " class='btn $class' name='" . $name . "' id ='" . $name . "'>" . $value . "</button><br>";


			return $form;
			break;

		case "inline-button":
			$form = '';

			if (strlen($label) > 0) {
				$form .= "<label>" . $label . "</label>";
			}
			$form .= "<button " . $extra . " class='btn $class' name='" . $name . "' id ='" . $name . "'>" . $value . "</button>&npsp;";


			return $form;
			break;



		case "textarea":
			$form = '';
			$form .= "<div class='form-group'>
		 <label>" . $label . "</label>
		 <textarea class='form-control ";
			if ($required) {
				$form .= "required";
			}
			$form .= "' rows='3' name='" . $name . "'  id='" . $name . "' {$extra}>$value</textarea>
		</div>";

			return $form;
			break;

		case "file":
			$form = '';
			$form .= "<div class='form-group'>
		 <label>" . $label . "</label>
		 <input type='" . $type . "' class='";
			if ($required) {
				$form .=  "required";
			}
			$form .=  "' name='" . $name . "'>
		</div>";
			return $form;
			break;

		case "image":
			$form = '';
			$form .= "<div class='form-group'>
		 <label>" . $label . "</label>
		 <input type='file' class='";
			if ($required) {
				$form .=  "required";
			}
			$form .=  "' name='" . $name . "'>
		</div>";
			if (strlen($value) > 0) {
				if (file_exists($value)) {
					$logo = base64_encode(file_get_contents($value));
					$extension = pathinfo($value, PATHINFO_EXTENSION);
					$form .= "<div class='form-group'><img class='img-rounded' width='300' src='data:image/{$extension};base64,{$logo}'/></div>";
				} else {
					$form .= "<b>No logo {$value}</b>";
				}
			}
			return $form;
			break;
	}
}



function printPDF($pdf_html, $pdf_filename = 'temp', $pdf_save = false, $pdf_open = false, $pdf_orientation = 'P', $pdf_page = 'A4', $stylesheet = '', $mail_ = false, $email_address = '')
{
	global $error;

	if (strlen($pdf_page) == 0) {
		$pdf_page = 'A4';
	}
	if (strlen($pdf_orientation) == 0) {
		$pdf_orientation = 'P';
	}
	if (strlen($pdf_filename) == 0) {
		$pdf_filename = 'temp';
	}
	if (!$pdf_open && !$pdf_save) {
		$pdf_open = true;
	}


	if (strlen($pdf_html) > 0) {
		//require_once('assets/html2pdf/html2pdf.class.php');
		try {

			$html2pdf = new Html2Pdf($pdf_orientation, $pdf_page, 'en', true, 'UTF-8');
			if (strlen($stylesheet) > 0) {
				if (file_exists($stylesheet)) {
					$style = file_get_contents($stylesheet);
					$html2pdf->writeHTML("<style>" . $style . "</style>");
				} else {
					//$_SESSION['error'] = "Could not find stylesheet: " . $stylesheet;
				}
			}

			$html2pdf->writeHTML($pdf_html);
			unset($pdf_html);


			if ($pdf_open) {
				$html2pdf->Output("$pdf_filename.pdf");
			}

			if ($pdf_save) {
				$html2pdf->Output("$pdf_filename.pdf", "F");
			}
		} catch (Html2PdfException $e) {
			echo  $e;
			exit;
		}
	}
}

/*
if (file_exists('../includes/za.json')) {
	$json_holidays = file_get_contents('../includes/za.json');
} else {
	$json_holidays = file_get_contents('../../includes/za.json');
}

$data_holidays = json_decode($json_holidays, true);
$a = 0;
foreach ($data_holidays['holidays'] as $holiday) {
	$holidays[] = $holiday['date']['iso'];
	$a++;
}


*/

function calc_hours($from, $to)
{
	$to = strtotime($to);
	$from = strtotime($from);
	$hours = ceil(($to - $from) / 3600);
	/*
	$date1 = new DateTime($from);
	$date2 = new DateTime($to);

	$diff = $date2->diff($date1);

	$hours = $diff->h;
	$hours = $hours + ($diff->days * 24);
	*/
	return $hours;
}

function getWorkingDays($startDate, $endDate, $holidays)
{
	$skipped_days = 0;
	$s_date = date_format(date_create($startDate), 'Y-m-d');
	$e_date = date_format(date_create($endDate), 'Y-m-d');
	// do strtotime calculations just once
	$endDate = strtotime($e_date);
	$startDate = strtotime($s_date);


	//The total number of days between the two dates. We compute the no. of seconds and divide it to 60*60*24
	//We add one to inlude both dates in the interval.
	$days = ($endDate - $startDate) / 86400 + 1;

	$no_full_weeks = floor($days / 7);
	$no_remaining_days = fmod($days, 7);

	//It will return 1 if it's Monday,.. ,7 for Sunday
	$the_first_day_of_week = date("N", $startDate);
	$the_last_day_of_week = date("N", $endDate);

	//---->The two can be equal in leap years when february has 29 days, the equal sign is added here
	//In the first case the whole interval is within a week, in the second case the interval falls in two weeks.
	if ($the_first_day_of_week <= $the_last_day_of_week) {
		if (!$_SESSION['account']['hire_saterday']) {
			if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
		}

		if (!$_SESSION['account']['hire_sunday']) {
			if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
		}
	} else {
		// (edit by Tokes to fix an edge case where the start day was a Sunday
		// and the end day was NOT a Saturday)

		// the day of the week for start is later than the day of the week for end
		if ($the_first_day_of_week == 7) {
			// if the start date is a Sunday, then we definitely subtract 1 day
			$no_remaining_days--;

			if ($the_last_day_of_week == 6) {
				// if the end date is a Saturday, then we subtract another day
				$no_remaining_days--;
			}
		} else {
			// the start date was a Saturday (or earlier), and the end date was (Mon..Fri)
			// so we skip an entire weekend and subtract 2 days
			if (!$_SESSION['account']['hire_saterday']) {
				$skipped_days++;
			}
			if (!$_SESSION['account']['hire_sunday']) {
				$skipped_days++;
			}
			$no_remaining_days -= $skipped_days;
			error_log("skipped days = {$skipped_days}");
		}
	}

	//The no. of business days is: (number of weeks between the two dates) * (5 working days) + the remainder
	//---->february in none leap years gave a remainder of 0 but still calculated weekends between first and last day, this is one way to fix it
	$days = 5;

	if ($_SESSION['account']['hire_saterday']) {
		$days++;
	}

	if ($_SESSION['account']['hire_sunday']) {
		$days++;
	}

	$workingDays = $no_full_weeks * $days; //5 days usually -Duncan
	if ($no_remaining_days > 0) {
		$workingDays += $no_remaining_days;
	}

	//We subtract the holidays
	if (!$_SESSION['account']['hire_holiday']) {
		foreach ($holidays as $holiday) {
			$time_stamp = strtotime($holiday);
			//If the holiday doesn't fall in weekend
			if ($_SESSION['account']['hire_saterday'] && $_SESSION['account']['hire_sunday']) {
				$workingDays--;
			} else if ($_SESSION['account']['hire_saterday'] && !$_SESSION['account']['hire_sunday']) {
				if ($startDate <= $time_stamp && $time_stamp <= $endDate  && date("N", $time_stamp) != 7) //&& date("N",$time_stamp) != 6 -Duncan
					$workingDays--;
			} else if (!$_SESSION['account']['hire_saterday'] && $_SESSION['account']['hire_sunday']) {
				if ($startDate <= $time_stamp && $time_stamp <= $endDate  && date("N", $time_stamp) != 6) //&& date("N",$time_stamp) != 6 -Duncan
					$workingDays--;
			} else if (!$_SESSION['account']['hire_saterday'] && !$_SESSION['account']['hire_sunday']) {
				if ($startDate <= $time_stamp && $time_stamp <= $endDate  && date("N", $time_stamp) != 7 && date("N", $time_stamp) != 6) // -Duncan
					$workingDays--;
			}
		}
	}

	return $workingDays;
}

function prettyJson($json)
{
	$result = '';
	$level = 0;
	$in_quotes = false;
	$in_escape = false;
	$ends_line_level = NULL;
	$json_length = strlen($json);

	for ($i = 0; $i < $json_length; $i++) {
		$char = $json[$i];
		$new_line_level = NULL;
		$post = "";
		if ($ends_line_level !== NULL) {
			$new_line_level = $ends_line_level;
			$ends_line_level = NULL;
		}
		if ($in_escape) {
			$in_escape = false;
		} else if ($char === '"') {
			$in_quotes = !$in_quotes;
		} else if (!$in_quotes) {
			switch ($char) {
				case '}':
				case ']':
					$level--;
					$ends_line_level = NULL;
					$new_line_level = $level;
					break;

				case '{':
				case '[':
					$level++;
				case ',':
					$ends_line_level = $level;
					break;

				case ':':
					$post = " ";
					break;

				case " ":
				case "\t":
				case "\n":
				case "\r":
					$char = "";
					$ends_line_level = $new_line_level;
					$new_line_level = NULL;
					break;
			}
		} else if ($char === '\\') {
			$in_escape = true;
		}
		if ($new_line_level !== NULL) {
			$result .= "\n" . str_repeat("\t", $new_line_level);
		}
		$result .= $char . $post;
	}

	return $result;
}


function folders_($type, $plant_id)
{
	if (!file_exists("./files")) {
		if (!mkdir("./files")) {
			error("Could not create folder: Files.");
			return false;
		}
	}

	switch ($type) {
		case "operator_log":
			if (!file_exists("./files/operator_logs")) {
				if (!mkdir("./files/operator_logs")) {
					error("Could not create folder for logs.");
					return false;
				}
			}

			if (!file_exists("./files/operator_logs/{$plant_id}")) {
				if (!mkdir("./files/operator_logs/{$plant_id}")) {
					error("Could not create folder for plant {$plant_id}.");
					return false;
				}
			}

			if (!is_error()) {
				return "./files/operator_logs/{$plant_id}/";
			}
			break;
		default:
			error("Wrong option.");
			return false;
	}
}

function get_hours($from_datetime, $to_datetime)
{
	$date1 = $from_datetime;
	$date2 = $to_datetime;
	$timestamp1 = strtotime($date1);
	$timestamp2 = strtotime($date2);
	return abs($timestamp2 - $timestamp1) / (60 * 60);
}

function get_operator_log($plant_id, $user_id)
{
	$get_operator_log = dbq("select * from operator_log where plant_id={$plant_id} and operator_id={$user_id} and status!='E'");
	if ($get_operator_log) {
		if (dbr($get_operator_log) > 0) {
			$operator_log = dbf($get_operator_log);
			return $operator_log;
		} else {
			return false;
		}
	} else {
		return false;
	}
}

function upload_images($type, $id, $id_2, $photos, $key)
{
	switch ($type) {
		case "start_refuel":
			$chk_operator = dbq("select user_id from users_tbl where user_id={$id}");
			if ($chk_operator) {
				if (dbr($chk_operator) > 0) {
					$chk_plant = dbq("select plant_id from plants_tbl where plant_id={$id_2}");
					if ($chk_plant) {
						if (dbr($chk_plant) > 0) {
							if (is_array($photos)) {
								if (count($photos) > 0) {
									if ($folder = folders_('operator_log', $id_2)) {
										$count = 1;
										foreach ($photos as $photo) {
											$img_type = explode('/', $photo['type']);
											$extension = $img_type[1];
											//error_log('type = ' . $photo['type'] . ' ,Extension=' . $extension);
											$base64data = str_replace('data:image/jpeg;base64,', '', $photo['image']);
											//error_log("image = " . $folder . $key . '.' . $count . '.' . $extension);
											if (file_put_contents($folder . $key . '-refuel-start-' . $count . '.' . $extension, base64_decode($base64data))) {
											}
											$count++;
										}
										return true;
									} else {
										error("Error with folders.");
										return false;
									}
								} else {
									error("You have not submitted a photo.");
									return false;
								}
							} else {
								error('invalid photo data.');
								return false;
							}
						} else {
							error("No plant.");
							return false;
						}
					} else {
						sqlError('', 'Upload images: plant');
						return false;
					}
				} else {
					error("No operator.");
					return false;
				}
			} else {
				sqlError('', 'upload images: operator');
				return false;
			}
			break;

		case "end_refuel":
			$chk_operator = dbq("select user_id from users_tbl where user_id={$id}");
			if ($chk_operator) {
				if (dbr($chk_operator) > 0) {
					$chk_plant = dbq("select plant_id from plants_tbl where plant_id={$id_2}");
					if ($chk_plant) {
						if (dbr($chk_plant) > 0) {
							if (is_array($photos)) {
								if (count($photos) > 0) {
									if ($folder = folders_('operator_log', $id_2)) {
										$count = 1;
										foreach ($photos as $photo) {
											$img_type = explode('/', $photo['type']);
											$extension = $img_type[1];
											//error_log('type = ' . $photo['type'] . ' ,Extension=' . $extension);
											$base64data = str_replace('data:image/jpeg;base64,', '', $photo['image']);
											//error_log("image = " . $folder . $key . '.' . $count . '.' . $extension);
											if (file_put_contents($folder . $key . '-refuel-end-' . $count . '.' . $extension, base64_decode($base64data))) {
											}
											$count++;
										}
										return true;
									} else {
										error("Error with folders.");
										return false;
									}
								} else {
									error("You have not submitted a photo.");
									return false;
								}
							} else {
								error('invalid photo data.');
								return false;
							}
						} else {
							error("No plant.");
							return false;
						}
					} else {
						sqlError('', 'Upload images: plant');
						return false;
					}
				} else {
					error("No operator.");
					return false;
				}
			} else {
				sqlError('', 'upload images: operator');
				return false;
			}
			break;

		case "breakdown_end":
			$chk_operator = dbq("select user_id from users_tbl where user_id={$id}");
			if ($chk_operator) {
				if (dbr($chk_operator) > 0) {
					$chk_plant = dbq("select plant_id from plants_tbl where plant_id={$id_2}");
					if ($chk_plant) {
						if (dbr($chk_plant) > 0) {
							if (is_array($photos)) {
								if (count($photos) > 0) {
									if ($folder = folders_('operator_log', $id_2)) {
										$count = 1;
										foreach ($photos as $photo) {
											$img_type = explode('/', $photo['type']);
											$extension = $img_type[1];
											//error_log('type = ' . $photo['type'] . ' ,Extension=' . $extension);
											$base64data = str_replace('data:image/jpeg;base64,', '', $photo['image']);
											//error_log("image = " . $folder . $key . '.' . $count . '.' . $extension);
											if (file_put_contents($folder . $key . '-breakdown-end-' . $count . '.' . $extension, base64_decode($base64data))) {
											}
											$count++;
										}
										return true;
									} else {
										error("Error with folders.");
										return false;
									}
								} else {
									error("You have not submitted a photo.");
									return false;
								}
							} else {
								error('invalid photo data.');
								return false;
							}
						} else {
							error("No plant.");
							return false;
						}
					} else {
						sqlError('', 'Upload images: plant');
						return false;
					}
				} else {
					error("No operator.");
					return false;
				}
			} else {
				sqlError('', 'upload images: operator');
				return false;
			}
			break;

		case "breakdown_start":
			$chk_operator = dbq("select user_id from users_tbl where user_id={$id}");
			if ($chk_operator) {
				if (dbr($chk_operator) > 0) {
					$chk_plant = dbq("select plant_id from plants_tbl where plant_id={$id_2}");
					if ($chk_plant) {
						if (dbr($chk_plant) > 0) {
							if (is_array($photos)) {
								if (count($photos) > 0) {
									if ($folder = folders_('operator_log', $id_2)) {
										$count = 1;
										foreach ($photos as $photo) {
											$img_type = explode('/', $photo['type']);
											$extension = $img_type[1];
											//error_log('type = ' . $photo['type'] . ' ,Extension=' . $extension);
											$base64data = str_replace('data:image/jpeg;base64,', '', $photo['image']);
											//error_log("image = " . $folder . $key . '.' . $count . '.' . $extension);
											if (file_put_contents($folder . $key . '-breakdown_start-' . $count . '.' . $extension, base64_decode($base64data))) {
											}
											$count++;
										}
										return true;
									} else {
										error("Error with folders.");
										return false;
									}
								} else {
									error("You have not submitted a photo.");
									return false;
								}
							} else {
								error('invalid photo data.');
								return false;
							}
						} else {
							error("No plant.");
							return false;
						}
					} else {
						sqlError('', 'Upload images: plants');
						return false;
					}
				} else {
					error("No operator.");
					return false;
				}
			} else {
				sqlError('', 'Upload images: operator');
				return false;
			}
			break;

		case "operator_log_start":
			$chk_operator = dbq("select user_id from users_tbl where user_id={$id}");
			if ($chk_operator) {
				if (dbr($chk_operator) > 0) {
					$chk_plant = dbq("select plant_id from plants_tbl where plant_id={$id_2}");
					if ($chk_plant) {
						if (dbr($chk_plant) > 0) {
							if (is_array($photos)) {
								if (count($photos) > 0) {
									if ($folder = folders_('operator_log', $id_2)) {
										$count = 1;
										foreach ($photos as $photo) {
											$img_type = explode('/', $photo['type']);
											$extension = $img_type[1];
											//error_log('type = ' . $photo['type'] . ' ,Extension=' . $extension);
											$base64data = str_replace('data:image/jpeg;base64,', '', $photo['image']);
											//error_log("image = " . $folder . $key . '.' . $count . '.' . $extension);
											if (file_put_contents($folder . $key . '-start-' . $count . '.' . $extension, base64_decode($base64data))) {
											}
											$count++;
										}
										return true;
									} else {
										error("Error with folders.");
										return false;
									}
								} else {
									error("You have not submitted a photo.");
									return false;
								}
							} else {
								error('invalid photo data.');
								return false;
							}
						} else {
							error("No plant.");
							return false;
						}
					} else {
						sqlError('', 'Upload images: plant');
						return false;
					}
				} else {
					error("No operator.");
					return false;
				}
			} else {
				sqlError('', 'upload images: operator');
				return false;
			}
			break;

		case "operator_log_end":
			$chk_operator = dbq("select user_id from users_tbl where user_id={$id}");
			if ($chk_operator) {
				if (dbr($chk_operator) > 0) {
					$chk_plant = dbq("select plant_id from plants_tbl where plant_id={$id_2}");
					if ($chk_plant) {
						if (dbr($chk_plant) > 0) {
							if (is_array($photos)) {
								if (count($photos) > 0) {
									if ($folder = folders_('operator_log', $id_2)) {
										$count = 1;
										foreach ($photos as $photo) {
											$img_type = explode('/', $photo['type']);
											$extension = $img_type[1];
											//error_log('type = ' . $photo['type'] . ' ,Extension=' . $extension);
											$base64data = str_replace('data:image/jpeg;base64,', '', $photo['image']);
											//error_log("image = " . $folder . $key . '.' . $count . '.' . $extension);
											if (file_put_contents($folder . $key . '-end-' . $count . '.' . $extension, base64_decode($base64data))) {
											}
											$count++;
										}
										return true;
									} else {
										error("Error with folders.");
										return false;
									}
								} else {
									error("You have not submitted a photo.");
									return false;
								}
							} else {
								error('invalid photo data.');
								return false;
							}
						} else {
							error("No plant.");
							return false;
						}
					} else {
						sqlError('', 'Upload images: plants');
						return false;
					}
				} else {
					error("No operator.");
					return false;
				}
			} else {
				sqlError('', 'Upload images: operator');
				return false;
			}
			break;

		default:
			error('No such type.');
			return false;
	}
}

function saveRequisition($request_id)
{
	$request_ = dbf(dbq("select * from jobcard_requisitions where request_id={$request_id}"));
	$get_parts = dbq("select * from jobcard_requisition_parts where request_id={$request_id}");
	$jobcard_ = dbf(dbq("select * from jobcards where job_id={$request_['job_id']}"));
	$plant_ = dbf(dbq("select * from plants_tbl where plant_id={$jobcard_['plant_id']}"));
	$mechanic_ = dbf(dbq("select * from users_tbl where user_id={$jobcard_['mechanic_id']}"));

	while ($part = dbf($get_parts)) {
		$parts[] = $part;
	}

	$html = "	<style>
					td {
						padding:3px;
					}					
				</style>
				<table style='border-collapse:collapse;'>
				<tr>
					<td style='border-left: 2px solid black;border-top: 2px solid black; ' colspan='2'><h3>SPARES REQUISITION</h3></td>
					<td style='border-top: 2px solid black;'></td>
					<td style='border-right: 2px solid black;border-top: 2px solid black;'></td>
				</tr>
				<tr>
					<td style='border-left: 2px solid black; width:80px;'><b>Plant #</b></td>
					<td style='width:100px;'>{$plant_['plant_number']}</td>
					<td style='width:300px;'><b>Date:</b>&nbsp;{$request_['datetime']}</td>
					<td style='border-right: 2px solid black; width:200px;'></td>
				</tr>
				<tr>
					<td style='border-left: 2px solid black;'><b>Site</b></td>
					<td>{$jobcard_['site']}</td>
					<td></td>
					<td style='border-right: 2px solid black;'></td>
				</tr>
				<tr>
					<td style='border-left: 2px solid black;'><b>" . strtoupper($plant_['reading_type']) . "</b></td>
					<td>" . $plant_[$plant_['reading_type'] . '_reading'] . "</td>
					<td><b>Job No. {$jobcard_['jobcard_number']}</b></td>
					<td style='border-right: 2px solid black;'><b>BO</b>&nbsp;<span style='color:red; font-weight: bold; font-size:14px;'>{$request_['request_id']}</span></td>
				</tr>
				<tr>
					<td style='border-left: 2px solid black;border-bottom:2px solid black; '>&nbsp;</td>
					<td style='border-bottom:2px solid black;'>&nbsp;</td>
					<td style='border-bottom:2px solid black;'>&nbsp;</td>
					<td style='border-right: 2px solid black;border-bottom:2px solid black;'>&nbsp;</td>
				</tr>
				<tr>
					<td style='border-right: 1px solid black;border-left: 2px solid black;border-bottom:2px solid black;'><b>Qty</b></td>
					<td style='border-bottom:2px solid black;border-right: 1px solid black;'><b>Part Number</b></td>
					<td style='border-bottom:2px solid black;border-right: 1px solid black;'><b>Description</b></td>
					<td style='border-right: 2px solid black;border-bottom:2px solid black;'><b>Component</b></td>
				</tr>";
	$items = 40;
	foreach ($parts as $part) {
		$html .= "<tr>
					<td style='border-right: 1px solid black;border-left: 2px solid black;'>{$part['qty']}</td>
					<td style='border-right: 1px solid black;'>{$part['part_number']}</td>
					<td style='border-right: 1px solid black;'>{$part['part_description']}</td>
					<td style='border-right: 2px solid black;'></td>
				</tr>";
		$items--;
	}

	if ($items > 0) {
		for ($a = 1; $a <= $items; $a++) {
			if ($a == $items) {
				$html .= "<tr>
							<td style='border-right: 1px solid black;border-left: 2px solid black;border-bottom:2px solid black;'>&nbsp;</td>
							<td style='border-bottom:2px solid black;border-right: 1px solid black;'>&nbsp;</td>
							<td style='border-bottom:2px solid black;border-right: 1px solid black;'>&nbsp;</td>
							<td style='border-right: 2px solid black;border-bottom:2px solid black;'>&nbsp;</td>
						</tr>";
			} else {
				$html .= "<tr>
							<td style='border-right: 1px solid black;border-left: 2px solid black;'>&nbsp;</td>
							<td style='border-right: 1px solid black;'>&nbsp;</td>
							<td style='border-right: 1px solid black;'>&nbsp;</td>
							<td style='border-right: 2px solid black;'>&nbsp;</td>
						</tr>";
			}
		}
	}

	$requested_by = dbf(dbq("select name, last_name from users_tbl where user_id={$request_['requested_by']}"));
	if ($request_['approved_by'] > 0) {
		$approved_by = dbf(dbq("select name, last_name from users_tbl where user_id={$request_['approved_by']}"));
	} else {
		$approved_by['name'] = '';
		$approved_by['last_name'] = '';
	}

	$html .= "<tr>
				<td style='text-align:right; border-right: 1px solid black;border-left: 2px solid black;' colspan='2'><b>REQUESTED BY:</b></td>
				<td style='border-right: 1px solid black;'>{$requested_by['name']} {$requested_by['last_name']}, {$request_['requested_by_time']}</td>
				<td style='border-right: 1px solid black;'>BS REQ#</td>
			</tr>
			<tr>
				<td style='text-align:right; border-right: 1px solid black;border-left: 2px solid black;border-bottom:2px solid black;' colspan='2'><b>APPROVED BY:</b></td>
				<td style='border-bottom:2px solid black;border-right: 1px solid black;'>{$approved_by['name']} {$approved_by['last_name']}, , {$request_['approved_by_time']}</td>
				<td style='border-right: 1px solid black;border-bottom:2px solid black;'>PL09 Rev02 190521</td>
			</tr>";

	$html .= "</table>";

	printPDF($html, __DIR__ . "/../files/requisitions/{$request_id}_request", 1, 0, 'P');
}

function check_reading($plant_id, $reading, $thresh_hold = 3)
{
	$get_plant = dbq("select * from plants_tbl where plant_id={$plant_id}");
	if ($get_plant) {
		$plant_ = dbf($get_plant);
		switch ($plant_['reading_type']) {
			case "km":
				if ($plant_['km_reading'] > $reading) {
					error("Your km reading is lower than last reading for this plant.");
					return false;
				} else {
					$diff =  $reading - $plant_['km_reading'];
					if ($diff > $thresh_hold) {
						error("The difference in reading is larger than threshhold.");
						return false;
					}
				}
				return true;
				break;

			case "hr":
				if ($plant_['hr_reading'] > $reading) {
					error("Your km reading is lower than last reading for this plant.");
					return false;
				} else {
					$diff =  $reading - $plant_['hr_reading'];
					if ($diff > $thresh_hold) {
						error("The difference in reading is larger than threshhold.");
						return false;
					}
				}
				break;

			default:
				error("No type km or hr.");
				return false;
		}
	} else {
		sqlError();
		return false;
	}
}

function is_error()
{
	if (isset($_SESSION['error'])) {
		return true;
	} else {
		return false;
	}
}

function is_json($string, $return_data = false)
{
	if (strlen($string) > 0) {
		$data = json_decode($string);
		return (json_last_error() == JSON_ERROR_NONE) ? ($return_data ? $data : TRUE) : FALSE;
	} else {
		return false;
	}
}
