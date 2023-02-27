<div class="row">
    <hr>
    <b>Requisitions</b>
    <table class="table table-responsive">
        <thead>
            <tr>
                <th width="100">Date</th>
                <th width="100">Type</th>
                <th width="120">Time Worked</th>
                <th width="459">Comments</th>
                <th width="120">Action</th>
            </tr>
        </thead>
        <?php
        $get_events = dbq("select * from jobcard_events where job_id={$row['job_id']}");
        if ($get_events) {
            if (dbr($get_events) > 0) {
                while ($event = dbf($get_events)) {
        ?><tr>
                        <td><?= date('Y-m-d', strtotime($event['start_datetime'])) ?></td>
                        <td><?= $event['event'] ?></td>
                        <td><?= $event['total_hours'] ?></td>
                        <td><?= $event['comment'] ?></td>
                        <td class="actions">
                            <!--<a class="mb-1 mt-1 mr-1 modal-basic" href="#modalViewEvent_<?= $event['event_id'] ?>"><i class="fas fa-pencil-alt"></i></a>
                                                                    Modal Edit Event End -->
                            <!-- Modal Delete 
                                                                    <a class="mb-1 mt-1 mr-1 modal-basic" href="#modalDeleteEvent_<?= $event['event_id'] ?>"><i class="far fa-trash-alt"></i></a>-->
                            <!-- Modal Delete End -->
                        </td>
                    </tr>
        <?php
                }
            } else {
                echo "<tr><td colspan='4'>No events</td></tr>";
            }
        }

        ?>
    </table>
</div>