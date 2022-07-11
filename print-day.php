<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./css/main.css">
    <title>TRENDZ: History</title>
</head>

<body>

    <div id="main" class="content-wrapper text-center mx-auto">
        <div class="container-fluid" id="print-this">
            <table id="table-to-print" class="table table-hover table-striped text-center">
                <thead>
                    <th colspan="5">
                        <h3 class="salon-name">TRENDZ</h3>
                        <h5>Hair salon and Wellness Center</h5>
                        <p>Plaridel, Bulacan</p>
                        <h4>HISTORY REPORT</h4>
                        <p>Daily Report</p>
                        <h5><?php echo date('F d, Y'); ?></h5>

                    </th>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Date</th>
                        <th>Serviced by</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'dbcon.php';
                    try {

                        $fetchData = $database->getReference('success_appointment')->orderByChild('fulldate')->equalTo(date('Y-m-d'))->getValue();
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    ?>
                        <tr>
                            <td colspan="6">NO RECORD FOUND</td>
                        </tr>


                        <?php
                    }
                    $ref_table = 'success_appointment';

                    if ($fetchData > 0) {
                        foreach ($fetchData as $key => $row) {
                        ?>
                            <tr>
                                <td><?= $row['reserveBy_name']; ?></td>
                                <td><?= $row['reserveBy_email']; ?></td>
                                <td><?= $row['month']; ?> <?= $row['date']; ?>, <?= $row['year']; ?></td>
                                <td><?= $row['servicedBy_name']; ?></td>
                                <td><?= $row['time']; ?></td>
                                <td hidden><?= $row['reserveBy_id']; ?></td>

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




    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="./js/print.js"></script>

</body>

</html>