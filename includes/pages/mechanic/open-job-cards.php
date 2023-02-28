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
												type: 'open-jobs',
												search: $('#search').val()
											},
											success:function (result) {
												$('#open_jobs_list').html(result);

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
	<div id="open_jobs_list" class="col-xl-12">
		<?php
		$get_jobs = dbq("select * from jobcards where (status='open' || status='busy') and mechanic_id={$_SESSION['user']['user_id']} order by priority");
		if ($get_jobs) {
			if (dbr($get_jobs) > 0) {
				while ($row = dbf($get_jobs)) {
					require "./includes/pages/mechanic/list_open_jobcards.php";
				}
			} else {
				echo "<h4>No open job cards.</h4>";
			}
		}
		?>
	</div>
</div>