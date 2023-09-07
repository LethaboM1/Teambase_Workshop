<div class="row">
    <div class="header-right col-lg-4 col-md-4">
        <h3>Prints list of plant inspections over date range</h3>
        <form target="_blank" action="print.php" method="get">
            <?= inp('start', 'From', 'date', date('Y-m-01')) ?>
            <?= inp('end', 'From', 'date', date('Y-m-d')) ?>
            <button class="btn btn-primary mt-2" name='type' value='plant-inspection' type="submit">Print</button>
        </form>
    </div>
</div>