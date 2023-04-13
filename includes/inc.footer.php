</div>
</section>
<?php
if (isset($modal)) {
	echo $modal;
}
?>
<!-- Vendor -->
<script src="vendor/jquery/jquery.js"></script>
<script src="vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
<script src="vendor/popper/umd/popper.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<!-- <script src="vendor/common/common.js"></script> -->
<script src="vendor/nanoscroller/nanoscroller.js"></script>
<script src="vendor/magnific-popup/jquery.magnific-popup.js"></script>
<script src="vendor/jquery-placeholder/jquery.placeholder.js"></script>
<script src="vendor/jquery.easy-pie-chart/jquery.easypiechart.js"></script>
<script src="vendor/jquery-ui/jquery-ui.js"></script>
<!-- <script src="vendor/jqueryui-touch-punch/jquery.ui.touch-punch.js"></script> -->
<script src="vendor/jquery-appear/jquery.appear.js"></script>
<script src="vendor/jquery-maskedinput/jquery.maskedinput.js"></script>
<script src="vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
<script src="vendor/bootstrapv5-multiselect/js/bootstrap-multiselect.js"></script>
<script src="vendor/flot/jquery.flot.js"></script>
<script src="vendor/flot.tooltip/jquery.flot.tooltip.js"></script>
<script src="vendor/flot/jquery.flot.pie.js"></script>
<script src="vendor/flot/jquery.flot.categories.js"></script>
<script src="vendor/flot/jquery.flot.resize.js"></script>
<!-- <script src="vendor/jquery-sparkline/jquery.sparkline.js"></script> -->
<script src="vendor/raphael/raphael.js"></script>
<script src="vendor/morris/morris.js"></script>
<script src="vendor/gauge/gauge.js"></script>
<script src="vendor/snap.svg/snap.svg.js"></script>
<!-- <script src="vendor/liquid-meter/liquid.meter.js"></script> -->
<script src="vendor/chartist/chartist.js"></script>

<!-- Specific Page Vendor -->
<script src="vendor/select2/js/select2.js"></script>
<script src="vendor/pnotify/pnotify.custom.js"></script>

<!-- Theme Base, Components and Settings -->
<script src="js/theme.js"></script>

<!-- Theme Custom -->
<script src="js/custom.js"></script>

<!-- Theme Initialization Files -->
<script src="js/theme.init.js"></script>

<!-- Examples -->
<script src="js/examples/examples.dashboard.js"></script>
<script src="js/examples/examples.modals.js"></script>
<script src="js/examples/examples.charts.js"></script>
<script>
	function dragElement(elmnt) {
		var pos1 = 0,
			pos2 = 0,
			pos3 = 0,
			pos4 = 0;
		if (document.getElementById(elmnt.id + "header")) {
			// if present, the header is where you move the DIV from:
			document.getElementById(elmnt.id + "header").onmousedown = dragMouseDown;
		} else {
			// otherwise, move the DIV from anywhere inside the DIV:
			elmnt.onmousedown = dragMouseDown;
		}

		function dragMouseDown(e) {
			e = e || window.event;
			e.preventDefault();
			// get the mouse cursor position at startup:
			pos3 = e.clientX;
			pos4 = e.clientY;
			document.onmouseup = closeDragElement;
			// call a function whenever the cursor moves:
			document.onmousemove = elementDrag;
		}

		function elementDrag(e) {
			e = e || window.event;
			e.preventDefault();
			// calculate the new cursor position:
			pos1 = pos3 - e.clientX;
			pos2 = pos4 - e.clientY;
			pos3 = e.clientX;
			pos4 = e.clientY;
			// set the element's new position:
			elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
			elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
		}

		function closeDragElement() {
			// stop moving when mouse button is released:
			document.onmouseup = null;
			document.onmousemove = null;
		}
	}
	<?php
	if (isset($jscript_function)) {
		echo $jscript_function;
	}
	?>
	$(document).ready(function() {
		<?php
		if (isset($jscript)) {
			echo $jscript;
		}

		if (isset($_SESSION['scroll_to'])) {
			$scroll_to = $_SESSION['scroll_to'];
			unset($_SESSION['scroll_to']);
		}

		if (isset($scroll_to)) {
		?>
			$('html, body').animate({
				scrollTop: $("#<?= $scroll_to ?>").offset().top
			}, 1000);
		<?php
		}
		?>
	});
</script>
<!-- Examples -->
<style>
	#ChartistCSSAnimation .ct-series.ct-series-a .ct-line {
		fill: none;
		stroke-width: 4px;
		stroke-dasharray: 5px;
		-webkit-animation: dashoffset 1s linear infinite;
		-moz-animation: dashoffset 1s linear infinite;
		animation: dashoffset 1s linear infinite;
	}

	#ChartistCSSAnimation .ct-series.ct-series-b .ct-point {
		-webkit-animation: bouncing-stroke 0.5s ease infinite;
		-moz-animation: bouncing-stroke 0.5s ease infinite;
		animation: bouncing-stroke 0.5s ease infinite;
	}

	#ChartistCSSAnimation .ct-series.ct-series-b .ct-line {
		fill: none;
		stroke-width: 3px;
	}

	#ChartistCSSAnimation .ct-series.ct-series-c .ct-point {
		-webkit-animation: exploding-stroke 1s ease-out infinite;
		-moz-animation: exploding-stroke 1s ease-out infinite;
		animation: exploding-stroke 1s ease-out infinite;
	}

	#ChartistCSSAnimation .ct-series.ct-series-c .ct-line {
		fill: none;
		stroke-width: 2px;
		stroke-dasharray: 40px 3px;
	}

	@-webkit-keyframes dashoffset {
		0% {
			stroke-dashoffset: 0px;
		}

		100% {
			stroke-dashoffset: -20px;
		}

		;
	}

	@-moz-keyframes dashoffset {
		0% {
			stroke-dashoffset: 0px;
		}

		100% {
			stroke-dashoffset: -20px;
		}

		;
	}

	@keyframes dashoffset {
		0% {
			stroke-dashoffset: 0px;
		}

		100% {
			stroke-dashoffset: -20px;
		}

		;
	}

	@-webkit-keyframes bouncing-stroke {
		0% {
			stroke-width: 5px;
		}

		50% {
			stroke-width: 10px;
		}

		100% {
			stroke-width: 5px;
		}

		;
	}

	@-moz-keyframes bouncing-stroke {
		0% {
			stroke-width: 5px;
		}

		50% {
			stroke-width: 10px;
		}

		100% {
			stroke-width: 5px;
		}

		;
	}

	@keyframes bouncing-stroke {
		0% {
			stroke-width: 5px;
		}

		50% {
			stroke-width: 10px;
		}

		100% {
			stroke-width: 5px;
		}

		;
	}

	@-webkit-keyframes exploding-stroke {
		0% {
			stroke-width: 2px;
			opacity: 1;
		}

		100% {
			stroke-width: 20px;
			opacity: 0;
		}

		;
	}

	@-moz-keyframes exploding-stroke {
		0% {
			stroke-width: 2px;
			opacity: 1;
		}

		100% {
			stroke-width: 20px;
			opacity: 0;
		}

		;
	}

	@keyframes exploding-stroke {
		0% {
			stroke-width: 2px;
			opacity: 1;
		}

		100% {
			stroke-width: 20px;
			opacity: 0;
		}

		;
	}
</style>
</body>

</html>