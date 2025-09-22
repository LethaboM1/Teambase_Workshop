<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Fleet Checklist</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    table { width: 100%; border-collapse: collapse; font-size: 14px; }
    th, td { border: 1px solid #ccc; padding: 5px; text-align: center; vertical-align: middle; }
    th { background-color: #f1f1f1; }
    textarea { width: 100%; resize: none; }
    input[type="text"] { width: 100%; text-align: center; }
</style>
</head>
<body>
<div class="container my-4">
<h2>Fleet Checklist</h2>

<form method="POST" action="save_fleet_checklist.php">
<table class="table table-bordered">
    <thead>
        <tr>
            <th rowspan="2">Date</th>
            <th rowspan="2">Fleet No</th>
            <th rowspan="2">Site</th>
            <th rowspan="2">Hrs / KM / Driver</th>
            <th colspan="16">Checks</th>
            <th rowspan="2">Comments</th>
            <th rowspan="2">Certified</th>
            <th colspan="3">Signatures</th>
        </tr>
        <tr>
            <th>Lights</th>
            <th>Tyres & Spare</th>
            <th>Oil/Fuel/Water</th>
            <th>Drain Water Air Tanks</th>
            <th>Wipers</th>
            <th>Hooter</th>
            <th>Clutch & Breaks</th>
            <th>License & Operator Card</th>
            <th>Number Plates & Chevron</th>
            <th>Steering</th>
            <th>Bodywork & Doors</th>
            <th>Windscreen & Windows</th>
            <th>Batteries</th>
            <th>Frame & Milling Drum</th>
            <th>Paver Screed</th>
            <th>TLD (Fork)</th>
            <th>Fire Extinguisher/Equipment</th>
            <th>Driver/Operator</th>
            <th>Mechanic</th>
            <th>Workshop Clerk</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($fleet = dbf($get_fleets)): ?>
        <tr>
            <td><input type="date" name="date[<?= $fleet['fleet_id'] ?>]" value="<?= date('Y-m-d') ?>"></td>
            <td><?= htmlspecialchars($fleet['fleet_no']) ?></td>
            <td><input type="text" name="site[<?= $fleet['fleet_id'] ?>]" placeholder="Site"></td>
            <td><input type="text" name="hours[<?= $fleet['fleet_id'] ?>]" placeholder="Hrs / KM / Driver"></td>

            <!-- Checks -->
            <?php 
            $checks = [
                'lights','tyres','oil_fuel_water','drain_tanks','wipers','hooter','clutch_brakes',
                'license','plates','steering','body','windows','batteries','frame','paver_screed',
                'tld','fire_extinguisher'
            ];
            foreach ($checks as $check): ?>
                <td>
                    <select name="check_<?= $check ?>[<?= $fleet['fleet_id'] ?>]">
                        <option value="">N/A</option>
                        <option value="✓">✓</option>
                        <option value="X">X</option>
                    </select>
                </td>
            <?php endforeach; ?>

            <td><textarea name="comments[<?= $fleet['fleet_id'] ?>]" rows="1"></textarea></td>
            <td>
                <select name="certified[<?= $fleet['fleet_id'] ?>]">
                    <option value="">Select</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </td>

            <!-- Signatures -->
            <td><input type="text" name="driver_sign[<?= $fleet['fleet_id'] ?>]" placeholder="Sign"></td>
            <td><input type="text" name="mechanic_sign[<?= $fleet['fleet_id'] ?>]" placeholder="Sign"></td>
            <td><input type="text" name="clerk_sign[<?= $fleet['fleet_id'] ?>]" placeholder="Sign"></td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

<div class="mb-3">
    <button type="submit" class="btn btn-primary">Save Checklist</button>
</div>
</form>
</div>
</body>
</html>
