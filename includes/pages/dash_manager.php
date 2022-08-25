<?php
if ($_SESSION['user']['role'] != 'system' && $_SESSION['user']['role'] != 'manager') {
	exit();
}
?>
<!doctype html>
<div class="row">
	<div class="col-lg-6 mb-3">
		<section class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-xl-12">
						<div class="chart-data-selector" id="salesSelectorWrapper">
							<h2>
								Service:
								<strong>
									<select class="form-control" id="salesSelector">
										<option value="Break Downs" selected>Break Downs</option>
										<option value="Repairs">Repairs</option>
										<option value="Write offs">Write offs</option>
									</select>
								</strong>
							</h2>

							<div id="salesSelectorItems" class="chart-data-selector-items mt-3">
								<!-- Flot: Break Downs -->
								<div class="chart chart-sm" data-sales-rel="Break Downs" id="flotDashSales1" class="chart-active" style="height: 203px;"></div>
								<script>
									var flotDashSales1Data = [{
										data: [
											["Jan", 140],
											["Feb", 240],
											["Mar", 190],
											["Apr", 140],
											["May", 180],
											["Jun", 320],
											["Jul", 270],
											["Aug", 180]
										],
										color: "#f3b426"
									}];

									// See: js/examples/examples.dashboard.js for more settings.
								</script>

								<!-- Flot: Repairs -->
								<div class="chart chart-sm" data-sales-rel="Repairs" id="flotDashSales2" class="chart-hidden"></div>
								<script>
									var flotDashSales2Data = [{
										data: [
											["Jan", 240],
											["Feb", 240],
											["Mar", 290],
											["Apr", 540],
											["May", 480],
											["Jun", 220],
											["Jul", 170],
											["Aug", 190]
										],
										color: "#2baab1"
									}];

									// See: js/examples/examples.dashboard.js for more settings.
								</script>

								<!-- Flot: Sales Write offs -->
								<div class="chart chart-sm" data-sales-rel="Write offs" id="flotDashSales3" class="chart-hidden"></div>
								<script>
									var flotDashSales3Data = [{
										data: [
											["Jan", 840],
											["Feb", 740],
											["Mar", 690],
											["Apr", 940],
											["May", 1180],
											["Jun", 820],
											["Jul", 570],
											["Aug", 780]
										],
										color: "#734ba9"
									}];

									// See: js/examples/examples.dashboard.js for more settings.
								</script>
							</div>

						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
	<div class="col-lg-6">
		<div class="row mb-3">
			<div class="col-xl-6">
				<section class="card card-featured-left card-featured-primary mb-3">
					<div class="card-body">
						<div class="widget-summary">
							<div class="widget-summary-col widget-summary-col-icon">
								<div class="summary-icon bg-primary">
									<i class="fas fa-hammer"></i>
								</div>
							</div>
							<div class="widget-summary-col">
								<div class="summary">
									<h4 class="title">Non Critical Brake Downs</h4>
									<div class="info">
										<strong class="amount">1281</strong>
										<span class="text-primary">(14 unread)</span>
									</div>
								</div>
								<div class="summary-footer">
									<a class="text-muted text-uppercase" href="#">(view all)</a>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
			<div class="col-xl-6">
				<section class="card card-featured-left card-featured-secondary">
					<div class="card-body">
						<div class="widget-summary">
							<div class="widget-summary-col widget-summary-col-icon">
								<div class="summary-icon bg-secondary">
									<i class="fas fa-hammer"></i>
								</div>
							</div>
							<div class="widget-summary-col">
								<div class="summary">
									<h4 class="title">Critical Brake Downs</h4>
									<div class="info">
										<strong class="amount">150</strong>
									</div>
								</div>
								<div class="summary-footer">
									<a class="text-muted text-uppercase" href="#">(view all)</a>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
		<div class="row">
			<div class="col-xl-6">
				<section class="card card-featured-left card-featured-tertiary mb-3">
					<div class="card-body">
						<div class="widget-summary">
							<div class="widget-summary-col widget-summary-col-icon">
								<div class="summary-icon bg-tertiary">
									<i class="fas fa-file"></i>
								</div>
							</div>
							<div class="widget-summary-col">
								<div class="summary">
									<h4 class="title">Open Job Cards</h4>
									<div class="info">
										<strong class="amount">38</strong>
									</div>
								</div>
								<div class="summary-footer">
									<a class="text-muted text-uppercase" href="#">(view all)</a>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
			<div class="col-xl-6">
				<section class="card card-featured-left card-featured-quaternary">
					<div class="card-body">
						<div class="widget-summary">
							<div class="widget-summary-col widget-summary-col-icon">
								<div class="summary-icon bg-quaternary">
									<i class="fas fa-box-archive"></i>
								</div>
							</div>
							<div class="widget-summary-col">
								<div class="summary">
									<h4 class="title">History</h4>
									<div class="info">
										<strong class="amount">3765</strong>
									</div>
								</div>
								<div class="summary-footer">
									<a class="text-muted text-uppercase" href="#">(report)</a>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-6">
		<section class="card">
			<header class="card-header">
				<h2 class="card-title">Pie Chart</h2>
				<p class="card-subtitle">Default Pie Chart</p>
			</header>
			<div class="card-body">

				<!-- Flot: Pie -->
				<div class="chart chart-md" id="flotPie"></div>
				<script type="text/javascript">
					var flotPieData = [{
						label: "Series 1",
						data: [
							[1, 60]
						],
						color: '#0088cc'
					}, {
						label: "Series 2",
						data: [
							[1, 10]
						],
						color: '#2baab1'
					}, {
						label: "Series 3",
						data: [
							[1, 15]
						],
						color: '#734ba9'
					}, {
						label: "Series 4",
						data: [
							[1, 15]
						],
						color: '#E36159'
					}];

					// See: js/examples/examples.charts.js for more settings.
				</script>

			</div>
		</section>
	</div>
</div>

</div>