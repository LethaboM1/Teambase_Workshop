<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Plant Quality Inspection Sheet</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    .pass { background-color: #d4edda !important; } /* green */
    .fail { background-color: #f8d7da !important; } /* red */
    .fair { background-color: #fff3cd !important; } /* yellow */
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    select { padding: 4px; width:100%; }
    #plantCondition.pass { background-color: #d4edda; }
    #plantCondition.fail { background-color: #f8d7da; }
    #plantCondition.fair { background-color: #fff3cd; }
</style>
</head>
<body>
<div class="container my-4">
<h2>Plant Quality Inspection Sheet</h2>

<form method="POST">
    <div class="mb-3">
        <label>Date: <input type="date" name="date" class="form-control" value="<?= date('Y-m-d') ?>" required></label>
    </div>
    <div class="mb-3">
        <label>Plant Number: <input type="text" name="plant_number" class="form-control" value="<?= $plant['plant_number'] ?>" readonly></label>
    </div>
    <div class="mb-3">
        <label>Mechanic Name: <input type="text" name="mechanic" class="form-control" value="<?= $_SESSION['user']['name'] ?>" readonly></label>
    </div>
    <div class="mb-3">
        <label>Inspector Name: <input type="text" name="inspector" class="form-control" required></label>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Item</th>
                <th>Pass / Fail</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($get_checklist && mysqli_num_rows($get_checklist) > 0): ?>
            <?php while ($checkitem = mysqli_fetch_assoc($get_checklist)): ?>
            <tr>
                <td><?= htmlspecialchars($checkitem['check_item']) ?></td>
                <td>
                    <select class="check" name="checklist[<?= $checkitem['checklist_id'] ?>]">
                        <option value="">Select</option>
                        <option value="pass">Pass</option>
                        <option value="fail">Fail</option>
                    </select>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="2">No checklist items found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

    <div class="mb-3">
        <label>Plant Condition: <input type="text" name="plant_condition" id="plantCondition" class="form-control" readonly></label>
    </div>

    <div class="mb-3">
        <label>Comments:</label>
        <textarea name="comments" class="form-control" rows="4"></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Submit Checklist</button>
    <button type="reset" class="btn btn-secondary" id="resetBtn">Reset</button>
</form>
</div>

<script>
const checkboxes = document.querySelectorAll('.check');
const plantCondition = document.getElementById('plantCondition');
const resetBtn = document.getElementById('resetBtn');

function updateChecklist() {
    let anyFail = false;
    let allPass = true;

    checkboxes.forEach(cb => {
        const row = cb.parentElement.parentElement;
        row.classList.remove('pass','fail');
        if (cb.value === 'pass') row.classList.add('pass');
        if (cb.value === 'fail') {
            row.classList.add('fail');
            anyFail = true;
            allPass = false;
        }
        if (cb.value === '') allPass = false;
    });

    plantCondition.classList.remove('pass','fail','fair');
    if (anyFail) { plantCondition.value='BAD'; plantCondition.classList.add('fail'); }
    else if (allPass) { plantCondition.value='GOOD'; plantCondition.classList.add('pass'); }
    else { plantCondition.value='FAIR'; plantCondition.classList.add('fair'); }
}

checkboxes.forEach(cb => cb.addEventListener('change', updateChecklist));
resetBtn.addEventListener('click', () => {
    setTimeout(() => {
        checkboxes.forEach(cb => cb.parentElement.parentElement.classList.remove('pass','fail'));
        plantCondition.value='';
        plantCondition.classList.remove('pass','fail','fair');
    }, 10);
});
</script>

</body>
</html>