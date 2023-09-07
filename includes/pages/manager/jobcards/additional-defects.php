<div class="row">
	<div class="header-right col-lg-4 col-md-4">
		<div class="input-group">
			<input type="text" class="form-control" name="search" id="search" placeholder="Search Job...">
			<button class="btn btn-default" id='searchBtn' type="button"><i class="bx bx-search"></i></button>
			<?php
			$jscript .= "
									
									$('#search').keyup(function (e) {
										if (e.key=='Enter') {
											$('#searchBtn').click();
										}
						
						
										if (e.key=='Backspace') {
											if ($('#search').val().length==0) {
												$('#resetOpenBtn').click();
											}
										}
									});
						
									$('#searchBtn').click(function () {
										$.ajax({
											method:'post',
											url:'includes/ajax.php',
											data: {
												cmd:'search',
												type: 'additional-defect-report',
												search: $('#search').val()
											},
											success:function (result) {
												$('#jobcard_list').html(result);

												setTimeout(function() {
													$.getScript('js/examples/examples.modals.js');
												}, 300);
											},
											error: function (err) {}
										});
									});

									";
			?>

		</div>
	</div>
</div>
<div class="row">
	<div id="jobcard_list" class="col-xl-12">
		<?php

		// $get_jobcards = dbq("select * from jobcards where status='defect-logged'");
		$get_jobcards = dbq("select * from jobcards where status!='logged' and status!='closed' and job_id in (select distinct job_id from jobcard_reports where reviewed=0)");

		if ($get_jobcards) {
			if (dbr($get_jobcards) > 0) {

				$mechanic_select_[] = ['name' => 'Choose Mechanic', 'value' => '0'];
				$get_mechanics = dbq("select concat(name,' ',last_name) as name, user_id as value from users_tbl where role='mechanic' and active=1");
				if ($get_mechanics) {
					if (dbr($get_mechanics) > 0) {
						while ($mechanic = dbf($get_mechanics)) {
							$mechanic_select_[] = $mechanic;
						}
					}
				}

				$clerk_select_[] = ['name' => 'Choose Clerk', 'value' => '0'];
				$get_clerks = dbq("select concat(name,' ',last_name) as name, user_id as value from users_tbl where role='clerk' and active=1");
				if ($get_clerks) {
					if (dbr($get_clerks) > 0) {
						while ($clerk = dbf($get_clerks)) {
							$clerk_select_[] = $clerk;
						}
					}
				}

				while ($jobcard = dbf($get_jobcards)) {
					/* Get Stuff */
					$plant_ = dbf(dbq("select * from plants_tbl where plant_id={$jobcard['plant_id']}"));
					$logged_by_ = dbf(dbq("select concat(name,' ',last_name) as name from users_tbl where user_id={$jobcard['mechanic_id']}"));

					switch ($jobcard['priority']) {
						case "1":
							$status_color = "danger";
							break;

						default:
							$status_color = "warning";
							break;
					}
					require "./includes/pages/manager/jobcards/list_additional_defects.php";
				}
			} else {
				echo "<h4>No new defect reports.</h4>";
			}
		}
		?>
	</div>
	<script>
		function update_hours($id, $value, $job_id) {
			$.ajax({
				method: 'post',
				url: 'includes/ajax.php',
				data: {
					cmd: 'report_hours_ajust',
					id: $id,
					hours: $value,
					job_id: $job_id
				},
				success: function(result) {
					let data = JSON.parse(result);
					if (data.status == 'ok') {
						$("#" + $id + "_update").html(`<i class="fa fa-check text-success"></i>`);
						if (null !== data.hours) {
							$("#jobcard_allocated_hours").html(data.hours);
						}
					} else {
						$("#" + $id + "_update").html(`<i class="fa fa-times text-danger"></i>`);
					}
				}
			});
		}
	</script>
</div>