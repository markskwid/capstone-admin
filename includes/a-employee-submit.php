<?php
include 'dbcon.php';
if (isset($_GET['confirm-btn'])) {
    $del_id = $_GET['confirm-btn'];
    $alert_del = '';

    $emp_name = $_GET['emps-name'];
    $emp_email = $_GET['emps-email'];
    $emp_contact = $_GET['emps-contact'];
    $emp_password = $_GET['emps-password'];
    $emp_schedule = $_GET['emps-sched'];
    // $emp_key = $_GET['emps-id'];

    $postData = [
        'employee_name' => $emp_name,
        'employee_email' => $emp_email,
        'employee_contact' => $emp_contact,
        'employee_schedule' => $emp_schedule,
        'employee_password' => $emp_password
    ];


    $ref_tbl = 'archive_employee/' . $del_id;

    $ref_table = 'employee';
    $postRef_result = $database->getReference($ref_table)->push($postData);
    if ($postRef_result) {
        $del_result = $database->getReference($ref_tbl)->remove();
        if ($del_result) {
            echo $alert_del = '<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
            <i class="fa fa-check mr-1" aria-hidden="true"></i><strong>Employee has been restored!</strong>
        </div>';
        } else {
            echo $alert_del = '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
                <strong>Failed to restore!</strong>
            </div>';
        }
    } else {
        echo $alert_del = '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
                <strong>Failed to restore!</strong>
            </div>';
    }
}
