
<?php
include 'dbcon.php';
if (isset($_GET['confirm-btn'])) {
    $del_id = $_GET['confirm-btn'];
    $alert_del = '';
    $ref_tbl = 'success_appointment/' . $del_id;
    $del_result = $database->getReference($ref_tbl)->remove();

    if ($del_result) {
        echo $alert_del = '<div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
          <i class="fa fa-check mr-1" aria-hidden="true"></i><strong>Appointment has been deleted!</strong>
        </div>';
    } else {
        echo $alert_del = '<div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
          <strong>Failed to delete!</strong>
        </div>';
    }
}
?>
