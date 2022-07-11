<?php
session_start();
$search_val = '';
$search_query = 'employee_name';
if (isset($_SESSION['search-customer'])) {
    $search_val = $_SESSION['search-customer'];
    if (strpos($search_val, '@') !== false) {
        $search_query = 'employee_email';
    } else {
        $search_query = 'employee_name';
    }
}


if (isset($_POST['search-btn'])) {
    $typeSearch = '';
    $search_val = $_POST['search-customer'];
    $_SESSION['search-customer'] = $search_val;
    header("Location: ./employee-archive-search.php");
}

?>
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
    <div class="row main-wrapper">
        <?php include './includes/sidebar.php'; ?>

        <div id="main" class="content-wrapper">

            <div class="col-md-12 mx-auto heading d-flex justify-content-md-left">
                <img src="./assets/inv-icon.png" class="icon-heading">
                <span>USER ARCHIVE</span>
            </div>
            <?php include './includes/a-employee-submit.php'; ?>
            <div id="content-wrapper" class="col-md-12 mx-auto content">
                <div class="row">
                    <div class="container-fluid">
                        <div class='form-inline float-left ml-1' id="sort-pick">
                            <select class="form-control sort-data" id="sort-data" onchange="location = this.value;" name="sort-data">
                                <option selected>Sort by name</option>

                                <option value="./employee-archive-sorted-date.php">Sort by date deleted</option>
                            </select>
                        </div>
                        <div class="form-inline float-right">
                            <form method="POST" autocomplete="off">
                                <input type="text" class="form-control" name="search-customer" id="search" placeholder="Search Employee">
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
                                <th>Contact</th>
                                <th>Schedule</th>
                                <th>Date Deleted</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tbody class="tbody">
                            <?php
                            include 'dbcon.php';
                            $ref_table = 'archive_employee';
                            $fetchData = $database->getReference($ref_table)->orderByChild($search_query)->equalTo($search_val)->getValue();
                            if ($fetchData > 0) {
                                foreach ($fetchData as $key => $row) {
                            ?>
                                    <tr>
                                        <td hidden><?= $key; ?></td>
                                        <td><?= $row['employee_name']; ?></td>
                                        <td><?= $row['employee_email']; ?></td>
                                        <td><?= $row['employee_contact']; ?></td>
                                        <td><?= $row['employee_schedule']; ?></td>
                                        <td><?= $row['date_deleted']; ?></td>

                                        <td>
                                            <div class="row">
                                                <form method="GET">
                                                    <button type='button' data-id="<?php echo $key; ?>" name='delete-btn' class='btn btn-primary del-btn restore' id="restore" data-toggle="modal" data-target="#confirmation">Restore</button>
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


    <!-- ####################################### DELETE ################################## -->

    <div class="modal fade" id="confirmation">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal body -->
                <div class="modal-body text-center">
                    <img src="./assets/trash_icon.png" class="mx-auto d-block mb-2" width="100px" height="100px">
                    <strong>
                        <p>Are you sure you want to restore the data?
                    </strong><br>This operation cannot be canceled.</p>
                </div>

                <div class="text-center p-0">
                    <form method="GET">
                        <div class="row btn-row">
                            <input type="hidden" value="" id="emps-name" name="emps-name">
                            <input type="hidden" value="" id="emps-email" name="emps-email">
                            <input type="hidden" value="" id="emps-sched" name="emps-sched">
                            <input type="hidden" value="" id="emps-contact" name="emps-contact">
                            <input type="hidden" value="" id="emps-password" name="emps-password">
                            <button type="submit" name='confirm-btn' data-id="" value="" id="confirm-del" class='btn btn-success btn-confirmation'>CONFIRM</button>
                            <button type='button' class='btn btn-danger btn-confirmation' class="close" data-dismiss="modal" id='edit-button'>CANCEL</button>
                        </div>

                    </form>

                </div>


            </div>
        </div>
    </div>


    <div class="modal fade" id="myModal" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-md-left">
                    <img src="./assets/box.gif" class="icon-heading">
                    <h4 class="modal-title mt-1">Add Product</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form enctype="multipart/form-data" method="POST" autocomplete="off">
                    <div class="modal-body">
                        <div class="form-group modal-form">
                            <span class="fa fa-product-hunt ml-2"></span><label for="Password" class="ml-2">Product Name: </label>
                            <input type="text" class="form-control" id="username" name="product-name" required="required">
                        </div>

                        <div class="form-group modal-form">
                            <span class="fa fa-upload ml-2"></span><label for="Password" class="ml-2">Select Image: </label>
                            <input type="file" name="product-file" id="" value="Select file">

                        </div>

                        <div class="form-group modal-form">
                            <span class="fa  fa-sort-amount-desc ml-2"></span><label for="Password" class="ml-2">Item Quantity: </label>
                            <input type="text" class="form-control" id="username" name="product-quantity" required="required">
                        </div>

                    </div>

                    <div class="mb-3 text-center">
                        <button type="submit" name="add-to-inventory" class="btn btn-success btn-modal">Add to Inventory <i class="fa fa-angle-right" aria-hidden="true"></i></button>
                    </div>
            </div>
            </form>
        </div>
    </div>

    <!-- ####################################### EDITING ################################## -->
    <div class="modal fade" id="editProductModal" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-md-left">
                    <img src="./assets/box.gif" class="icon-heading">
                    <h4 class="modal-title mt-1">Edit Product</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form enctype="multipart/form-data" method="POST" autocomplete="off">
                    <div class="modal-body">
                        <div class="form-group modal-form">
                            <input type="hidden" id="prod-update-id" value="" name="prod-update-id">
                            <input type="hidden" id="prod-ext-file" value="" name="prod-ext-file">
                            <span class="fa fa-product-hunt ml-2"></span><label for="Password" class="ml-2">Product Name: </label>
                            <input type="text" class="form-control" id="prod-update-name" name="update-product-name" required="required">
                        </div>

                        <div class="form-group modal-form">
                            <span class="fa fa-upload ml-2"></span><label for="Password" class="ml-2">Select Image: </label>
                            <div class="input-file">
                                <label id="file-chosen" name="update-label" class="file-chosen" for="">No chosen file</label>
                                <input type="file" name="update-product-file" id="prod-update-file">
                            </div>
                        </div>

                        <div class="form-group modal-form">
                            <span class="fa  fa-sort-amount-desc ml-2"></span><label for="Password" class="ml-2">Item Quantity: </label>
                            <input type="text" class="form-control" id="prod-update-quantity" name="update-product-quantity" required="required">
                        </div>

                    </div>

                    <div class="mb-3 text-center">
                        <button type="submit" id="update-inv" name="update-inventory" class="btn btn-success btn-modal">Update the product <i class="fa fa-angle-right" aria-hidden="true"></i></button>
                    </div>
            </div>
            </form>
        </div>
    </div>




    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="./js/main.js"></script>
    <script>
        $(document).ready(function() {
            $('.edit-btn').click(function() {
                $('#editProductModal').modal('show');
                $tr = $(this).closest('tr');
                var fileName = $('.file-chosen').text();
                var file = $('#prod-update-file').val();
                var data = $tr.children('td').map(function() {
                    return $(this).text();
                }).get();

                $('#prod-update-id').val(data[0]);
                $('#prod-update-name').val(data[0]);
                $('#prod-update-quantity').val(data[2]);
                const myArray = data[3].split("/");

                $('#prod-update-file-new').val(fileName);
                $('.file-chosen').text(myArray[4]);
                $('#prod-ext-file').val(myArray[4]);


            });


            $('.del-btn').on('click', function(e) {
                var id = $(this).attr('data-id');
                $tr = $(this).closest('tr');

                var data = $tr.children('td').map(function() {
                    return $(this).text();
                }).get();

                $('#emps-id').val(data[0]);
                $('#emps-name').val(data[1]);
                $('#emps-email').val(data[2]);
                $('#emps-sched').val(data[4]);
                $('#emps-contact').val(data[3]);
                $('#emps-password').val('trendzpassword');

                $('#confirm-del').attr('data-id', id);
                $('#confirm-del').attr('value', id);

            });
            $("#confirm-del").on('click', function(e) {
                var id = $(this).attr('data-id');

            });

            $('.edit-btn').on('click', function(e) {
                var id = $(this).attr('data-id');
                var fileName = $('.file-chosen').text();
                $('#prod-update-id').attr('value', id);
            });

            $("#update-inv").on('click', function(e) {
                var id = $(this).attr('value');
                var fileName = $('.file-chosen').text();
                console.log($('#prod-update-id').attr('value'));
            });

        });
    </script>
</body>

</html>