<?php

if (isset($_POST['add_event'])) {
    if (strlen($_POST['comment']) > 0) {
        if ($_POST['event'] != '0') {
            $total_hours = calc_hours($_POST['start_date'], $_POST['end_date']);
            if (date_create($_POST['start_date']) && date_create($_POST['end_date'])) {
                $add_event = dbq("insert into jobcard_events set
                                            job_id={$_GET['id']},
                                            start_datetime='{$_POST['start_date']}',
                                            end_datetime='{$_POST['end_date']}',
                                            total_hours={$total_hours},
                                            event='{$_POST['event']}',
                                            comment='" . htmlentities($_POST['comment'], ENT_QUOTES) . "'
                                            ");
                if ($add_event) {
                    msg("Event added.");
                } else {
                    sqlError('', '');
                }
            } else {
                error('Invalid date/time');
            }
        } else {
            error("You must allocate an event type.");
        }
    } else {
        error("fill in a comment.");
    }
}
