
<?php
include 'dbcon.php';
if (isset($_GET['confirm-btn'])) {
  $del_id = $_GET['confirm-btn'];
  $alert_del = '';
  $ref_tbl = 'reservation/' . $del_id;
  $del_result = $database->getReference($ref_tbl)->remove();

  if ($del_result) {
    echo $alert_del = '<div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
          <i class="fa fa-check mr-1" aria-hidden="true"></i><strong>Reservation has been deleted!</strong>
        </div>';
  } else {
    echo $alert_del = '<div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
          <strong>Failed to delete!</strong>
        </div>';
  }
}


if (isset($_POST['update-id'])) {
  $key_child = $_POST['update-id'];

  $alert_update = '';

  $new_name = $_POST['update-name'];
  $new_email = $_POST['update-email'];
  $new_contact = $_POST['update-contact'];
  $new_time = $_POST['update-time'];
  $new_service = $_POST['update-service'];
  $new_fulldate = $_POST['update-date'];
  $month = $_POST['month'];
  $date = $_POST['date'];
  $year = $_POST['year'];
  $day = $_POST['day'];
  $reserveBy = $_POST['reserveBy'];

  $postData = [
    'date' => $date,
    'day' => $day,
    'image' => '',
    'message' => 'Added by admin',
    'month' => $month,
    'reserveBy_contact' => $new_contact,
    'reserveBy_name' => $new_name,
    'reserveBy_email' => $new_email,
    'type' => $new_service,
    'time' => $new_time,
    'year' => $year,
    'fulldate' => $new_fulldate,
    'servicedBy_name' => 'Administrator',
    'reserveBy_id' => $reserveBy,
  ];

  $del_tbl = 'reservation/' . $key_child;
  $ref_tbl = 'success_appointment';

  $postRef_result = $database->getReference($ref_tbl)->push($postData);

  if ($postRef_result) {
    $del_result = $database->getReference($del_tbl)->remove();
    if ($del_result) {
      echo $alert_update = '<div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
      <i class="fa fa-check mr-1" aria-hidden="true"></i><strong>Appointment marked as done!</strong>
    </div>';
    } else {
      echo $alert_update = '<div class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
      <strong>Failed to update!</strong>
    </div>';
    }
  } else {
    echo $alert_update = '<div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
          <strong>Failed to update!</strong>
        </div>';
  }
}


?>


<?php
include 'dbcon.php';
if (isset($_POST['search-btn'])) {
  $del_id = $_GET['confirm-btn'];
  $alert_del = '';
  $value_search = $_POST['search-customer'];
  header('location: ./reservation-search.php');
}

?>
