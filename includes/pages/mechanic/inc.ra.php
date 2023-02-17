<section class="card">
    <header class="card-header">
        <h2 class="card-title">Risk Assessments</h2>
    </header>
    <div class="card-body">
        <?php if ($_SESSION['user']['role'] == 'mechanic') { ?>
            <div class="header-right">
                <a class="mb-1 mt-1 mr-1" href="dashboard.php?page=daily-pre-task-mini&id=<?= $_GET['id'] ?>"><button class="btn btn-primary">Risk Assessment</button></a>
            </div>
        <?php } ?>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Date Time</th>
                    <th>Note</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $get_assessments = dbq("select * from jobcard_risk_assessments where job_id={$_GET['id']}");
                if ($get_assessments) {
                    if (dbr($get_assessments) > 0) {
                        while ($assessment = dbf($get_assessments)) {
                ?>
                            <tr class='pointer'>
                                <td onclick="window.open('print.php?type=risk-assessment&id=<?= $assessment['id'] ?>','_blank');"><?= $assessment['date_time'] ?></td>
                                <td onclick="window.open('print.php?type=risk-assessment&id=<?= $assessment['id'] ?>','_blank');"><?= $assessment['note'] ?></td>
                                <td style="width:60px">
                                    <a onclick="window.open('dashboard.php?page=daily-pre-task-mini-view&id=<?= $assessment['id'] ?>&jobid=<?= $_GET['id'] ?>','_self');"><i class="fa fa-folder-open"></i></a>
                                    &nbsp<a onclick="window.open('print.php?type=risk-assessment&id=<?= $assessment['id'] ?>','_blank');"><i class="fa fa-print"></i></a>
                                </td>
                            </tr>
                        <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="3">No assessments</td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</section>