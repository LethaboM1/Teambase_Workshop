<div class="row">
    <hr>
    <b>Risk Assessments</b>
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
            $get_assessments = dbq("select * from jobcard_risk_assessments where job_id={$row['job_id']}");
            if ($get_assessments) {
                if (dbr($get_assessments) > 0) {
                    while ($assessment = dbf($get_assessments)) {
            ?>
                        <tr class='pointer' onclick="window.open(`print.php?type=risk-assessment&id=<?= $assessment['id'] ?>`,`_blank`)">
                            <td><?= $assessment['date_time'] ?></td>
                            <td><?= $assessment['note'] ?></td>
                            <td>
                                <i class="fa fa-folder-open"></i>
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