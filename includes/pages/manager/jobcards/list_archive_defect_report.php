<?php
$jobcard_ = get_jobcard($row['job_id']);
if (file_exists('./files')) {
    $allfiles = scandir("./files/defect-reports/{$row['job_id']}");
} else {
    $allfiles = scandir("../files/defect-reports/{$row['job_id']}");
}
$photos = [];
foreach ($allfiles as $file) {
    if (strstr($file, "{$row['id']}-defect-report")) {
        $photos[] = $file;
    }
}
?>
<tr>
    <td><?= $jobcard_['jobcard_number'] ?></td>
    <td><?= $row['component'] ?></td>
    <td><?= $row['severity'] ?></td>
    <td><?= $row['hours'] ?></td>
    <td><?= $row['comment'] ?></td>
    <td>
        <a href="#modal_<?= $row['id'] ?>" type="button" class="btn btn-sm btn-warning modal-sizes">
            <i class="fa fa-folder-open"></i>
        </a>
        <div id='modal_<?= $row['id'] ?>' class='modal-block modal-block-lg mfp-hide'>
            <form method='post' enctype='multipart/form-data'>
                <section class='card'>
                    <header id='modal_<?= $row['id'] ?>header' class='card-header'>
                        <h2 class='card-title'></h2>
                    </header>
                    <div class='card-body'>
                        <div class='modal-wrapper'>
                            <div class='modal-text'>
                                <div class="row">
                                    <div class="col-md-12">
                                        #:<?= $row['id'] ?>
                                    </div>
                                    <div class="col-md-6">
                                        <b>Component</b><br>
                                        <p><?= $row['component'] ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <b>Severity</b><br>
                                        <p><?= strtoupper($row['severity']) ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <b>Component</b><br>
                                        <p><?= $row['component'] ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <b>Hours</b><br>
                                        <p><?= $row['hours'] ?></p>
                                    </div>
                                    <div class="col-md-12">
                                        <b>Comment</b><br>
                                        <p><?= $row['comment'] ?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <?php
                                    if (count($photos) > 0) {
                                        foreach ($photos as $photo) {
                                    ?>
                                            <div class="col-md-6">
                                                <img with src="./files/defect-reports/<?= $row['job_id'] . '/' . $photo ?>" alt="" class="rounded img-fluid">
                                            </div>
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <footer class='card-footer'>
                        <div class='row'>
                            <div class='col-md-12 text-right'>
                                <button class='btn btn-default modal-dismiss'>Close</button>
                            </div>
                        </div>
        </div>
        </footer>
        </section>
        </form>
        </div>
    </td>
</tr>