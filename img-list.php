<?php
session_start();
if (isset($_POST['search-btn'])) {
  $typeSearch = '';
  $search_val = $_POST['search-customer'];
  $_SESSION['search-customer'] = $search_val;
  header("Location: ./img-list-search.php");
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
  <title>TRENDZ: Images</title>
</head>

<body>
  <div class="row main-wrapper">
    <?php include './includes/sidebar.php'; ?>

    <div id="main" class="content-wrapper">

      <div class="col-md-12 mx-auto heading d-flex justify-content-md-left">
        <img src="./assets/addimg_icon.png" class="icon-heading">
        <span>IMAGE LIST</span>
      </div>

      <?php include './includes/image-submit.php'; ?>
      <div id="content-wrapper" class="col-md-12 mx-auto content">
        <div class="row">
          <div class="container-fluid">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">+ Add Image</button>
            <button type="button" class="btn btn-primary ml-2" id="hide"> Show navigation</button>

            <div class="form-inline float-right">
              <form method="POST" autocomplete="off">
                <input type="text" class="form-control" name="search-customer" id="search" placeholder="Search Image">
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
                <th>Image</th>
                <th>Date Posted</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              include 'dbcon.php';
              $ref_table = 'gallery';
              $fetchData = $database->getReference($ref_table)->orderByChild('image_name')->getValue();
              if ($fetchData > 0) {
                foreach ($fetchData as $key => $row) {
              ?>
                  <tr>
                    <td><?= $row['image_name']; ?></td>
                    <td><img src='<?= $row['download_url']; ?>'></td>
                    <td><?= $row['image_posted']; ?></td>
                    <td hidden><?= $row['image_file']; ?></td>
                    <td hidden><?= $row['fulldate'] ?></td>
                    <td hidden><?= $row['image_name']; ?></td>
                    <td hidden><?= $row['image_description'] ?></td>
                    <td>

                      <form method="GET">

                        <button type='button' data-id="<?php echo $key; ?>" class='btn btn-primary mr-1 edit-btn' id='edit-button'><i class='fa fa-pencil fa-lg'></i></button>
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
            <p>Are you sure to put it in archive?
          </strong><br>The data can be restore again.</p>
        </div>

        <div class="text-center p-0">
          <form method="GET">
            <div class="row btn-row">
              <input type="hidden" value="" id="imgs-name" name="imgs-name">
              <input type="hidden" value="" id="imgs-date" name="imgs-date">
              <input type="hidden" value="" id="imgs-info-del" name="imgs-info-del">
              <input type="date" value="<?php echo date('Y-m-d'); ?>" name="imgs-fulldate" hidden>
              <button type="submit" name='confirm-btn' data-id="" value="" id="confirm-del" class='btn btn-success btn-confirmation'>CONFIRM</button>
              <button type='button' class='btn btn-danger btn-confirmation' class="close" data-dismiss="modal" id='edit-button'>CANCEL</button>
            </div>

          </form>

        </div>


      </div>
    </div>
  </div>


  <!-- Modal for Adding Employee -->
  <div class="modal fade" id="myModal" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header d-flex justify-content-md-left">
          <img src="./assets/addimg_icon.png" class="icon-heading">
          <h4 class="modal-title mt-1">Add Image</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form method="POST" autocomplete="off" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="form-group modal-form">
              <span class="fa fa-file-image-o ml-2"></span><label for="Password" class="ml-2">Image Name: </label>
              <input type="text" class="form-control" id="image-name" name="image-name" required="required">
            </div>

            <div class="form-group modal-form">
              <span class="fa fa-upload ml-2"></span><label for="Password" class="ml-2">Select Image: </label>
              <input type="file" name="image-file" id="">
            </div>


            <div class="form-group modal-form">
              <span class="fa fa-calendar-o ml-2"></span><label for="Password" class="ml-2">Date Posted: </label>
              <input type="text" class="form-control" id="username" name="image-posted" placeholder="<?php echo date('F d, Y'); ?>" disabled>
            </div>


            <div class=" form-group modal-form">
              <span class="fa fa-file-text ml-2"></span><label for="Password" class="ml-2">Description: </label>
              <textarea class="form-control" name="image-info" id="comment" placeholder="Write here the description..."></textarea>
            </div>
          </div>

          <div class="mb-1 mt-1 text-center">
            <button type="submit" name="add-to-gallery" class="btn btn-success btn-modal w-100">Add to Image <i class="fa fa-angle-right" aria-hidden="true"></i></button>
          </div>
      </div>
      </form>
    </div>
  </div>
  </div>


  <!-- ##################################### Modal for Editing Employee ################################################ -->
  <div class="modal fade" id="editImage" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header d-flex justify-content-md-left">
          <img src="./assets/addimg_icon.png" class="icon-heading">
          <h4 class="modal-title mt-1">Edit Image</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form method="POST" autocomplete="off" enctype="multipart/form-data">
          <div class="modal-body">
            <input type="hidden" id="image-update-id" value="" name="image-update-id">
            <input type="hidden" id="image-ext-file" value="" name="image-ext-file">
            <input type="hidden" id="image-ext-date" value="" name="image-ext-date">
            <input type="hidden" id="image-name-del" value="" name="image-name-del">

            <div class="form-group modal-form">
              <span class="fa fa-file-image-o ml-2"></span><label for="Password" class="ml-2">Image Name: </label>
              <input type="text" class="form-control" id="update-image-name" name="update-image-name" required="required">
            </div>

            <div class="form-group modal-form">
              <span class="fa fa-upload ml-2"></span><label for="Password" class="ml-2">Select Image: </label>
              <div class="input-file">
                <label id="file-chosen" name="update-label" class="file-chosen" for="">No chosen file</label>
                <input type="file" name="update-image-file" id="image-update-file">
              </div>
            </div>

            <div class="form-group modal-form">
              <span class="fa fa-calendar-o ml-2"></span><label for="Password" class="ml-2">Date Posted: </label>
              <input type="text" class="form-control" id="update-image-date" name="update-image-posted" disabled>
            </div>

            <div class=" form-group modal-form">
              <span class="fa fa-file-text ml-2"></span><label for="Password" class="ml-2">Description: </label>
              <textarea class="form-control " name="image-info" id="edit-comment-image" placeholder="Write here the description..."></textarea>
            </div>
          </div>


          <div class="mb-1 mt-4 text-center">
            <button type="submit" name="update-gallery" id="update-img" class="btn btn-success btn-modal w-100">Edit the Image <i class="fa fa-angle-right" aria-hidden="true"></i></button>
          </div>
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
        $('#editImage').modal('show');
        $tr = $(this).closest('tr');

        var data = $tr.children('td').map(function() {
          return $(this).text();
        }).get();
        const myArray = data[3].split("/");
        $('#image-update-id').val(data[0]);
        $('#update-image-name').val(data[0]);
        $('#update-image-date').val(data[2]);
        $('.file-chosen').text(myArray[4]);
        $('#image-ext-file').val(myArray[4]);
        $('#image-ext-date').val(data[2]);
        $('#image-name-del').val(data[5]);
        $('#edit-comment-image').val(data[6]);
      });

      $('.del-btn').on('click', function(e) {
        var id = $(this).attr('data-id');
        $tr = $(this).closest('tr');

        var data = $tr.children('td').map(function() {
          return $(this).text();
        }).get();

        $('#imgs-name').val(data[0]);
        $('#imgs-date').val(data[2]);
        $('#imgs-fulldate').val(data[4]);
        $('#imgs-info-del').val(data[6]);
        $('#confirm-del').attr('data-id', id);
        $('#confirm-del').attr('value', id);

      });

      $("#confirm-del").on('click', function(e) {
        var id = $(this).attr('data-id');

      });

      $('.edit-btn').on('click', function(e) {
        var id = $(this).attr('data-id');
        var fileName = $('.file-chosen').text();
        $('#image-update-id').attr('value', id);
      });

      $("#update-img").on('click', function(e) {
        var id = $(this).attr('value');
        var fileName = $('.file-chosen').text();
        console.log($('#image-update-id').attr('value'));
        console.log($('#image-update-file').attr('value'));
        console.log($('#image-ext-file').attr('value'));
      });
    });
  </script>
</body>

</html>