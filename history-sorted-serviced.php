<?php
session_start();
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
    <title>TRENDZ: History</title>
</head>

<body>
    <div class="row main-wrapper">
        <?php include './includes/sidebar.php'; ?>

        <div id="main" class="content-wrapper">

            <div class="col-md-12 mx-auto heading d-flex justify-content-md-left">
                <img src="./assets/history_icon2.png" class="icon-heading">
                <span>HISTORY</span>
            </div>

            <?php include('./includes/history-submit.php'); ?>
            <div id="content-wrapper" class="col-md-12 mx-auto content">
                <div class="row">
                    <div class="container-fluid">
                        <button type="button" class="btn btn-primary ml-2" id="hide"> Show navigation</button>
                        <div class='form-inline float-left ml-1' id="sort-pick">
                            <select class="form-control sort-data" id="sort-data" onchange="location = this.value;" name="sort-data">
                                <option value="./history.php">Sort by name</option>

                                <option value="./history-sorted.php">Sort by date</option>
                                <option selected>Sort by serviced by</option>
                            </select>
                        </div>
                        <div class="form-inline float-right">
                            <input type="text" class="form-control" id="search" placeholder="Search Customer">
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
                                <th>Type</th>
                                <th>Serviced By</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include 'dbcon.php';
                            try {
                                $fetchData = $database->getReference('success_appointment')->orderByChild('servicedBy_name')->getValue();
                            } catch (Exception $e) {
                                echo $e->getMessage();
                            }
                            $ref_table = 'success_appointment';

                            if ($fetchData > 0) {
                                foreach ($fetchData as $key => $row) {
                            ?>
                                    <tr>
                                        <td><?= $row['reserveBy_name']; ?></td>
                                        <td><?= $row['reserveBy_email']; ?></td>
                                        <td><?= preg_replace("/[\s_]/", ", ", trim($row['type'])); ?></td>
                                        <td><?= $row['servicedBy_name']; ?></td>
                                        <td><?= $row['month']; ?> <?= $row['date']; ?>, <?= $row['year']; ?></td>
                                        <td><?= $row['time']; ?></td>
                                        <td hidden><?= $row['reserveBy_id']; ?></td>
                                        <td>

                                            <form method="GET">
                                                <button type='button' data-id="<?php echo $key; ?>" name='delete-btn' class='btn btn-primary del-btn' data-toggle="modal" data-target="#confirmation"><i class='fa fa-archive fa-lg'></i></button>
                                            </form>


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
                        <p>Are you sure you want to delete?
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


    <!-- Modal for Adding Employee -->
    <div class="modal fade" id="myModal" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-md-left">
                    <img src="./assets/emp.gif" class="icon-heading">
                    <h4 class="modal-title mt-1">Add Employee</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form method="POST" autocomplete="off">
                    <div class="modal-body">
                        <div class="form-group modal-form">
                            <span class="fa fa-user-plus ml-2"></span><label for="Password" class="ml-2">Full Name: </label>
                            <input type="text" class="form-control" id="username" name="employee-name" required="required">
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
                                <option>Saturday - Sunday</option>
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






    <!-- Modal for Editing Employee -->
    <div class="modal fade" id="editModal" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-md-left">
                    <img src="./assets/emp.gif" class="icon-heading">
                    <h4 class="modal-title mt-1">Edit Employee</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form method="POST" autocomplete="off">
                    <div class="modal-body">
                        <input type="hidden" id="emp-id" value="" name="update-id">
                        <div class="form-group modal-form">
                            <span class="fa fa-user-plus ml-2"></span><label for="Password" class="ml-2">Full Name: </label>
                            <input type="text" class="form-control" id="emp-name" name="update-name" required="required">
                        </div>

                        <div class="form-group modal-form">
                            <span class="fa fa-envelope ml-2"></span><label for="Password" class="ml-2">Email Address: </label>
                            <input type="email" class="form-control" id="emp-email" name="update-email" required="required">
                        </div>

                        <div class="form-group modal-form">
                            <span class="fa fa-phone ml-2"></span><label for="Password" class="ml-2">Contact Number: </label>
                            <input type="text" class="form-control" id="emp-contact" name="update-contact" required="required">
                        </div>

                        <div class="form-group modal-form">
                            <span class="fa fa-calendar ml-2"></span><label for="Password" class="ml-2">Select Schedules: </label>
                            <select class="form-control schedule-select" name="update-schedule" id="emp-schedule">
                                <option selected>Click here to show</option>
                                <option>Monday - Tuesday</option>
                                <option>Wednesday - Thursday</option>
                                <option>Thursday - Friday</option>
                            </select>
                        </div>

                        <div class="form-group modal-form">
                            <span class="fa fa-lock ml-2"></span><label for="Password" class="ml-2">Password: </label>
                            <input type="password" class="form-control" id="emp-password" name="update-password" required="required">
                        </div>
                    </div>

                    <div class="mb-4 text-center">
                        <button type="submit" name="update-employee" value="" id="update-employee" class="btn btn-success btn-modal">Update this employee <i class="fa fa-angle-right" aria-hidden="true"></i></button>
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
                $('#emp-schedule').val(data[3]);
                $('#emp-password').val(data[4]);
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