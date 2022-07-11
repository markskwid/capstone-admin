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
    $fulldate = date('Y-m-d');

    $postData = [
        'fullname' => $emp_name,
        'email' => $emp_email,
        'customer_phone' => $emp_contact,
        'customer_password' => $emp_password,
        'customer_address' => $emp_address,
        'customer_id' => $emp_uid,
        'date_deleted' => trim($fulldate),
    ];

    $ref_table = 'archive_user';
    $ref_tbl = 'information/' . $emp_key;


    try {
        $auth->deleteUser($emp_uid);
        $postRef_result = $database->getReference($ref_table)->push($postData);
        if ($postRef_result) {
            $del_result = $database->getReference($ref_tbl)->remove();
            if ($del_result) {
                echo $alert_del = '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
                <i class="fa fa-check mr-1" aria-hidden="true"></i><strong>User has been deleted!</strong>
              </div>';
            } else {
                echo $alert_del = '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
                <strong>Failed to delete!</strong>
              </div>';
            }
        } else {
            echo $alert_del = '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
            <strong>Failed to delete!</strong>
          </div>';
        }
    } catch (Exception $e) {
        echo $alert_del = '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
            <strong>Failed to delete!</strong>
          </div>';
    }
}
?>

<?php

include 'dbcon.php';

if (isset($_POST['add-to-employee'])) {
    $emp_name = $_POST['employee-name'];
    $emp_email = $_POST['employee-email'];
    $emp_contact = $_POST['employee-contact'];
    $emp_password = $_POST['employee-password'];
    $emp_address = $_POST['employee-address'];

    $alert = '';

    $str = ltrim($emp_contact, '0');
    $formattedContact = '+63' . $str;

    $userProperties = [
        'email' => $emp_email,
        'emailVerified' => true,
        'password' => $emp_password,
        'displayName' =>  $emp_name,
        'disabled' => false,
    ];



    try {
        $createdUser = $auth->createUser($userProperties);

        $postData = [
            'fullname' => $emp_name,
            'email' => $emp_email,
            'customer_phone' => $emp_contact,
            'customer_password' => $emp_password,
            'customer_address' => $emp_address,
            'customer_id' => $createdUser->uid,
        ];
        $ref_table = 'information';
        $postRef_result = $database->getReference($ref_table)->push($postData);

        if ($postRef_result) {
            echo $alert_del = '<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
            <i class="fa fa-check mr-1" aria-hidden="true"></i><strong>New user has been added!</strong>
        </div>';
        } else {
            echo $alert_del = '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
            <strong>Failed to add!' . $formattedContact . '</strong>
          </div>';
        }
    } catch (Exception $e) {
        echo $alert_del = '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
            <strong>Failed to add!' . $formattedContact . '</strong>
        </div>';
    }
}
?>

<?php

include 'dbcon.php';


if (isset($_POST['update-id'])) {
    $uid = $_POST['update-uid'];

    $key_child = $_POST['update-id'];

    $alert_update = '';

    $new_name = $_POST['update-name'];
    $new_email = $_POST['update-email'];
    $new_password = $_POST['update-password'];
    $new_contact = $_POST['update-contact'];
    $new_address = $_POST['update-address'];

    $properties = [
        'displayName' => $new_name,
    ];


    $updateData = [
        'fullname' => $new_name,
        'email' => $new_email,
        'customer_phone' => $new_contact,
        'customer_address' => $new_address,
        'customer_password' => $new_password,
        'customer_id' => $uid,
    ];

    $update_tbl = 'information/' . $key_child;
    $update_query = $database->getReference($update_tbl)->update($updateData);

    try {
        $updatedUser = $auth->updateUser($uid, $properties);
        $updatedPassword = $new_password == null ? '' :  $auth->changeUserPassword($uid, $new_password);
        $updatedEmail = $auth->changeUserEmail($uid,  $new_email);

        echo $alert_del = '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
                <i class="fa fa-check mr-1" aria-hidden="true"></i><strong>User edited successfully!</strong>
            </div>';
    } catch (Exception $e) {
        echo $alert_del = '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
                <strong>Failed to edit! </strong>
            </div>';
    }
}
