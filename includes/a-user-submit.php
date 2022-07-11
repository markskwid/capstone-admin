<?php
include 'dbcon.php';

if (isset($_GET['confirm-btn'])) {
    $alert_del = '';
    $uid = $_GET['confirm-btn'];

    $emp_name = $_GET['emps-name'];
    $emp_email = $_GET['emps-email'];
    $emp_contact = $_GET['emps-contact'];
    $emp_password = $_GET['emps-password'];
    $emp_address = $_GET['emps-address'];
    $emp_uid = $_GET['emps-uid'];
    $emp_key = $_GET['emps-id'];


    $postData = [
        'fullname' => $emp_name,
        'email' => $emp_email,
        'customer_phone' => $emp_contact,
        'customer_password' => $emp_password,
        'customer_address' => $emp_address,
        'customer_id' => $emp_uid,
    ];


    $userProperties = [
        'uid' => $emp_uid,
        'email' => $emp_email,
        'emailVerified' => true,
        'password' => $emp_password,
        'displayName' =>  $emp_name,
        'disabled' => false,
    ];


    $ref_table = 'information';
    $ref_tbl = 'archive_user/' . $emp_key;


    try {
        $createdUser = $auth->createUser($userProperties);
        $postRef_result = $database->getReference($ref_table)->push($postData);

        if ($postRef_result) {
            $del_result = $database->getReference($ref_tbl)->remove();
            if ($del_result) {
                echo $alert_del = '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
                <i class="fa fa-check mr-1" aria-hidden="true"></i><strong>User has been restored!</strong>
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
    } catch (Exception $e) {
        echo $alert_del = '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
            <strong>Failed to delete!</strong>
          </div>';
    }
}
