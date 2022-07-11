<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="icon" type="image/gif" href="./assets/shortcut_icon.png" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="./css/main.css">
  <link rel="stylesheet" href="./css/calendar.css">
  <title>TRENDZ: Events</title>
</head>

<body>
  <div class="row main-wrapper">
    <?php include './includes/sidebar.php'; ?>

    <div id="main" class="content-wrapper">

      <div class="col-md-12 mx-auto heading d-flex justify-content-md-left">
        <img src="./assets/add_event.png" class="icon-heading">
        <span>EVENTS AND APPOINTMENTS</span>
      </div>
      <?php include './includes/event-submit.php'; ?>
      <div id="content-wrapper" class="col-md-12 mx-auto content">

        <div class="container-calendar">
          <div class="calendar">
            <div class="month">
              <i class="fa fa-angle-left prev"></i>
              <div class="date">
                <h1></h1>
                <p></p>
                <div class="row text-center mb-3">
                  <button type="button" class="btn btn-primary ml-2 mr-2" data-toggle="modal" data-target="#myModal-event"><i class="fa fa-calendar-plus-o mr-2 icon-event"></i>Add Event</button>
                  <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#myModal-book"><i class="fa fa-book mr-2 icon-event"></i>Add Book</button>
                </div>
              </div>
              <i class="fa fa-angle-right next"></i>

            </div>
            <div class="weekdays">
              <div>Sun</div>
              <div>Mon</div>
              <div>Tue</div>
              <div>Wed</div>
              <div>Thu</div>
              <div>Fri</div>
              <div>Sat</div>
            </div>
            <div class="days"></div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- modal events -->
  <div class="modal fade" id="myModal-event" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header d-flex justify-content-md-left">
          <img src="./assets/clock.gif" class="icon-heading">
          <h4 class="modal-title mt-1">Add Event</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form action="#" method="POST" autocomplete="off">
          <div class="modal-body">
            <div class="form-group modal-form">
              <span class="fa fa-calendar ml-2"></span><label for="Password" class="ml-2">Event Title: </label>
              <select class="form-control schedule-select" name="event-title" id="sel1">
                <option selected>Announcement</option>
                <option>Get your discount!</option>
                <option>Salon is close.</option>
              </select>
            </div>


            <div class="form-group modal-form">
              <span class="fa fa-calendar ml-2"></span><label for="Password" class="ml-2">Select the Date: </label>
              <input type="date" id="datepicker-event" class="form-control" name="event-date" required="required" min="<?php echo date('Y-m-d'); ?>">
            </div>

            <div class=" form-group modal-form">
              <span class="fa fa-file-text ml-2"></span><label for="Password" class="ml-2">Description: </label>
              <textarea class="form-control" name="event-info" id="comment" placeholder="Write here the description..."></textarea>
            </div>
          </div>

          <div class="mb-3 text-center">
            <button type="submit" name="add-to-event" class="btn btn-success btn-modal">Add to Event <i class="fa fa-angle-right" aria-hidden="true"></i></button>
          </div>
      </div>
      </form>
    </div>
  </div>

  <!-- modal book -->
  <div class="modal fade" id="myModal-book" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header d-flex justify-content-md-left">
          <img src="./assets/doc.gif" class="icon-heading">
          <h4 class="modal-title mt-1">Add Appointment</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form action="#" method="POST" autocomplete="off">
          <div class="modal-body">
            <div class="form-group modal-form">
              <span class="fa fa-user ml-2"></span><label for="Password" class="ml-2">Customer Name: </label>
              <input type="text" class="form-control" id="username" name="book-name" required="required">
            </div>

            <div class="form-group modal-form">
              <span class="fa fa-envelope ml-2"></span><label for="Password" class="ml-2">Email Address: </label>
              <input type="email" class="form-control" id="username" name="book-email" required="required">
            </div>

            <div class="form-group modal-form">
              <span class="fa fa-phone ml-2"></span><label for="Password" class="ml-2">Contact Number: </label>
              <input type="text" class="form-control" id="username" name="book-contact" required="required">
            </div>

            <div class="form-group modal-form">
              <span class="fa fa-calendar ml-2"></span><label for="Password" class="ml-2">Select Service: </label>
              <select class="form-control schedule-select" name="book-service" id="sel1">
                <option selected>Hair</option>
                <option>Nail</option>
                <option>Eyelashes</option>
              </select>
            </div>

            <div class="form-group modal-form">
              <span class="fa fa-calendar ml-2"></span><label for="Password" class="ml-2">Select the Date: </label>
              <input type="date" class="form-control" id="username" name="book-date" required="required" min="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="form-group modal-form">
              <span class="fa fa-calendar ml-2"></span><label for="Password" class="ml-2">Select Time: </label>
              <select class="form-control schedule-select" name="book-time" id="sel1">
                <option selected>Click here to show</option>
                <option>9:00 AM - 10: 00 AM</option>
                <option>10:00 AM - 11: 00 AM</option>
                <option>11:00 AM - 12: 00 PM</option>
                <option>12:00 PM - 1:00 PM</option>
                <option>1:00 PM - 2:00 PM</option>
                <option>2:00 PM - 3:00 PM</option>
                <option>3:00 PM - 4:00 PM</option>
                <option>4:00 PM - 5:00 PM</option>
              </select>
            </div>

            <div class="mb-3 text-center">
              <button type="submit" name="add-to-reservation" class="btn btn-success btn-modal">Add Appointment <i class="fa fa-angle-right" aria-hidden="true"></i></button>
            </div>
          </div>
        </form>
      </div>
    </div>




    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="./js/calendar.js"></script>
    <script src="./js/main.js"></script>

</body>

</html>