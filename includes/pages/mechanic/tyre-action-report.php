<div class="row">
	<div class="col-xl-12">
		<section class="card">
			<header class="card-header">
				<h2 class="card-title">Tyre Action Report</h2>
			</header>
			<div class="card-body">
				<form method="post">
					<div class="row">
						<div class="col-md-6">
							<?= inp('note', 'Notes', 'textarea', $_POST['note'], 'm-2') ?>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div style="border: 1px solid white; border-radius: 3px;" class="p-1 m-1">
								<div class="row m-1">
									<div class="col-lg-1">
										<h3>#1</h3>
									</div>
									<div class="col-lg-3"><?= inp('1_size', 'Size', 'text') ?></div>
									<div class="col-lg-3"><?= inp('1_make', 'Make', 'text') ?></div>
									<div class="col-lg-2"><?= inp('1_tread', '(mm)', 'number', '', '', 0, '', 'step="0.5"') ?></div>
									<div class="col-lg-3"><?= inp('1_pressure', 'Pressure', 'text') ?></div>
								</div>
								<div class="row">
									<div class="col-lg-3"><?= inp('1_valve_cap', 'Valve cap?', 'checkbox', 'yes', 'mt-4') ?></div>
									<div class="col-lg-3"><?= inp('1_valve_extension', 'Valve extension?', 'checkbox', 'yes', 'mt-4 pl-4') ?></div>
									<div class="col-lg-3"><?= inp('1_tyre_type', 'Virgin?', 'radio', 'virgin', 'mt-4') ?></div>
									<div class="col-lg-3"><?= inp('1_tyre_type', 'Retread?', 'radio', 'retread', 'mt-4') ?></div>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div style="border: 1px solid white; border-radius: 3px;" class="p-1 m-1">
								<div class="row m-1">
									<div class="col-lg-1">
										<h3>#2</h3>
									</div>
									<div class="col-lg-3"><?= inp('2_size', 'Size', 'text') ?></div>
									<div class="col-lg-3"><?= inp('2_make', 'Make', 'text') ?></div>
									<div class="col-lg-2"><?= inp('2_tread', '(mm)', 'number', '', '', 0, '', 'step="0.5"') ?></div>
									<div class="col-lg-3"><?= inp('2_pressure', 'Pressure', 'text') ?></div>
								</div>
								<div class="row">
									<div class="col-lg-3"><?= inp('2_valve_cap', 'Valve cap?', 'checkbox', 'yes', 'mt-4') ?></div>
									<div class="col-lg-3"><?= inp('2_valve_extension', 'Valve extension?', 'checkbox', 'yes', 'mt-4') ?></div>
									<div class="col-lg-3"><?= inp('2_tyre_type', 'Virgin?', 'radio', 'virgin', 'mt-4') ?></div>
									<div class="col-lg-3"><?= inp('2_tyre_type', 'Retread?', 'radio', 'retread', 'mt-4') ?></div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div style="border: 1px solid white; border-radius: 3px;" class="p-1 m-1">
								<div class="row m-1">
									<div class="col-lg-1">
										<h3>#3</h3>
									</div>
									<div class="col-lg-3"><?= inp('3_size', 'Size', 'text') ?></div>
									<div class="col-lg-3"><?= inp('3_make', 'Make', 'text') ?></div>
									<div class="col-lg-2"><?= inp('3_tread', '(mm)', 'number', '', '', 0, '', 'step="0.5"') ?></div>
									<div class="col-lg-3"><?= inp('3_pressure', 'Pressure', 'text') ?></div>
								</div>
								<div class="row">
									<div class="col-lg-3"><?= inp('3_valve_cap', 'Valve cap?', 'checkbox', 'yes', 'mt-4') ?></div>
									<div class="col-lg-3"><?= inp('3_valve_extension', 'Valve extension?', 'checkbox', 'yes', 'mt-4') ?></div>
									<div class="col-lg-3"><?= inp('3_tyre_type', 'Virgin?', 'radio', 'virgin', 'mt-4') ?></div>
									<div class="col-lg-3"><?= inp('3_tyre_type', 'Retread?', 'radio', 'retread', 'mt-4') ?></div>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div style="border: 1px solid white; border-radius: 3px;" class="p-1 m-1">
								<div class="row m-1">
									<div class="col-lg-1">
										<h3>#4</h3>
									</div>
									<div class="col-lg-3"><?= inp('4_size', 'Size', 'text') ?></div>
									<div class="col-lg-3"><?= inp('4_make', 'Make', 'text') ?></div>
									<div class="col-lg-2"><?= inp('4_tread', '(mm)', 'number', '', '', 0, '', 'step="0.5"') ?></div>
									<div class="col-lg-3"><?= inp('4_pressure', 'Pressure', 'text') ?></div>
								</div>
								<div class="row">
									<div class="col-lg-3"><?= inp('4_valve_cap', 'Valve cap?', 'checkbox', 'yes', 'mt-4') ?></div>
									<div class="col-lg-3"><?= inp('4_valve_extension', 'Valve extension?', 'checkbox', 'yes', 'mt-4') ?></div>
									<div class="col-lg-3"><?= inp('4_tyre_type', 'Virgin?', 'radio', 'virgin', 'mt-4') ?></div>
									<div class="col-lg-3"><?= inp('4_tyre_type', 'Retread?', 'radio', 'retread', 'mt-4') ?></div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div style="border: 1px solid white; border-radius: 3px;" class="p-1 m-1">
								<div class="row m-1">
									<div class="col-lg-1">
										<h3>#5</h3>
									</div>
									<div class="col-lg-3"><?= inp('5_size', 'Size', 'text') ?></div>
									<div class="col-lg-3"><?= inp('5_make', 'Make', 'text') ?></div>
									<div class="col-lg-2"><?= inp('5_tread', '(mm)', 'number', '', '', 0, '', 'step="0.5"') ?></div>
									<div class="col-lg-3"><?= inp('5_pressure', 'Pressure', 'text') ?></div>
								</div>
								<div class="row">
									<div class="col-lg-3"><?= inp('5_valve_cap', 'Valve cap?', 'checkbox', 'yes', 'mt-4') ?></div>
									<div class="col-lg-3"><?= inp('5_valve_extension', 'Valve extension?', 'checkbox', 'yes', 'mt-4') ?></div>
									<div class="col-lg-3"><?= inp('5_tyre_type', 'Virgin?', 'radio', 'virgin', 'mt-4') ?></div>
									<div class="col-lg-3"><?= inp('5_tyre_type', 'Retread?', 'radio', 'retread', 'mt-4') ?></div>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div style="border: 1px solid white; border-radius: 3px;" class="p-1 m-1">
								<div class="row m-1">
									<div class="col-lg-1">
										<h3>#6</h3>
									</div>
									<div class="col-lg-3"><?= inp('6_size', 'Size', 'text') ?></div>
									<div class="col-lg-3"><?= inp('6_make', 'Make', 'text') ?></div>
									<div class="col-lg-2"><?= inp('6_tread', '(mm)', 'number', '', '', 0, '', 'step="0.5"') ?></div>
									<div class="col-lg-3"><?= inp('6_pressure', 'Pressure', 'text') ?></div>
								</div>
								<div class="row">
									<div class="col-lg-3"><?= inp('6_valve_cap', 'Valve cap?', 'checkbox', 'yes', 'mt-4') ?></div>
									<div class="col-lg-3"><?= inp('6_valve_extension', 'Valve extension?', 'checkbox', 'yes', 'mt-4') ?></div>
									<div class="col-lg-3"><?= inp('6_tyre_type', 'Virgin?', 'radio', 'virgin', 'mt-4') ?></div>
									<div class="col-lg-3"><?= inp('6_tyre_type', 'Retread?', 'radio', 'retread', 'mt-4') ?></div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div style="border: 1px solid white; border-radius: 3px;" class="p-1 m-1">
								<div class="row m-1">
									<div class="col-lg-1">
										<h3>#7</h3>
									</div>
									<div class="col-lg-3"><?= inp('7_size', 'Size', 'text') ?></div>
									<div class="col-lg-3"><?= inp('7_make', 'Make', 'text') ?></div>
									<div class="col-lg-2"><?= inp('7_tread', '(mm)', 'number', '', '', 0, '', 'step="0.5"') ?></div>
									<div class="col-lg-3"><?= inp('7_pressure', 'Pressure', 'text') ?></div>
								</div>
								<div class="row">
									<div class="col-lg-3"><?= inp('7_valve_cap', 'Valve cap?', 'checkbox', 'yes', 'mt-4') ?></div>
									<div class="col-lg-3"><?= inp('7_valve_extension', 'Valve extension?', 'checkbox', 'yes', 'mt-4') ?></div>
									<div class="col-lg-3"><?= inp('7_tyre_type', 'Virgin?', 'radio', 'virgin', 'mt-4') ?></div>
									<div class="col-lg-3"><?= inp('7_tyre_type', 'Retread?', 'radio', 'retread', 'mt-4') ?></div>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div style="border: 1px solid white; border-radius: 3px;" class="p-1 m-1">
								<div class="row m-1">
									<div class="col-lg-1">
										<h3>#8</h3>
									</div>
									<div class="col-lg-3"><?= inp('8_size', 'Size', 'text') ?></div>
									<div class="col-lg-3"><?= inp('8_make', 'Make', 'text') ?></div>
									<div class="col-lg-2"><?= inp('8_tread', '(mm)', 'number', '', '', 0, '', 'step="0.5"') ?></div>
									<div class="col-lg-3"><?= inp('8_pressure', 'Pressure', 'text') ?></div>
								</div>
								<div class="row">
									<div class="col-lg-3"><?= inp('8_valve_cap', 'Valve cap?', 'checkbox', 'yes', 'mt-4') ?></div>
									<div class="col-lg-3"><?= inp('8_valve_extension', 'Valve extension?', 'checkbox', 'yes', 'mt-4') ?></div>
									<div class="col-lg-3"><?= inp('8_tyre_type', 'Virgin?', 'radio', 'virgin', 'mt-4') ?></div>
									<div class="col-lg-3"><?= inp('8_tyre_type', 'Retread?', 'radio', 'retread', 'mt-4') ?></div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div style="border: 1px solid white; border-radius: 3px;" class="p-1 m-1">
								<div class="row m-1">
									<div class="col-lg-1">
										<h3>#1</h3>
									</div>
									<div class="col-lg-3"><?= inp('9_size', 'Size', 'text') ?></div>
									<div class="col-lg-3"><?= inp('9_make', 'Make', 'text') ?></div>
									<div class="col-lg-2"><?= inp('9_tread', '(mm)', 'number', '', '', 0, '', 'step="0.5"') ?></div>
									<div class="col-lg-3"><?= inp('9_pressure', 'Pressure', 'text') ?></div>
								</div>
								<div class="row">
									<div class="col-lg-3"><?= inp('9_valve_cap', 'Valve cap?', 'checkbox', 'yes', 'mt-4') ?></div>
									<div class="col-lg-3"><?= inp('9_valve_extension', 'Valve extension?', 'checkbox', 'yes', 'mt-4') ?></div>
									<div class="col-lg-3"><?= inp('9_tyre_type', 'Virgin?', 'radio', 'virgin', 'mt-4') ?></div>
									<div class="col-lg-3"><?= inp('9_tyre_type', 'Retread?', 'radio', 'retread', 'mt-4') ?></div>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div style="border: 1px solid white; border-radius: 3px;" class="p-1 m-1">
								<div class="row m-1">
									<div class="col-lg-1">
										<h3>#10</h3>
									</div>
									<div class="col-lg-3"><?= inp('10_size', 'Size', 'text') ?></div>
									<div class="col-lg-3"><?= inp('10_make', 'Make', 'text') ?></div>
									<div class="col-lg-2"><?= inp('10_tread', '(mm)', 'number', '', '', 0, '', 'step="0.5"') ?></div>
									<div class="col-lg-3"><?= inp('10_pressure', 'Pressure', 'text') ?></div>
								</div>
								<div class="row">
									<div class="col-lg-3"><?= inp('10_valve_cap', 'Valve cap?', 'checkbox', 'yes', 'mt-4') ?></div>
									<div class="col-lg-3"><?= inp('10_valve_extension', 'Valve extension?', 'checkbox', 'yes', 'mt-4') ?></div>
									<div class="col-lg-3"><?= inp('10_tyre_type', 'Virgin?', 'radio', 'virgin', 'mt-4') ?></div>
									<div class="col-lg-3"><?= inp('10_tyre_type', 'Retread?', 'radio', 'retread', 'mt-4') ?></div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div style="border: 1px solid white; border-radius: 3px;" class="p-1 m-1">
								<div class="row m-1">
									<div class="col-lg-1">
										<h3>#11</h3>
									</div>
									<div class="col-lg-3"><?= inp('11_size', 'Size', 'text') ?></div>
									<div class="col-lg-3"><?= inp('11_make', 'Make', 'text') ?></div>
									<div class="col-lg-2"><?= inp('11_tread', '(mm)', 'number', '', '', 0, '', 'step="0.5"') ?></div>
									<div class="col-lg-3"><?= inp('11_pressure', 'Pressure', 'text') ?></div>
								</div>
								<div class="row">
									<div class="col-lg-3"><?= inp('11_valve_cap', 'Valve cap?', 'checkbox', 'yes', 'mt-4') ?></div>
									<div class="col-lg-3"><?= inp('11_valve_extension', 'Valve extension?', 'checkbox', 'yes', 'mt-4') ?></div>
									<div class="col-lg-3"><?= inp('11_tyre_type', 'Virgin?', 'radio', 'virgin', 'mt-4') ?></div>
									<div class="col-lg-3"><?= inp('11_tyre_type', 'Retread?', 'radio', 'retread', 'mt-4') ?></div>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div style="border: 1px solid white; border-radius: 3px;" class="p-1 m-1">
								<div class="row m-1">
									<div class="col-lg-1">
										<h3>#12</h3>
									</div>
									<div class="col-lg-3"><?= inp('12_size', 'Size', 'text') ?></div>
									<div class="col-lg-3"><?= inp('12_make', 'Make', 'text') ?></div>
									<div class="col-lg-2"><?= inp('12_tread', '(mm)', 'number', '', '', 0, '', 'step="0.5"') ?></div>
									<div class="col-lg-3"><?= inp('12_pressure', 'Pressure', 'text') ?></div>
								</div>
								<div class="row">
									<div class="col-lg-3"><?= inp('12_valve_cap', 'Valve cap?', 'checkbox', 'yes', 'mt-4') ?></div>
									<div class="col-lg-3"><?= inp('12_valve_extension', 'Valve extension?', 'checkbox', 'yes', 'mt-4') ?></div>
									<div class="col-lg-3"><?= inp('12_tyre_type', 'Virgin?', 'radio', 'virgin', 'mt-4') ?></div>
									<div class="col-lg-3"><?= inp('12_tyre_type', 'Retread?', 'radio', 'retread', 'mt-4') ?></div>
								</div>
							</div>
						</div>
					</div>
					<button type="submit" name="add_tyre_report" class="btn btn-primary">Add Tyre Action Report</button>
					<button type="submit" name="cancel" class="btn btn-default">Cancel</button>
				</form>
				<div class="row">
					<div class="popup-gallery row">
						<div class="img-fluid col-lg-3 col-md-6 pb-sm-12">
							<img class="mt-2" src="img/1.jpg" width="250" usemap="#Map">
							<map name="Map">
								<area shape="rect" coords="53,42,91,71" href="#">
								<area shape="rect" coords="163,40,201,72" href="#">
								<area shape="rect" coords="18,142,51,168" href="#">
								<area shape="rect" coords="55,143,89,168" href="#">
								<area shape="rect" coords="165,142,201,167" href="#">
								<area shape="rect" coords="206,144,240,167" href="#">
								<area shape="rect" coords="18,172,51,194" href="#">
								<area shape="rect" coords="57,172,89,195" href="#">
								<area shape="rect" coords="164,172,200,193" href="#">
								<area shape="rect" coords="204,173,238,194" href="#">
								<area shape="rect" coords="58,210,198,233" href="#">
							</map>
						</div>
						<div class="img-fluid col-lg-3 col-md-6 pb-sm-12">
							<img class="mt-2" src="img/2.jpg" width="250" usemap="#Map2">
							<map name="Map2">
								<area shape="rect" coords="8,164,46,189" href="#">
								<area shape="rect" coords="52,166,87,188" href="#">
								<area shape="rect" coords="162,162,197,189" href="#">
								<area shape="rect" coords="206,164,239,190" href="#">
								<area shape="rect" coords="66,207,187,232" href="#">
							</map>
						</div>
						<div class="img-fluid col-lg-3 col-md-6 pb-sm-12">
							<img class="mt-2" src="img/3.jpg" width="250" usemap="#Map3">
							<map name="Map3">
								<area shape="rect" coords="9,133,43,159" href="#">
								<area shape="rect" coords="55,133,80,160" href="#">
								<area shape="rect" coords="164,134,193,158" href="#">
								<area shape="rect" coords="210,135,238,162" href="#">
								<area shape="rect" coords="15,163,41,189" href="#">
								<area shape="rect" coords="55,166,87,187" href="#">
								<area shape="rect" coords="166,163,201,186" href="#">
								<area shape="rect" coords="211,166,239,186" href="#">
								<area shape="rect" coords="63,206,178,237" href="#">
							</map>
						</div>
						<div class="img-fluid col-lg-3 col-md-6 pb-sm-12">
							<img class="mt-2" src="img/4.jpg" width="250" usemap="#Map4">
							<map name="Map4">
								<area shape="rect" coords="12,100,42,125" href="#">
								<area shape="rect" coords="61,100,79,126" href="#">
								<area shape="rect" coords="163,99,195,126" href="#">
								<area shape="rect" coords="206,101,243,123" href="#">
								<area shape="rect" coords="10,131,41,155" href="#">
								<area shape="rect" coords="57,131,84,153" href="#">
								<area shape="rect" coords="162,128,199,156" href="#">
								<area shape="rect" coords="207,129,241,152" href="#">
								<area shape="rect" coords="9,158,42,183" href="#">
								<area shape="rect" coords="52,160,87,184" href="#">
								<area shape="rect" coords="163,159,198,184" href="#">
								<area shape="rect" coords="208,161,240,185" href="#">
								<area shape="rect" coords="67,205,182,227" href="#">
							</map>
						</div>
						<div class="img-fluid col-lg-3 col-md-6 pb-sm-12">
							<img class="mt-2" src="img/5.jpg" width="250" usemap="#Map5">
							<map name="Map5">
								<area shape="rect" coords="57,39,85,63" href="#">
								<area shape="rect" coords="160,39,198,67" href="#">
								<area shape="rect" coords="54,109,89,145" href="#">
								<area shape="rect" coords="157,111,193,143" href="#">
								<area shape="rect" coords="60,207,190,236" href="#">
							</map>
						</div>
					</div>
				</div>
			</div>
		</section>

	</div>
</div>