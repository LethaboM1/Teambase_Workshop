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
            <form target="_blank" action="print.php" method="post">
                <?= inp('html_code', 'HTML', 'textarea', $_POST['html_code']) ?>
                <?= inp('print', '', 'submit', 'Print', 'btn-primary') ?>
            </form>
        </div>
        <div class="col-md-2"></div>

    </div>
</div>
<?php
