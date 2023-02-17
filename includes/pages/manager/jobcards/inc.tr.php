<div class="row">
    <hr>
    <b>Requisitions</b>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Date Time</th>
                <th>Note</th>
                <th></th>
            </tr>
        </thead>
        <?php
        $get_tyre_reports = dbq("select * from jobcard_tyre_reports where job_id={$row['job_id']}");
        if ($get_tyre_reports) {
            if (dbr($get_tyre_reports) > 0) {
                while ($tyre_report = dbf($get_tyre_reports)) {
        ?>
                    <tr class='pointer' onclick="window.open('print.php?type=tyre-report&id=<?= $tyre_report['id'] ?>','_blank');">
                        <td><?= $tyre_report['date_time'] ?></td>
                        <td><?= $tyre_report['note'] ?></td>
                        <td>
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
    </table>
</div>