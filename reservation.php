<?php
session_start();

if (isset($_POST['search-btn'])) {
    $typeSearch = '';
    $search_val = $_POST['search-customer'];
    $_SESSION['search-customer'] = $search_val;
    header("Location: ./reservation-search.php");
}
?>
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
    <title>TRENDZ: Reservation</title>
</head>

<body>
    <div class="row main-wrapper">
        <?php include './includes/sidebar.php'; ?>

        <div id="main" class="content-wrapper">

            <div class="col-md-12 mx-auto heading d-flex justify-content-md-left">
                <img src="./assets/appoint_icon.png" class="icon-heading">
                <span>RESERVATION LIST</span>
            </div>

            <?php include('./includes/reservation-submit.php'); ?>
            <div id="content-wrapper" class="col-md-12 mx-auto content">
                <div class="row">
                    <div class="container-fluid">
                        <button type="button" class="btn btn-primary ml-2" id="hide"> Show navigation</button>
                        <div class='form-inline float-left ml-1' id="sort-pick">
                            <select class="form-control sort-data" id="sort-data" onchange="location = this.value;" name="sort-data">
                                <option selected>Sort by name</option>

                                <option value="./reservation-sorted.php">Sort by date</option>


                            </select>
                        </div>
                        <div class="form-inline float-right">
                            <form method="POST" autocomplete="off">
                                <input type="text" class="form-control" name="search-customer" id="search" placeholder="Search Customer">
                                <button type="submit" name="search-btn" class="btn btn-primary search">
                                    <img src="./assets/search_icon.png" alt="" class="icon-search">
                                </button>
                            </form>
                        </div>
                    </div>


                    <table class="table table-hover table-striped text-center">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <?php
                            include 'dbcon.php';
                            $ref_table = 'reservation';
                            $fetchData = $database->getReference($ref_table)->orderByChild('reserveBy_name')->getValue();
                            //$dt = '2017-Feb-10';
                            //<td><?= date('Y-m-d', strtotime($dt)); </td>
                            if ($fetchData > 0) {
                                foreach ($fetchData as $key => $row) {
                            ?>
                                    <tr>

                                        <td><?= $row['reserveBy_name']; ?></td>
                                        <td><?= $row['reserveBy_email']; ?></td>
                                        <td><?= $row['reserveBy_contact']; ?></td>
                                        <td><?= $row['month']; ?> <?= $row['date']; ?>, <?= $row['year']; ?></td>
                                        <td><?= $row['time']; ?></td>
                                        <td hidden><?= $row['fulldate']; ?></td>
                                        <td hidden><?= trim($row['type']); ?></td>
                                        <td hidden><?= $row['month']; ?></td>
                                        <td hidden><?= $row['date']; ?></td>
                                        <td hidden><?= $row['day']; ?></td>
                                        <td hidden><?= $row['year']; ?></td>
                                        <td hidden><?= $row['reserveBy_id']; ?></td>

                                        <td>
                                            <div class="row">
                                                <form method="GET">
                                                    <button type='button' data-id="<?php echo $key; ?>" class='btn btn-primary mr-1 edit-btn' id='edit-button'><i class='fa fa-check fa-lg'></i></button>
                                                    <button type='button' data-id="<?php echo $key; ?>" name='delete-btn' class='btn btn-primary del-btn' data-toggle="modal" data-target="#confirmation"><i class='fa fa-archive fa-lg'></i></button>
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

    <div class="modal fade" id="confirmation">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal body -->
                <div class="modal-body text-center">
                    <img src="./assets/trash_icon.png" class="mx-auto d-block mb-2" width="100px" height="100px">
                    <strong>
                        <p>Are you sure to put it in archive?
                    </strong><br>The data cannot be restore again.</p>
                </div>

                <div class="text-center p-0">
                    <form method="GET">
                        <div class="row btn-row">
                            <button type="submit" name='confirm-btn' data-id="" value="" id="confirm-del" class='btn btn-success btn-confirmation'>CONFIRM</button>
                            <button type='button' class='btn btn-danger btn-confirmation' class="close" data-dismiss="modal" id='edit-button'>CANCEL</button>
                        </div>

                    </form>

                </div>


            </div>
        </div>
    </div>



    <!-- The Modal -->
    <!-- Modal for Editing Employee -->
    <div class="modal fade" id="editModal" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-md-left">
                    <img src="./assets/emp.gif" class="icon-heading">
                    <h4 class="modal-title mt-1">Confirm Appointment</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form method="POST" autocomplete="off">
                    <div class="modal-body">
                        <input type="hidden" id="emp-id" value="" name="update-id">
                        <input type="hidden" id='month' name="month">
                        <input type="hidden" id='date' name="date">
                        <input type="hidden" id='day' name="day">
                        <input type="hidden" id='year' name="year">
                        <input type="hidden" id="reserveBy" name="reserveBy">
                        <div class="form-group modal-form">
                            <span class="fa fa-user-plus ml-2"></span><label for="Password" class="ml-2">Full Name: </label>
                            <input type="text" class="form-control" id="emp-name" name="update-name" readonly="readonly">
                        </div>

                        <div class="form-group modal-form">
                            <span class="fa fa-envelope ml-2"></span><label for="Password" class="ml-2">Email Address: </label>
                            <input type="email" class="form-control" id="emp-email" name="update-email" readonly="readonly">
                        </div>

                        <div class="form-group modal-form">
                            <span class="fa fa-phone ml-2"></span><label for="Password" class="ml-2">Contact Number: </label>
                            <input type="text" class="form-control" id="emp-contact" name="update-contact" readonly="readonly">
                        </div>

                        <div class="form-group modal-form">
                            <span class="fa fa-calendar ml-2"></span><label for="Password" class="ml-2">Select Service: </label>
                            <select class="form-control schedule-select" name="update-service" id="book-service" readonly="readonly">
                                <option>Hair</option>
                                <option>Nail</option>
                                <option>Eyelashes</option>
                                <option>Nail Hair</option>
                                <option>Nail Eyelashes</option>
                                <option>Nail Hair Eyelashes</option>
                                <option>Hair Eyelashes</option>
                                <option>Eyelashes Nail</option>
                            </select>
                        </div>

                        <div class="form-group modal-form">
                            <span class="fa fa-calendar ml-2"></span><label for="Password" class="ml-2">Select Time: </label>
                            <select class="form-control schedule-select" name="update-time" id="emp-schedule" readonly="readonly">
                                <option>Click here to show</option>
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


                        <div class="form-group modal-form">
                            <span class="fa fa-calendar ml-2"></span><label for="Password" class="ml-2">Select the Date: </label>
                            <input type="date" class="form-control" id="book-date" name="update-date" readonly="readonly">
                        </div>
                    </div>

                    <div class="mb-4 text-center">
                        <button type="submit" name="update-reservation" value="" id="update-employee" class="btn btn-success btn-modal">Confirm as done <i class="fa fa-angle-right" aria-hidden="true"></i></button>
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
        $(document).ready(function() {
            $('.edit-btn').click(function() {
                $('#editModal').modal('show');
                $tr = $(this).closest('tr');

                var data = $tr.children('td').map(function() {
                    return $(this).text();
                }).get();

                $('#emp-id').val(data[0]);
                $('#emp-name').val(data[0]);
                $('#emp-email').val(data[1]);
                $('#emp-contact').val(data[2]);
                $('#emp-schedule').val(data[4]);
                $('#book-service').val(data[6]);
                $('#book-date').val(data[5]);
                $('#month').val(data[7]);
                $('#date').val(data[8]);
                $('#day').val(data[9]);
                $('#year').val(data[10]);
                $('#reserveBy').val(data[11]);
            });

            $('.del-btn').on('click', function(e) {
                var id = $(this).attr('data-id');
                $('#confirm-del').attr('data-id', id);
                $('#confirm-del').attr('value', id);

            });
            $("#confirm-del").on('click', function(e) {
                var id = $(this).attr('data-id');

            });

            $('.edit-btn').on('click', function(e) {
                var id = $(this).attr('data-id');
                $('#emp-id').attr('value', id);
                $('#update-employee').attr('value', id);
            });

            $("#update-employee").on('click', function(e) {
                var id = $(this).attr('value');
                console.log($('#emp-id').attr('value'));
                console.log($('#update-employee').attr('value'));

            });

        });
    </script>
</body>

</html>