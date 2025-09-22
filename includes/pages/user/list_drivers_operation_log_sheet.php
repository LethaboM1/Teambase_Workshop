<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Driver / Operator Log Sheet</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    table { width: 100%; border-collapse: collapse; font-size: 14px; }
    th, td { border: 1px solid #000; padding: 6px; text-align: center; vertical-align: middle; }
    th { background-color: #f1f1f1; }
    textarea, input { width: 100%; font-size: 13px; }
</style>
</head>
<body>
<div class="container my-4">

<h2 class="mb-3 text-center">Driver / Operator Log Sheet</h2>

<form method="POST" action="save_drivers_log_sheet.php">

    <div class="row mb-3">
        <div class="col-md-4">
            <label>Driver's / Operator's Name</label>
            <input type="text" name="driver_name" class="form-control">
        </div>
        <div class="col-md-4">
            <label>Fleet No</label>
            <input type="text" name="fleet_no" class="form-control">
        </div>
        <div class="col-md-4">
            <label>Company No</label>
            <input type="text" name="company_no" class="form-control">
        </div>
    </div>

    <h5 class="mt-4">Vehicle Transfer Details</h5>
    <table class="table table-bordered">
        <tr>
            <th>Dispatched From Site No.</th>
            <td><input type="text" name="dispatched_from"></td>
            <th>Date @ Off Hire</th>
            <td><input type="date" name="date_off"></td>
            <th>Time @ Off Hire</th>
            <td><input type="time" name="time_off"></td>
        </tr>
        <tr>
            <th>Hour Meter @ Off Hire</th>
            <td><input type="text" name="hour_off"></td>
            <th>Off Hire Ref No.</th>
            <td colspan="3"><input type="text" name="ref_no"></td>
        </tr>
        <tr>
            <th>Received By Site No.</th>
            <td><input type="text" name="received_by_site"></td>
            <th>Supervisor Name</th>
            <td colspan="3"><input type="text" name="received_by_name"></td>
        </tr>
        <tr>
            <th>Date @ On Hire</th>
            <td><input type="date" name="date_on"></td>
            <th>Time @ On Hire</th>
            <td><input type="time" name="time_on"></td>
            <th>Hour Meter @ On Hire</th>
            <td><input type="text" name="hour_on"></td>
        </tr>
    </table>

    <h5 class="mt-4">Daily Log</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Day</th>
                <th>Start</th>
                <th>End</th>
                <th>Operating Time</th>
                <th>Fuel (L)</th>
                <th>Machine Hr / Km Reading</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
            foreach ($days as $day): ?>
            <tr>
                <td><?= $day ?></td>
                <td><input type="time" name="start[<?= $day ?>]"></td>
                <td><input type="time" name="end[<?= $day ?>]"></td>
                <td><input type="text" name="operating_time[<?= $day ?>]"></td>
                <td><input type="number" step="0.01" name="fuel[<?= $day ?>]"></td>
                <td><input type="text" name="reading[<?= $day ?>]"></td>
                <td><textarea name="remarks[<?= $day ?>]" rows="1"></textarea></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="row mb-3">
        <div class="col-md-6">
            <label>Reason for Breakdown / Remarks</label>
            <textarea name="breakdown_reason" class="form-control" rows="2"></textarea>
        </div>
        <div class="col-md-6">
            <label>Supervisor</label>
            <input type="text" name="supervisor" class="form-control">
        </div>
    </div>

    <h5 class="mt-4">Signatures</h5>
    <div class="row mb-3">
        <div class="col-md-6">
            <label>Received From Operator (Clerk Name)</label>
            <input type="text" name="clerk_name" class="form-control">
        </div>
        <div class="col-md-3">
            <label>Date Received</label>
            <input type="date" name="date_received" class="form-control">
        </div>
        <div class="col-md-3">
            <label>Clerk Signature</label>
            <input type="text" name="clerk_sign" class="form-control">
        </div>
    </div>

    <div class="text-center mt-4">
        <button type="submit" class="btn btn-primary">Save Log Sheet</button>
    </div>
</form>

</div>
</body>
</html>