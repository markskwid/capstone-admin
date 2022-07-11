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
    <title>TRENDZ: Add Booking</title>
</head>
<body>
  <div class="row main-wrapper">
  <?php include './includes/sidebar.php'; ?>

    <div id="main" class="content-wrapper">    
      <div class="col-md-12 mx-auto heading d-flex justify-content-md-left">
            <img src="./assets/history_icon2.png" class="icon-heading">
            <span>ADD APPOINTMENT</span>
          </div>

          <div id="content-wrapper" class="col-md-12 mx-auto content">
            <div class="row">
                <div class="container-md container-input">
                    <h4>MAKE A BOOKING</h4>
                    <div class="form-group">
                        <label for="date">Choose date:</label>
                        <input type="date" class="form-control" class="date-picker" onfocus="(this.type='date')">
                    </div>

                    <div class="for-btn-time">
                        <label for="date">Choose Time:</label>
                        <div class="form-inline">
                            <button type="button" class="btn  time-button btn-secondary">8:00 AM - 9:00 AM</button>
                            <button type="button" class="btn  time-button btn-secondary">9:00 AM - 10:00 AM</button>
                            <button type="button" class="btn  time-button btn-secondary">10:00 AM - 11:00 AM</button>
                            <button type="button" class="btn  time-button btn-secondary">11:00 AM- 12:00 NN</button>

                            <button type="button" class="btn  time-button btn-secondary">12:00 NN - 1:00 PM</button>
                            <button type="button" class="btn  time-button btn-secondary">1:00 PM - 2:00 PM</button>
                            <button type="button" class="btn  time-button btn-secondary">2:00 PM - 3:00 PM</button>
                            <button type="button" class="btn  time-button btn-secondary">3:00 PM - 4:00 PM</button>
                            <button type="button" class="btn  time-button btn-secondary">4:00 PM - 5:00 PM</button>
                        </div>
                  </div>

                  <h6>CUSTOMER INFO</h6>
                  <div class="row container-customer-info">
                  <div class="form-group ">
                            <label for="date" class="text-left">Customer Name:</label>
                            <input type="text" class="form-control" class="date-picker">
                        </div>

                        <div class="form-group">
                          <label for="date">Type of Service:</label>
                          <select class="form-control" id="sel1">
                            <option>Hair Service</option>
                            <option>Nail Service</option>
                            <option>Eye Lashes</option>
                          </select>                       
                       </div>

                       <div class="form-group">
                        <label for="date">Phone Number:</label>
                        <input type="text" class="form-control" class="date-picker">
                        
                       </div>

                       <div class="form-group">
                        <label for="date">Home Address:</label>
                        <input type="text" class="form-control" class="date-picker">
                        
                       </div>
                       <div class="for-btn text-center">
                         <button type="button" class="btn event-submit btn-secondary">CONFIRM EVENT</button>
                    </div>
                  </div>
                </div>

                <div class="container-md booking-display">
                    <h4 class="text-center">SEPTEMBER</h4>

                    <!-- dito yung mga event for-loop for this-->
                    <div class="container-fluid book-container">
                      <img src="./assets/announcement_icon.png" class="icon">
                    </div>

                </div>
            </div>
          </div>

    </div>

  </div>

 

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
  <script src="./js/main.js"></script>
 
</body>
</html>