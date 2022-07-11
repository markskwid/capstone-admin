
<?php
include 'dbcon.php';
if (isset($_GET['confirm-btn'])) {
  $del_id = $_GET['confirm-btn'];
  $alert_del = '';
  $ref_tbl = 'announcement/' . $del_id;
  $del_result = $database->getReference($ref_tbl)->remove();

  if ($del_result) {
    echo $alert_del = '<div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
          <i class="fa fa-check mr-1" aria-hidden="true"></i><strong>Event has been deleted!</strong>
        </div>';
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


include 'dbcon.php';

if (isset($_POST['add-to-reservation'])) {
  $name = $_POST['book-name'];
  $email = $_POST['book-email'];
  $contact = $_POST['book-contact'];
  $service = $_POST['book-service'];

  $fulldate = $_POST['book-date'];
  $time = $_POST['book-time'];

  $alert = '';

  $bool = true;
  $ref_table = 'reservation';

  $getDay = strtotime($fulldate);
  $day = date('D', $getDay);

  $explodedDate = explode('-', $fulldate);
  $monthName = date("F", mktime(0, 0, 0, $explodedDate[1]));
  $abbreviatedMonth = date('M', strtotime($monthName));
  $date = $explodedDate[2];
  $year = $explodedDate[0];

  $postData = [
    'date' => $date,
    'day' => $day,
    'image' => '',
    'message' => 'Added by admin',
    'month' => $abbreviatedMonth,
    'reserveBy_contact' => $contact,
    'reserveBy_name' => $name,
    'reserveBy_email' => $email,
    'type' => $service,
    'time' => $time,
    'year' => $year,
    'fulldate' => $fulldate,
  ];

  $postRef_result = $database->getReference($ref_table)->push($postData);

  if ($postRef_result) {
    echo $alert = '<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
            <i class="fa fa-check mr-1" aria-hidden="true"></i><strong>Appointment has been added! </strong>
          </div>';
  } else {
    echo $alert = '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
            <strong>Failed to add appointment!</strong>
          </div>';
  }
}

if (isset($_POST['add-to-event'])) {
  $event_title = $_POST['event-title'];
  $event_date = $_POST['event-date'];
  $event_info = $_POST['event-info'];

  $alert = '';

  $bool = true;
  $ref_table = 'announcement';

  $explodedDate = explode('-', $event_date);
  $monthName = date("F", mktime(0, 0, 0, $explodedDate[1]));
  $abbreviatedMonth = date('M', strtotime($monthName));
  $date = $explodedDate[2];
  $year = $explodedDate[0];

  $postData = [
    'announcement_date' => $date,
    'announcement_info' =>  $event_info,
    'announcement_month' => $abbreviatedMonth,
    'announcement_title' => $event_title,
    'announcement_year' => $year,
    'announcement_fulldate' => $event_date,
  ];

  $postRef_result = $database->getReference($ref_table)->push($postData);

  if ($postRef_result) {
    echo $alert = '<div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
          <i class="fa fa-check mr-1" aria-hidden="true"></i><strong>New Event has been added! </strong>
        </div>';
  } else {
    echo $alert = '<div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
          <strong>Failed to add!</strong>
        </div>';
  }
}

?> 
