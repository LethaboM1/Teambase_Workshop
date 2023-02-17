<div class="row">
    <hr>
    <b>Requisitions</b>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Date/Time</th>
                <th>Request ID.</th>
                <th>Status</th>
                <th>Status:Comment</th>
                <th></th>
            </tr>
        </thead>
        <?php
        $get_jobcard_requesitions = dbq("select * from jobcard_requisitions where job_id={$row['job_id']}");
        if ($get_jobcard_requesitions) {
            if (dbr($get_jobcard_requesitions) > 0) {
                while ($requisition = dbf($get_jobcard_requesitions)) {
                    if ($requisition['status'] != 'requested') {
                        $comment_ = $requisition[$requisition['status'] . '_by_comment'];
                    } else {
                        $comment_ = '';
                    }
                    echo "<tr class='pointer' onclick='print_request(`{$requisition['request_id']}`)'>
                                                                            <td>{$requisition['datetime']}</td>
                                                                            <td>{$requisition['request_id']}</td>
                                                                            <td>{$requisition['comment']}</td>
                                                                            <td>" . ucfirst($requisition['status']) . "</td>
                                                                            <td>{$comment_}</td>
                                                                            <td>
                                                                                <i class='fa fa-folder-open'></i>
                                                                            </td>
                                                                        </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No Requisitions</td></tr>";
            }
        }

        ?>
    </table>
</div>