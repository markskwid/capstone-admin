<?php
  include './config/dbcon.php';
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
    <title>TRENDZ: Add Booking</title>
</head>
<body>
<form method="POST">
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
  </div>
  <button type="submit" name="submit" class="btn btn-primary">Submit</button>
</form>

 
  <table class="table table-hover table-striped text-center">
    <thead>
      <tr>
        <td>ID</td>
        <td>Email</td>
        <td>Password</td>
      </tr>
    </thead>

    <tbody>
      <?php
       
        $ref_table = 'sample';

        $fetchData = $database->getReference($ref_table) -> getValue();
        $ctr_id = 1;
        if($fetchData > 0){
          foreach($fetchData as $key => $row){
            ?>
            <tr>
              <td><?=$ctr_id++?></td>
              <td><?=$row['email']?></td>
              <td><?=$row['password']?></td>
              <td><button>Hello</button></td>
            </tr>

            <?php
            
          }

        }else{
          echo "no record found";
        }


      ?>
      <tr>
        <td></td>
      </tr>
    </tbody>
                  
  </table>

<?php
    
   
    if(isset($_POST['submit'])){
        $email = $_POST['email'];
        $password = $_POST['password'];

        $postData = [
            'email' => $email,
            'password' => $password
        ];

        $ref_table = 'sample';
        $postRef_result = $database->getReference($ref_table)->push($postData);

        if($postRef_result){
          
            header("location: practice.php");

        }else{

         
            echo "Failed";

        }
    }
?>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
  <script src="./js/main.js"></script>
 
</body>
</html>