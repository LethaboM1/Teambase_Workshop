<div class="row">
	<div class="header-right col-lg-4 col-md-4">
		<form action="#" class="search nav-form">
			<div class="input-group">
				<input type="text" class="form-control" name="search" id="search" placeholder="Search Plant...">
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
												type: 'open-jobs',
												search: $('#search').val()
											},
											success:function (result) {
												$('#open_jobs_list').html(result);
											},
											error: function (err) {}
										});
									});

									";
				?>

			</div>
		</form>
	</div>
	<div id="open_jobs_list" class="col-xl-12">
		<?php
		if ($_SESSION['user']['role'] == 'clerk') {
			$get_jobs = dbq("select * from jobcards where (status='open' || status='busy') and clerk_id={$_SESSION['user']['user_id']} order by priority");
		} else {
			$get_jobs = dbq("select * from jobcards where (status='open' || status='busy') order by priority");
		}

		if ($get_jobs) {
			if (dbr($get_jobs) > 0) {
				while ($row = dbf($get_jobs)) {
					$get_last_event = dbq("select * from jobcard_events where job_id={$row['job_id']} order by start_datetime DESC limit 1");
					if (dbr($get_last_event) > 0) {
						$chk_event = dbf($get_last_event);
					} else {
						$chk_event['start_datetime'] = '';
					}

					$row['last_evt_date'] = $chk_event['start_datetime'];
					if (strlen($row['last_evt_date']) > 0) $row['last_evt_date'] = date('Y-m-d', strtotime($row['last_evt_date']));
					$jobcards_list[] = $row;
					//require "./includes/pages/manager/jobcards/list_open_jobcards.php";
				}
			}

			if (is_array($jobcards_list) && count($jobcards_list) > 0) {
				function cmp($a, $b)
				{
					return strcmp($b["last_evt_date"], $a["last_evt_date"]);
				}
				usort($jobcards_list, 'cmp');
				foreach ($jobcards_list as $row) {
					require "./includes/pages/manager/jobcards/list_open_jobcards.php";
				}
			} else {
				echo "<h4>No open job cards.</h4>";
			}
		}
		?>
	</div>
</div>