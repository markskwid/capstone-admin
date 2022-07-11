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
  <title>TRENDZ: Dashboard</title>
</head>

<body>
  <?php include 'dbcon.php'; ?>
  <div class="row main-wrapper">
    <?php include './includes/sidebar.php'; ?>

    <div id="main" class="content-wrapper">

      <div class="col-md-12 mx-auto heading d-flex justify-content-md-left">
        <img src="./assets/home_icon.png" class="icon-heading">
        <span>DASHBOARD</span>
      </div>

      <div id="content-wrapper" class="col-md-12 mx-auto content">
        <div class="row">
          <div class="container-sm text-center dashboard-container" id="total-emp">
            <img src="./assets/emp_icon.png" class="icon-dashboard">
            <h5>TOTAL EMPLOYEE</h5>
            <!-- TOTAL EMP -->
            <h2><?php echo $employee_total ?></h2>
          </div>

          <div class="container-sm text-center dashboard-container" id="total-book">
            <img src="./assets/history_icon.png" class="icon-dashboard">
            <h5>TOTAL BOOK</h5>
            <!-- TOTAL EMP -->
            <h2><?php echo $book_total ?></h2>
          </div>



          <div class="container-sm text-center dashboard-container" id="total-user">
            <img src="./assets/emp_icon.png" class="icon-dashboard">
            <h5>TOTAL USER</h5>
            <!-- TOTAL EMP -->
            <?php
            include 'dbcon.php';
            $users = $auth->listUsers();

            $i = 0;
            foreach ($users as $user) {
              $i++;
            }

            ?>
            <h2><?php echo $i ?></h2>
          </div>

          <div class="container-sm text-center dashboard-container" id="total-product">
            <img src="./assets/inv-icon.png" class="icon-dashboard">
            <h5>TOTAL PRODUCT</h5>
            <!-- TOTAL EMP -->
            <h2><?php echo $inventory_total ?></h2>
          </div>
        </div>

        <div class="row">
          <div class="container-md text-center">
            <h5 class="chart-month"><?php echo date('F'); ?></h5>
            <div id="piechart">
            </div>
          </div>

          <div class="container-md ">
            <h5>NOTIFICATIONS</h5>
            <div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert">&times;</button>

              <?php
              try {
                $fetchData = $database->getReference('reservation')->orderByKey()->limitToLast(1)->getValue();
              } catch (Exception $e) {
                echo $e->getMessage();
              }
              if ($fetchData > 0) {
                foreach ($fetchData as $key => $row) {
              ?>
                  <strong><?= $row['reserveBy_name']; ?> book an appointment on <?= $row['month']; ?> <?= $row['date']; ?>, <?= $row['year']; ?></strong>


              <?php
                }
              }
              ?>

            </div>

            <div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert">&times;</button>

              <?php
              try {
                $fetchData = $database->getReference('canceled_appointment')->orderByKey()->limitToLast(1)->getValue();
              } catch (Exception $e) {
                $e->getMessage();
              }

              if ($fetchData > 0) {
                foreach ($fetchData as $key => $row) {
              ?>
                  <strong><?= $row['reserveBy_name']; ?> canceled appointment on <?= $row['month']; ?> <?= $row['date']; ?>, <?= $row['year']; ?></strong>


              <?php
                }
              }

              ?>
            </div>

            <div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert">&times;</button>

              <?php
              try {
                $fetchData = $database->getReference('success_appointment')->orderByKey()->limitToLast(1)->getValue();
              } catch (Exception $e) {
                $e->getMessage();
              }

              if ($fetchData > 0) {
                foreach ($fetchData as $key => $row) {
              ?>
                  <strong><?= $row['servicedBy_name']; ?> successfully done a serviced on <?= $row['month']; ?> <?= $row['date']; ?>, <?= $row['year']; ?></strong>


              <?php
                }
              }

              ?>
            </div>


          </div>

        </div>
      </div>

    </div>

  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script>
    google.charts.load('current', {
      'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    // Draw the chart and set the chart values
    function drawChart() {
      const today = new Date()
      var successApp = '<?php echo $i; ?>'
      var canceledApp = '<?php echo $x; ?>'
      var tot = '<?php echo $totalBookMonth; ?>'
      var c = successApp * tot / 2;
      var a = canceledApp * tot / 2;
      var data = google.visualization.arrayToDataTable([
        ['Task', 'Customer per month'],
        ['SUCCESSFUL', c],
        ['CANCELED', a],
      ]);

      // Optional; add a title and set the width and height of the chart
      var options = {
        pieStartAngle: 100,
        is3D: true,
        backgroundColor: 'transparent',
        'width': 480,
        'height': 300,
        legend: {
          position: 'bottom'
        },
        titleTextStyle: {
          fontSize: 20
        }
      };

      // Display the chart inside the <div> element with id="piechart"
      var chart = new google.visualization.PieChart(document.getElementById('piechart'));
      chart.draw(data, options);
    }
  </script>
  <script src="./js/main.js"></script>

</body>

</html>