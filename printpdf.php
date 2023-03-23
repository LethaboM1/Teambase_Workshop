<?php
require_once "includes/creds.php";

require_once "includes/functions.php";
include "includes/inc.header.php";
?>
<div class="container">
    <div class="row mt-5">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <h2>HTML to PDF</h2>
            <form target="_blank" action="printpdf_.php" method="post">
                <?= inp('html_code', 'HTML', 'textarea', $_POST['html_code'], '', 0, '', 'style="font-size: 12px;"') ?>
                <?= inp('orientation', 'Orientaion', 'select', '', '', 0, [['name' => 'P', 'value' => 'P'], ['name' => 'L', 'value' => 'L']]) ?>
                <?= inp('print', '', 'submit', 'Print', 'btn-primary') ?>
            </form>
        </div>
        <div class="col-md-2"></div>
    </div>
</div>
<?php
