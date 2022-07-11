<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/gif" href="./assets/shortcut_icon.png" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="./css/main.css">
  <title>TRENDZ: Employee</title>
</head>

<body>
  <div class="row main-wrapper">
    <?php include './includes/sidebar.php'; ?>

    <div id="main" class="content-wrapper">

      <div class="col-md-12 mx-auto heading d-flex justify-content-md-left">
        <img src="./assets/emp_icon.png" class="icon-heading">
        <span>EMPLOYEE LIST</span>
      </div>

      <?php
      include './includes/emp-submit.php';

      ?>
      <div id="content-wrapper" class="col-md-12 mx-auto content">
        <div class="row">
          <div class="container-fluid">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">+ Add Employee</button>
            <button type="button" class="btn btn-primary ml-2" id="hide"> Show navigation</button>
            <div class="form-inline float-right">
              <input type="text" class="form-control" id="search" placeholder="Search Employee">
              <button type="button" class="btn btn-primary search">
                <img src="./assets/search_icon.png" alt="" class="icon-search">
              </button>
            </div>
          </div>


          <table class="table table-hover table-striped text-center">
            <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Schedule</th>
                <th>Password</th>
                <th>Action</th>

              </tr>
            </thead>
            <tbody class="tbody">
              <?php
              include 'dbcon.php';
              $ref_table = 'employee';
              $fetchData = $database->getReference($ref_table)->getValue();

              if ($fetchData > 0) {
                foreach ($fetchData as $key => $row) {
              ?>
                  <tr>
                    <td><?= $row['employee_name']; ?></td>
                    <td><?= $row['employee_email']; ?></td>
                    <td><?= $row['employee_contact']; ?></td>
                    <td><?= $row['employee_schedule']; ?></td>
                    <td><?= $row['employee_password']; ?></td>
                    <td>
                      <div class="row">
                        <form method="POST">
                          <a href="edit-emp.php?id<?= $key; ?>" class='btn btn-primary mr-2 edit-btn' id='edit-btn'><i class='fa fa-pencil fa-lg'></i></a>
                          <button type='submit' name='delete-btn' class='btn btn-primary del-btn' value='<?= $key ?>'><i class='fa fa-archive fa-lg'></i></button>
                        </form>
                      </div>

                    </td>
                  </tr>
                <?php
                }
              } else {
                ?>
                <tr>
                  <td colspan="6">NO RECORD FOUND</td>
                </tr>

              <?php
              }


              ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>

  </div>

  <?php
  include('dbcon.php');

  if (isset($_GET['id'])) {
    $key_child = $_GET['id'];
    $ref_tbl = 'employee';
    $fetch_result = $database->getReference($ref_tbl)->getChild($key_child)->getValue();

    if ($fetch_result > 0) {
    } else {
    }
  } else {
    echo 'failed';
  }

  ?>

  <!-- Modal for Adding Employee -->
  <div class="modal fade show" id="myModal" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header d-flex justify-content-md-left">
          <img src="./assets/emp.gif" class="icon-heading">
          <h4 class="modal-title mt-1">Edit Employee</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form method="POST" autocomplete="off">
          <div class="modal-body">
            <div class="form-group modal-form">
              <span class="fa fa-user-plus ml-2"></span><label for="Password" class="ml-2">Full Name: </label>
              <input type="text" class="form-control" id="username" name="employee-name" value="<?= $name;
                                                                                                ?>" required="required">
            </div>

            <div class="form-group modal-form">
              <span class="fa fa-envelope ml-2"></span><label for="Password" class="ml-2">Email Address: </label>
              <input type="email" class="form-control" id="username" name="employee-email" required="required">
            </div>

            <div class="form-group modal-form">
              <span class="fa fa-phone ml-2"></span><label for="Password" class="ml-2">Contact Number: </label>
              <input type="text" class="form-control" id="username" name="employee-contact" required="required">
            </div>

            <div class="form-group modal-form">
              <span class="fa fa-calendar ml-2"></span><label for="Password" class="ml-2">Select Schedules: </label>
              <select class="form-control schedule-select" name="employee-schedule" id="sel1">
                <option selected>Click here to show</option>
                <option>Monday - Tuesday</option>
                <option>Wednesday - Thursday</option>
                <option>Thursday - Friday</option>
              </select>
            </div>

            <div class="form-group modal-form">
              <span class="fa fa-lock ml-2"></span><label for="Password" class="ml-2">Password: </label>
              <input type="password" class="form-control" id="username" name="employee-password" required="required">
            </div>
          </div>

          <div class="mb-4 text-center">
            <button type="submit" name="add-to-employee" class="btn btn-success btn-modal">Add to employee <i class="fa fa-angle-right" aria-hidden="true"></i></button>
          </div>
        </form>
      </div>
    </div>
  </div>





  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="./js/main.js"></script>
  <script>
    $(window).on('load', function() {
      var delayMs = 1000; // delay in milliseconds

      setTimeout(function() {
        $('#myModal').modal('show');
      }, delayMs);
    });
  </script>
</body>

</html>