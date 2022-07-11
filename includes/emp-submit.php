<?php

include 'dbcon.php';

if (isset($_POST['add-to-employee'])) {
  $emp_name = $_POST['employee-name'];
  $emp_email = $_POST['employee-email'];
  $emp_contact = $_POST['employee-contact'];
  $emp_schedule = $_POST['employee-schedule'];
  $emp_password = $_POST['employee-password'];
  $alert = '';

  $postData = [
    'employee_name' => $emp_name,
    'employee_email' => $emp_email,
    'employee_contact' => $emp_contact,
    'employee_schedule' => $emp_schedule,
    'employee_password' => $emp_password
  ];

  $ref_table = 'employee';
  $postRef_result = $database->getReference($ref_table)->push($postData);

  if ($postRef_result) {
    echo $alert = '<div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
          <i class="fa fa-check mr-1" aria-hidden="true"></i><strong>New Employee has been added!</strong>
        </div>';
  } else {
    echo $alert = '<div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
          <strong>Failed to add!</strong>
        </div>';
  }
}
?>

<?php
//delete
include 'dbcon.php';
if (isset($_GET['confirm-btn'])) {
  $del_id = $_GET['confirm-btn'];
  $alert_del = '';


  $emp_name = $_GET['emps-name'];
  $emp_email = $_GET['emps-email'];
  $emp_contact = $_GET['emps-contact'];
  $emp_password = $_GET['emps-password'];
  $emp_schedule = $_GET['emps-sched'];
  $emp_key = $_GET['emps-id'];
  $fulldate = $_GET['emps-date-deleted'];

  $postData = [
    'employee_name' => $emp_name,
    'employee_email' => $emp_email,
    'employee_contact' => $emp_contact,
    'employee_schedule' => $emp_schedule,
    'employee_password' => $emp_password,
    'date_deleted' => trim($fulldate),
  ];


  $ref_tbl = 'employee/' . $del_id;
  $del_result = $database->getReference($ref_tbl)->remove();
  $ref_table = 'archive_employee';
  if ($del_result) {
    $postRef_result = $database->getReference($ref_table)->push($postData);
    if ($postRef_result) {
      echo $alert_del = '<div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
      <i class="fa fa-check mr-1" aria-hidden="true"></i><strong>Employee has been deleted!</strong>
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
}
?>

<?php

include 'dbcon.php';


if (isset($_POST['update-id'])) {
  $key_child = $_POST['update-id'];
  $ref_tbl = 'employee';
  $alert_update = '';

  $fetch_result = $database->getReference($ref_tbl)->getChild($key_child)->getValue();


  $new_name = $_POST['update-name'];
  $new_email = $_POST['update-email'];
  $new_contact = $_POST['update-contact'];
  $new_schedule = $_POST['update-schedule'];
  $new_password = $_POST['update-password'];

  $updateData = [
    'employee_name' => $new_name,
    'employee_email' => $new_email,
    'employee_contact' => $new_contact,
    'employee_schedule' => $new_schedule,
    'employee_password' => $new_password
  ];
  $update_tbl = 'employee/' . $key_child;
  $update_query = $database->getReference($update_tbl)->update($updateData);

  if ($update_query) {
    echo $alert_update = '<div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
          <i class="fa fa-check mr-1" aria-hidden="true"></i><strong>Employee has been updated!</strong>
        </div>';
  } else {
    echo $alert_update = '<div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
          <strong>Employee has been updated!</strong>
        </div>';
  }
}
