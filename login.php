<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/gif" href="./assets/shortcut_icon.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/login.css">
    <title>TRENDZ: Login</title>
</head>

<body>
    <!--Body wrapper -->
    <div class="main-wrapper">
        <?php include './includes/authentication.php'; ?>
        <div class="col-md-4 form-container mx-auto">

            <a href="./dashboard.php">
                <h2 class="text-center">LOGIN</h2>
            </a>
            <p class="text-center">Welcome, Admin!</p>




            <form method="POST" autocomplete="off">
                <div class="form-group modal-form">
                    <span class="fa fa-user-plus ml-2"></span><label for="Password" class="ml-2">Email Address: </label>
                    <input type="text" class="form-control" id="username" name="admin-email" required="required">
                </div>

                <div class="form-group modal-form">
                    <span class="fa fa-user-plus ml-2"></span><label for="Password" class="ml-2">Password: </label>
                    <input type="password" class="form-control" id="admin-password" name="admin-password" required="required">
                </div>

                <div class="custom-control custom-switch ml-3 mb-4">
                    <input type="checkbox" class="custom-control-input" id="switch1">
                    <label class="custom-control-label" for="switch1">Show Password</label>
                </div>

                <div class="mb-4 text-center">
                    <a href="./dashboard.php"> <button type="submit" name="admin-login" class="btn btn-success btn-modal">LOGIN<i class="fa fa-angle-right" aria-hidden="true"></i></button></a>
                </div>


                <div class="text-center forgot-pass">
                    <a href="">Forgot Password?</a>
                </div>
            </form>
        </div>
    </div>






    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>