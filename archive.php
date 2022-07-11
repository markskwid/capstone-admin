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
    <title>TRENDZ: Archive</title>
</head>

<body>
    <?php include 'dbcon.php'; ?>
    <div class="row main-wrapper">
        <?php include './includes/sidebar.php'; ?>

        <div id="main" class="content-wrapper">

            <div class="col-md-12 mx-auto heading d-flex justify-content-md-left">
                <img src="./assets/archive.png" class="icon-heading">
                <span>ARCHIVE</span>
            </div>

            <div id="content-wrapper" class="col-md-12 mx-auto content">
                <a href="./employee-archive.php">
                    <div class="container-lg">
                        <div class="row">
                            <span class="fa fa-users icons-lg"></span>
                            <p class="display-label ml-3">Employee Archive</p>
                        </div>
                    </div>
                </a>

                <a href="./user-archive.php">
                    <div class="container-lg">
                        <div class="row">
                            <span class="fa fa-user-circle icons-lg"></span>
                            <p class="display-label ml-3">User Archive</p>
                        </div>
                    </div>
                </a>

                <a href="./image-archive.php">
                    <div class="container-lg">
                        <div class="row">
                            <span class="fa fa-image icons-lg"></span>
                            <p class="display-label ml-3">Image Archive</p>
                        </div>
                    </div>
                </a>

                <a href="./inventory-archive.php">
                    <div class="container-lg">
                        <div class="row">
                            <span class="fa fa-cube icons-lg"></span>
                            <p class="display-label ml-3">Product Archive</p>
                        </div>
                    </div>
                </a>


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
                var successApp = '<?php echo $success_total; ?>'
                var data = google.visualization.arrayToDataTable([
                    ['Task', 'Customer per month'],
                    ['SUCCESSFUL', successApp],
                    ['CANCELED', 2]
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