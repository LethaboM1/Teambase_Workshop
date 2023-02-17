<section class="card">
    <header class="card-header">
        <h2 class="card-title">Tyre Inspections</h2>
        <?php if ($_SESSION['user']['role'] == 'mechanic') { ?>
            <div class="header-right">
                <a class="mb-1 mt-1 mr-1" href="dashboard.php?page=tyre-action-report&id=<?= $_GET['id'] ?>"><button class="btn btn-primary">Tyre Report</button></a>
            </div>
        <?php } ?>
    </header>
    <div class="card-body">
        <div class="header-right">

        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Date Time</th>
                    <th>Note</th>
                    <th>Checked?</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $get_tyre_reports = dbq("select * from jobcard_tyre_reports where job_id={$_GET['id']}");
                if ($get_tyre_reports) {
                    if (dbr($get_tyre_reports) > 0) {
                        while ($tyre_report = dbf($get_tyre_reports)) {
                            if ($tyre_report['checked_by'] > 0) {
                                $checked_by = dbf(dbq("select name, last_name from users_tbl where user_id={$tyre_report['checked_by']}"));
                                $name = "{$checked_by['name']} {$checked_by['last_name']}, {$tyre_report['checked']}";
                            } else {
                                $name = "No";
                            }
                ?>
                            <tr class='pointer' onclick="window.open('print.php?type=tyre-report&id=<?= $tyre_report['id'] ?>','_blank');">
                                <td><?= $tyre_report['date_time'] ?></td>
                                <td><?= $tyre_report['note'] ?></td>
                                <td><?= $name ?></td>
                                <td><?= (strlen($name) > 0 ? $tyre_report['checked_note'] : "") ?></td>
                                <td style="width:30px">
                                    <i class="fa fa-folder-open"></i>
                                </td>
                            </tr>
                        <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="3">No tyre reports</td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</section>