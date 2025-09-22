<?php

// if ($_POST['outofoffice'] == 'true') {
//     $update = dbq("update users_tbl set out_of_office=1 where user_id={$_SESSION['user']['user_id']}");
//     $_SESSION['user']['out_of_office'] = 1;
//     go('dashboard.php');
// }

// if ($_POST['outofoffice'] == 'false') {
//     $update = dbq("update users_tbl set out_of_office=0 where user_id={$_SESSION['user']['user_id']}");
//     $_SESSION['user']['out_of_office'] = 0;
//     go('dashboard.php');
// }


require_once "includes/check.php";

// --- Handle Out of Office Toggle ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['outofoffice'])) {
    if ($_POST['outofoffice'] === 'true') {
        dbq("UPDATE users_tbl SET out_of_office = 1 WHERE user_id = {$_SESSION['user']['user_id']}");
        $_SESSION['user']['out_of_office'] = 1;
    } else {
        dbq("UPDATE users_tbl SET out_of_office = 0 WHERE user_id = {$_SESSION['user']['user_id']}");
        $_SESSION['user']['out_of_office'] = 0;
    }
    header('Location: dashboard.php');
    exit;
}

// --- DUMMY DATA FOR DASHBOARD ---
$days = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
$totalJobs      = 120;
$totalDefects   = 45;
$totalReqs      = 30;
$totalMechanics = 12;

$jobsData      = [10, 15, 12, 20, 18, 22, 23];
$defectsData   = [2, 3, 1, 4, 2, 5, 3];
$reqsData      = [1, 2, 1, 2, 3, 1, 2];
$mechanicsData = [12, 12, 12, 12, 12, 12, 12];

$outStatus = $_SESSION['user']['out_of_office'] ? 'Out of Office' : 'Available';
$outToggle = $_SESSION['user']['out_of_office'] ? 'false' : 'true';
?>

<?php include "includes/inc.header.php"; ?>
<?php include "includes/navbar.php"; ?>

<style>
/* Dashboard container with sidebar padding */
.dashboard-container {
    margin-left: 250px; 
    padding: 20px 40px;
}

/* Card Styles */
.card-small {
    border-radius: 10px;
    padding: 12px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.card-header {
    font-weight: bold;
    font-size: 0.95rem;
}
.card-body h4 {
    margin:0;
    font-size:1.4rem;
}

/* Permanent card colors */
.card-small.card-total-jobs {
    background-color: #007bff !important;
    color: #fff !important;
}
.card-small.card-total-defects {
    background-color: #dc3545 !important;
    color: #fff !important;
}
.card-small.card-total-reqs {
    background-color: #ffc107 !important;
    color: #000 !important;
}
.card-small.card-total-mechanics {
    background-color: #28a745 !important;
    color: #fff !important;
}

/* Dashboard Rows */
.dashboard-row {
    margin-bottom: 20px;
}

/* Chart container height */
.card-body canvas {
    width: 100% !important;
    height: 280px !important;
}

/* Responsive */
@media (max-width: 992px) {
    .dashboard-container { margin-left: 0; padding: 20px; }
    .card-body canvas { height: 220px !important; }
}
</style>

<section role="main" class="content-body dashboard-container">
    <header class="page-header">
        <h2>Dashboard</h2>
    </header>

    <!-- Out of Office Toggle -->
    <div class="mb-4 text-end">
        <form method="POST">
            <input type="hidden" name="outofoffice" value="<?= $outToggle ?>">
            <button type="submit" class="btn btn-<?= $_SESSION['user']['out_of_office'] ? 'secondary' : 'success' ?>">
                <?= $outStatus ?>
            </button>
        </form>
    </div>

    <!-- Cards Row -->
    <div class="row dashboard-row g-3">
        <div class="col-lg-3 col-md-6">
            <div class="card card-small card-total-jobs text-center">
                <div class="card-header">Total Jobs</div>
                <div class="card-body"><h4><?= $totalJobs ?></h4></div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card card-small card-total-defects text-center">
                <div class="card-header">Total Defects</div>
                <div class="card-body"><h4><?= $totalDefects ?></h4></div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card card-small card-total-reqs text-center">
                <div class="card-header">Requisitions</div>
                <div class="card-body"><h4><?= $totalReqs ?></h4></div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card card-small card-total-mechanics text-center">
                <div class="card-header">Mechanics</div>
                <div class="card-body"><h4><?= $totalMechanics ?></h4></div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row dashboard-row g-3">
        <div class="col-lg-6 col-md-12">
            <div class="card card-small">
                <div class="card-body"><canvas id="jobsDonutChart"></canvas></div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
            <div class="card card-small">
                <div class="card-body"><canvas id="barChart"></canvas></div>
            </div>
        </div>
    </div>

    <!-- Multi-Line Chart -->
    <div class="row dashboard-row g-3">
        <div class="col-12">
            <div class="card card-small">
                <div class="card-body"><canvas id="multiLineChart"></canvas></div>
            </div>
        </div>
    </div>
</section>

<?php include "includes/inc.footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const days = <?= json_encode($days) ?>;
    const jobsData = <?= json_encode($jobsData) ?>;
    const defectsData = <?= json_encode($defectsData) ?>;
    const reqsData = <?= json_encode($reqsData) ?>;
    const mechanicsData = <?= json_encode($mechanicsData) ?>;
    const colors = ['#007bff','#dc3545','#ffc107','#28a745'];

    // Doughnut Chart
    new Chart(document.getElementById('jobsDonutChart'), {
        type: 'doughnut',
        data: {
            labels: ['Completed Jobs', 'Pending Jobs'],
            datasets: [
                { label: 'Jobs', data: [<?= $totalJobs ?>, 50], backgroundColor: [colors[0], '#e0e0e0'], radius: '80%' },
                { label: 'Breakdown', data: [<?= $totalJobs/2 ?>, 25], backgroundColor: [colors[0]+'88', '#cfcfcf'], radius: '60%' }
            ]
        },
        options: { responsive:true, maintainAspectRatio:false, cutout:'40%' }
    });

    // Bar Chart
    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: { labels:days, datasets:[
            { label:'Defects', data:defectsData, backgroundColor:colors[1] },
            { label:'Requisitions', data:reqsData, backgroundColor:colors[2] },
            { label:'Mechanics', data:mechanicsData, backgroundColor:colors[3] }
        ]},
        options:{ responsive:true, maintainAspectRatio:false, scales:{ y:{ beginAtZero:true } } }
    });

    // Multi-Line Chart
    new Chart(document.getElementById('multiLineChart'), {
        type:'line',
        data:{ labels:days, datasets:[
            { label:'Jobs', data: jobsData, borderColor:colors[0], tension:0.3, fill:false },
            { label:'Defects', data: defectsData, borderColor:colors[1], tension:0.3, fill:false },
            { label:'Requisitions', data: reqsData, borderColor:colors[2], tension:0.3, fill:false },
            { label:'Mechanics', data: mechanicsData, borderColor:colors[3], tension:0.3, fill:false }
        ]},
        options:{ responsive:true, maintainAspectRatio:false }
    });
});
</script>
