<?php
session_start();
$search_val = '';
$search_query = 'fullname';
if (isset($_SESSION['search-customer'])) {
    $search_val = $_SESSION['search-customer'];
    if (strpos($search_val, '@') !== false) {
        $search_query = 'email';
    } else {
        $search_query = 'fullname';
    }
}


if (isset($_POST['search-btn'])) {
    $typeSearch = '';
    $search_val = $_POST['search-customer'];
    $_SESSION['search-customer'] = $search_val;
    header("Location: ./user-search.php");
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
    <title>TRENDZ: Users</title>
</head>

<body>
    <div class="row main-wrapper">
        <?php include './includes/sidebar.php'; ?>

        <div id="main" class="content-wrapper">

            <div class="col-md-12 mx-auto heading d-flex justify-content-md-left">
                <img src="./assets/manage_icon.png" class="icon-heading">
                <span>MANAGE CLIENT</span>
            </div>

            <?php include('./includes/user-submit.php'); ?>
            <div id="content-wrapper" class="col-md-12 mx-auto content">
                <div class="row">
                    <div class="container-fluid">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">+ Add User</button>
                        <button type="button" class="btn btn-primary ml-2" id="hide"> Show navigation</button>
                        <div class="form-inline float-right">
                            <form method="POST" autocomplete="off">
                                <input type="text" class="form-control" name="search-customer" id="search" placeholder="Search User">
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
                                <th>Address</th>
                                <th>Contact</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <?php
                            include 'dbcon.php';
                            $ref_table = 'information';
                            $fetchData = $database->getReference($ref_table)->orderByChild($search_query)->equalTo(trim($search_val))->getValue();
                            $i = 1;
                            if ($fetchData > 0) {
                                foreach ($fetchData as $key => $row) {

                            ?>

                                    <tr>
                                        <td hidden><?= $key ?></td>
                                        <td hidden><?= $row['customer_id']; ?></td>

                                        <td><?= $row['fullname']; ?></td>
                                        <td><?= $row['email']; ?></td>
                                        <td><?= $row['customer_address']; ?></td>
                                        <td><?= $row['customer_phone']; ?></td>
                                        <td>
                                            <form method="GET">
                                                <button type='button' data-id="<?php echo $key; ?>" value='' class='btn btn-primary mr-1 edit-btn' id='edit-button'><i class='fa fa-pencil fa-lg'></i></button>
                                                <button type='button' data-id="<?php echo $key; ?>" value='' name='delete-btn' class='btn btn-primary del-btn' data-toggle="modal" data-target="#confirmation"><i class='fa fa-archive fa-lg'></i></button>
                                            </form>
                                        </td>
                                    </tr>

                            <?php
                                }
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
                    </strong><br>The data can be restore again.</p>
                </div>

                <div class="text-center p-0">
                    <form method="GET">
                        <input type="hidden" value="" id="emps-name" name="emps-name">
                        <input type="hidden" value="" id="emps-email" name="emps-email">
                        <input type="hidden" value="" id="emps-contact" name="emps-contact">
                        <input type="hidden" value="" id="emps-password" name="emps-password">
                        <input type="hidden" value="" id="emps-address" name="emps-address">
                        <input type="hidden" value="" id="emps-uid" name="emps-uid">
                        <input type="hidden" value="" id="emps-id" name="emps-id">
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
                    <h4 class="modal-title mt-1">Add User</h4>
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
                            <span class="fa fa-address-card-o ml-2"></span><label for="Password" class="ml-2">Home Address: </label>
                            <input type="text" class="form-control" id="username" name="employee-address" required="required">
                        </div>

                        <div class="form-group modal-form">
                            <span class="fa fa-lock ml-2"></span><label for="Password" class="ml-2">Password: </label>
                            <input type="password" class="form-control" id="username" name="employee-password" required="required">
                        </div>
                    </div>

                    <div class="mb-4 text-center">
                        <button type="submit" name="add-to-employee" class="btn btn-success btn-modal">Add to user <i class="fa fa-angle-right" aria-hidden="true"></i></button>
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
                    <h4 class="modal-title mt-1">Edit User</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form method="POST" autocomplete="off">
                    <div class="modal-body">
                        <input type="hidden" id="emp-id" value="" name="update-id">
                        <input type="hidden" id="emp-uid" value="" name="update-uid">

                        <div class="form-group modal-form">
                            <span class="fa fa-user-plus ml-2"></span><label for="Password" class="ml-2">Full Name: </label>
                            <input type="text" class="form-control" id="emp-name" name="update-name" required="required">
                        </div>

                        <div class="form-group modal-form">
                            <span class="fa fa-envelope ml-2"></span><label for="Password" class="ml-2">Email Address: </label>
                            <input type="email" class="form-control" id="emp-email" name="update-email" required="required">
                        </div>

                        <div class="form-group modal-form">
                            <span class="fa fa-address-card-o ml-2"></span><label for="Password" class="ml-2">Home Address: </label>
                            <input type="text" class="form-control" id="emp-address" name="update-address" required="required">
                        </div>

                        <div class="form-group modal-form">
                            <span class="fa fa-address-card-o ml-2"></span><label for="Password" class="ml-2">Contact: </label>
                            <input type="text" class="form-control" id="emp-contact" name="update-contact" required="required">
                        </div>


                        <div class="form-group modal-form">
                            <span class="fa fa-lock ml-2"></span><label for="Password" class="ml-2">New Password: </label>
                            <input type="password" class="form-control" id="emp-password" name="update-password" required="required">
                        </div>
                    </div>

                    <div class="mb-4 text-center">
                        <button type="submit" name="update-employee" value="" id="update-employee" class="btn btn-success btn-modal">Update this user <i class="fa fa-angle-right" aria-hidden="true"></i></button>
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
                $('#emp-uid').val(data[1]);

                $('#emp-name').val(data[2]);
                $('#emp-email').val(data[3]);
                $('#emp-address').val(data[4]);
                $('#emp-contact').val(data[5]);
                $('#emp-password').val('');
            });

            $('.del-btn').on('click', function(e) {
                var id = $(this).attr('data-id');
                $tr = $(this).closest('tr');

                var data = $tr.children('td').map(function() {
                    return $(this).text();
                }).get();

                $('#emps-id').val(data[0]);
                $('#emps-uid').val(data[1]);

                $('#emps-name').val(data[2]);
                $('#emps-email').val(data[3]);
                $('#emps-address').val(data[4]);
                $('#emps-contact').val(data[5]);
                $('#emps-password').val('trendzpassword');

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