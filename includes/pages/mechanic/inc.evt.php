<!-- Modal add event -->
<div id="modalAddEvent" class="modal-block modal-block-lg mfp-hide">
    <form method="post">
        <section class="card">
            <header class="card-header">
                <h2 class="card-title">Add Event</h2>
            </header>
            <div class="card-body">
                <h2 class="card-title">Events</h2><br>
                <div class="row">
                    <div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
                        <label class="col-form-label" for="formGroupExampleInput">Event Date</label>
                        <input type="date" name="event_date" class="form-control" value="<?= date('Y-m-d') ?>">
                    </div>
                    <div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
                        <label class="col-form-label" for="formGroupExampleInput">Hours Worked</label>
                        <input type="number" name="total_hours" step="0.5" class="form-control" value="1">
                    </div>
                    <div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">
                        <label class="col-form-label" for="formGroupExampleInput">Select Event</label>
                        <select class="form-control mb-3" name="event" id="event">
                            <option value="">Select Component</option>
                            <option value="Engine">Engine</option>
                            <option value="Clutch">Clutch</option>
                            <option value="Gearbox/Drive Train">Gearbox/Drive Train/Gear Selection</option>
                            <option value="Axel + Suspension Rear">Axel + Suspension Rear</option>
                            <option value="Axel + Suspension Front">Axel + Suspension Front</option>
                            <option value="Brakes">Brakes</option>
                            <option value="Cab + Accessories">Cab + Accessories</option>
                            <option value="Electrical">Electrical / Batteries</option>
                            <option value="Hydraulics ">Hydraulics </option>
                            <option value="Structure">Structure</option>
                            <option value="All Glass & Mirrors">All Glass & Mirrors</option>
                            <option value="Tracks / Under Carriage / Tyres">Tracks / Under Carriage / Tyres</option>
                            <option value="Steering">Steering</option>
                            <option value="Cooling System">Cooling System</option>
                            <option value="Instruments">Instruments</option>
                            <option value="Other">Other / Comment</option>
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-8 pb-sm-9 pb-md-0">
                        <label class="col-lg-3 control-label" for="Comment">Comment</label>
                        <div class="col-lg-12">
                            <textarea name="comment" class="form-control" rows="3" id="Comment"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">

                    </div>
                </div>
            </div>
            <footer class="card-footer">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button type="submit" name="add_event" class="btn btn-primary">Add Event</button>&nbsp;<button class="btn btn-default modal-dismiss">Cancel</button>
                    </div>
                </div>
            </footer>
        </section>
    </form>
</div>
<!-- Modal view End -->
<section id="evt_section" class="card mt-3">
    <header class="card-header">
        <h2 class="card-title">Events</h2>
    </header>

    <div class="card-body">
        <div class="header-right">
            <a class="mb-1 mt-1 mr-1 modal-basic" href="#modalAddEvent"><button class="btn btn-primary">Add Event</button></a>
        </div>
        <table width="1047" class="table table-responsive-md mb-0">
            <thead>
                <tr>
                    <th width="100">Date</th>
                    <th width="100">Type</th>
                    <th width="120">Time Worked</th>
                    <th width="459">Comments</th>
                    <th width="120">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $get_job_events = dbq("select * from jobcard_events where job_id={$_GET['id']} order by start_datetime");
                if ($get_job_events) {
                    if (dbr($get_job_events) > 0) {
                        while ($event = dbf($get_job_events)) {
                            $event_date = date_create($event['start_datetime']);
                            $event_date = date_format($event_date, 'Y-m-d');
                ?>
                            <tr>
                                <td><?= $event_date ?></td>
                                <td><?= $event['event'] ?></td>
                                <td><?= $event['total_hours'] ?></td>
                                <td><?= $event['comment'] ?></td>
                                <td class="actions">
                                    <a class="mb-1 mt-1 mr-1 modal-basic" href="#modalEditEvent_<?= $event['event_id'] ?>"><i class="fas fa-pencil-alt fa-2x"></i></a>
                                    &nbsp;<a class="mb-1 mt-1 mr-1 modal-basic" href="#modalDeleteEvent_<?= $event['event_id'] ?>"><i class="fas fa-trash-alt fa-2x"></i></a>
                                </td>
                            </tr>
                        <?php
                            $modal .= '<div id="modalDeleteEvent_' . $event['event_id'] . '" class="modal-block modal-block-lg mfp-hide">
                                        <section class="card">
                                            <form method="post">
                                            <header class="card-header">
                                                <h2 class="card-title">View Event</h2>
                                            </header>
                                            <div class="card-body">'
                                . inp('event_id', '', 'hidden', $event['event_id'])
                                . '
                                                <label>Are you sure you want to delete this event?</label><br>
                                                <button class="btn btn-success" type="submit" value="Yes" name="delete_event">Yes</button>
                                                <button class="btn btn-danger modal-dismiss">No</button>
                                            </div>
                                            </form>
                                        </section>
                                    </div>
                                        ';

                            $modal .= '
											
											<div id="modalEditEvent_' . $event['event_id'] . '" class="modal-block modal-block-lg mfp-hide">
												<section class="card">
													<form method="post">
													<header class="card-header">
														<h2 class="card-title">View Event</h2>
													</header>
													<div class="card-body">
													
													<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">'
                                . inp('event_id', '', 'hidden', $event['event_id'])
                                . inp('event_date', 'Event Date', 'date', $event_date)
                                . inp('total_hours', 'Hours Worked', 'number', $event['total_hours'], '', 0, '', ' step="0.5"')
                                . '
														</div>
														<div class="col-sm-12 col-md-4 pb-sm-3 pb-md-0">';
                            $select_event_ = [
                                ['name' => 'Select Event', 'value' => '0'],
                                ['name' => 'Engine', 'value' => 'Engine'],
                                ['name' => 'Clutch', 'value' => 'Clutch'],
                                ['name' => 'Gearbox/Drive Train', 'value' => 'Gearbox'],
                                ['name' => 'Axel + Suspension Rear', 'value' => 'Axlerear'],
                                ['name' => 'Axel + Suspension Front', 'value' => 'Axlefront'],
                                ['name' => 'Brakes', 'value' => 'Brakes'],
                                ['name' => 'Cab + Accessories', 'value' => 'Cab'],
                                ['name' => 'Electrical', 'value' => 'Electrical'],
                                ['name' => 'Hydraulics ', 'value' => 'Hydraulics '],
                                ['name' => 'Structure', 'value' => 'Structure']

                            ];

                            $modal .=                    inp('event', 'Select Event', 'select', $event['event'], '', 0, $select_event_)
                                . '															
														</div>
														<div class="col-sm-12 col-md-8 pb-sm-9 pb-md-0">'
                                . inp('comment', 'Comment', 'textarea', $event['comment'])
                                . '
														</div>
													</div>
													<footer class="card-footer">
														<div class="row">
															<div class="col-md-12 text-right">															
																<button type="submit" value="save" name="save_event" class="btn btn-primary">Save</button>
																<button class="btn btn-default modal-dismiss">Cancel</button>
															</div>
														</div>
													</footer>
													</form>
												</section>
											</div>
											';
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan='5'>Nothing to list</td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</section>