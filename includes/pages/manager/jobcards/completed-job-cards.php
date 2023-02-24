<div class="row">
	<div class="header-right col-lg-4 col-md-4">

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
												type: 'completed-jobs',
												search: $('#search').val()
											},
											success:function (result) {
												$('#completed_jobs_list').html(result);
											},
											error: function (err) {}
										});
									});

									";
			?>

		</div>

	</div>
	<div id="completed_jobs_list" class="col-xl-12">
		<?php
		if ($_SESSION['user']['role'] == 'clerk') {
			$get_jobs = dbq("select * from jobcards where status='completed' and clerk_id={$_SESSION['user']['user_id']} order by complete_datetime");
		} else {
			$get_jobs = dbq("select * from jobcards where status='completed' order by complete_datetime");
		}
		if ($get_jobs) {
			if (dbr($get_jobs) > 0) {
				while ($row = dbf($get_jobs)) {
					require "./includes/pages/manager/jobcards/list_completed_jobcards.php";
				}
			} else {
				echo "<h4>No completed job cards.</h4>";
			}
		}

		$jscript_function .= "
							function print_request (request_id) {
								$.ajax({
									method:'get',
									url:'includes/ajax.php',
									data: {
										cmd:'print_request',
										id: request_id
									},
									success: function (result) {
										let data = JSON.parse(result);
										if (data.status=='ok') {
											window.open(data.path,`_blank`);
										} else if (data.status=='error') {
											console.log(`Error: `. data.message);
										} else {																						
											console.log(`Error: API error`);
										}
									}	
								});
							}
							";
		?>
	</div>
</div>