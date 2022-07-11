<?php
include 'dbcon.php';

use Google\Cloud\Core\ServiceBuilder;
use Google\Cloud\Storage\StorageClient;

if (isset($_POST['add-to-gallery'])) {
  $image_name = $_POST['image-name'];
  $image_posted = date('F d, Y');
  $fulldate = date("y-m-d");
  $alert = '';

  // image part
  $image_file = $_FILES['image-file'];

  $image_fileName = $_FILES['image-file']['name'];
  $image_tmpName = $image_file['tmp_name'];
  $image_error = $image_file['error'];
  $image_description = $_POST['image-info'];

  $image_fileExt = explode('.', $image_fileName);
  $image_fileActualExt = strtolower(end($image_fileExt));

  $allowed = array('jpg', 'jpeg', 'png');

  if (in_array($image_fileActualExt, $allowed)) {
    if ($image_error === 0) {
      $bucketName = 'trendz-ph.appspot.com';
      $storage = new StorageClient();
      $storage = $cloud->storage();
      $bucket = $storage->bucket($bucketName);

      // delete code
      // $delName = 'gallery/salon.png';
      // $delMe = $bucket->object($delName);
      // $delMe->delete();

      $object = $bucket->upload(fopen($image_file['tmp_name'], 'r'),  [
        'name' => "gallery/" . $image_name,
        'metadata' => [
          'contentType' => 'image/jpeg',
        ],
        'predefinedAcl' => 'publicRead',
      ]);

      $file_newName = uniqid('', true) . "." . $image_fileActualExt;
      $file_destination = "./assets/uploads/gallery/" . $file_newName;
      move_uploaded_file($image_tmpName, $file_destination);

      $publicUrl = "https://{$bucket->name()}.storage.googleapis.com/{$object->name()}";

      $postData = [
        'image_name' => $image_name,
        'image_file' => $file_destination,
        'image_posted' => $image_posted,
        'download_url' => $publicUrl,
        'fulldate' => $fulldate,
        'image_description' => $image_description
      ];

      $ref_table = 'gallery';
      $postRef_result = $database->getReference($ref_table)->push($postData);

      if ($postRef_result) {
        echo $alert = '<div class="alert alert-success alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
                    <strong>New image has been added!</strong>
                  </div>';
      } else {
        echo $alert = '<div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
                    <strong>Failed to add the image!</strong>
                  </div>';
      }
    } else {
      echo  "<div class='alert alert-warning alert-dismissible fade show'>
                <button type='button' class='close' data-dismiss='alert'><i class='fa fa-window-close' aria-hidden='true'></i></button>
                <strong>There's an error uploading the image. Please, try again!</strong>
                </div>";
    }
  } else {
    echo  '<div class="alert alert-warning alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
            <strong>The file uploaded is not an image file. Please, try again!</strong>
            </div>';
  }
}
?>

<?php
include 'dbcon.php';

if (isset($_GET['confirm-btn'])) {
  $del_id = $_GET['confirm-btn'];
  $alert_image = '';

  $img_name = $_GET['imgs-name'];
  $img_date = $_GET['imgs-date'];
  $fulldate = $_GET['imgs-fulldate'];
  $image_description = $_GET['imgs-info-del'];
  $storage = new StorageClient([
    'keyFilePath' => './config/trendz-ph-firebase-adminsdk-229z9-86a489b52e.json',
  ]);
  $bucketName = 'trendz-ph.appspot.com';
  $bucket = $storage->bucket($bucketName);
  $object = $bucket->object("gallery/" . $img_name);
  $getmine = $object->copy($bucketName, ['name' =>  "folder/" . $img_name]);
  $urlDownload = "https://{$bucket->name()}.storage.googleapis.com/{$getmine->name()}";

  $postData = [
    'image_name' => $img_name,
    'image_posted' => $img_date,
    'download_url' => $urlDownload,
    'date_deleted' => trim($fulldate),
    'image_description' =>  $image_description
  ];

  $ref_tbl = 'gallery/' . $del_id;
  $del_result = $database->getReference($ref_tbl)->remove();
  $ref_table = 'archive_gallery';

  if ($del_result) {
    $postRef_result = $database->getReference($ref_table)->push($postData);
    $object->delete();
    if ($postRef_result) {
      echo $alert_image = '<div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
      <i class="fa fa-check mr-1" aria-hidden="true"></i><strong>Image has been deleted!</strong>
    </div>';
    } else {
      echo $alert_image = '<div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
          <i class="fa fa-exclamation-triangle" aria-hidden="true"></i><strong>Image failed to delete!</strong>
        </div>';
    }
  } else {
    echo $alert_image = '<div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
          <i class="fa fa-exclamation-triangle" aria-hidden="true"></i><strong>Image failed to delete!</strong>
        </div>';
  }
}


//// update
if (isset($_POST['update-gallery'])) {
  if ($_FILES['update-image-file']['size'] > 1) {
    $key_child = $_POST['image-update-id'];
    $ref_tbl = 'gallery';
    $alert_update = '';

    $fetch_result = $database->getReference($ref_tbl)->getChild($key_child)->getValue();

    $new_name = $_POST['update-image-name'];
    $new_file = $_FILES['update-image-file'];
    $date = $_POST['image-ext-date'];
    $name_del = $_POST['image-name-del'];
    $fulldate = date('Y-m-d');
    $image_description = $_POST['image-info'];

    $bucketName = 'trendz-ph.appspot.com';
    $storage = new StorageClient();
    $storage = $cloud->storage();
    $bucket = $storage->bucket($bucketName);

    $delete_me_name = 'gallery/' . $name_del;

    $NewObject = $bucket->upload(fopen($new_file['tmp_name'], 'r'),  [
      'name' => "gallery/" . $new_name,
      'metadata' => [
        'contentType' => 'image/jpeg',
      ],
      'predefinedAcl' => 'publicRead',
    ]);

    $urlDownload = "https://{$bucket->name()}.storage.googleapis.com/{$NewObject->name()}";

    // image part
    $prod_file = $_FILES['update-image-file'];

    $image_fileName = $_FILES['update-image-file']['name'];
    $image_tmpName = $prod_file['tmp_name'];
    $image_error =  $prod_file['error'];

    $image_fileExt = explode('.', $image_fileName);
    $image_fileActualExt = strtolower(end($image_fileExt));

    $allowed = array('jpg', 'jpeg', 'png');

    if (in_array($image_fileActualExt, $allowed)) {
      if ($image_error === 0) {
        $file_newName = uniqid('', true) . "." . $image_fileActualExt;
        $file_destination = "./assets/uploads/gallery/" . $file_newName;
        move_uploaded_file($image_tmpName, $file_destination);
        $updateData = [
          'download_url' => $urlDownload,
          'image_name' => $new_name,
          'image_file' => $file_destination,
          'image_posted' => $date,
          'fulldate' => $fulldate,
          'image_description' => $image_description
        ];

        $update_tbl = 'gallery/' . $key_child;
        $update_query = $database->getReference($update_tbl)->update($updateData);


        if ($update_query) {
          $delete_me_file  = $bucket->object($delete_me_name);
          $delete_me_file->delete();

          echo $alert_update = '<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
                    <i class="fa fa-check mr-1" aria-hidden="true"></i><strong>Image has been updated!</strong>
                  </div>';
        } else {
          echo $alert_update = '<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
                    <strong>Failed to edit the product!</strong>
                  </div>';
        }
      } else {
        echo $alert_update = "<div class='alert alert-warning alert-dismissible fade show'>
                  <button type='button' class='close' data-dismiss='alert'><i class='fa fa-window-close' aria-hidden='true'></i></button>
                  <i class='fa fa-exclamation-triangle mr-1' aria-hidden='true'></i><strong>There's an error uploading the image. Please, try again!</strong>
                  </div>";
      }
    } else {
      echo  $alert_update = '<div class="alert alert-warning alert-dismissible fade show">
              <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
              <i class="fa fa-exclamation-triangle mr-1" aria-hidden="true"></i><strong>The file uploaded is not an image file. Please, try again!</strong>
              </div>';
    }
  } else {
    $key_child = $_POST['image-update-id'];
    $ref_tbl = 'gallery';
    $alert_update = '';

    $fetch_result = $database->getReference($ref_tbl)->getChild($key_child)->getValue();

    $new_name = $_POST['update-image-name'];
    $ext_file = $_POST['image-ext-file'];
    $date = $_POST['image-ext-date'];
    $del_name = $_POST['image-name-del'];
    $fulldate = date('Y-m-d');

    $bucketName = 'trendz-ph.appspot.com';
    $storage = new StorageClient();
    $storage = $cloud->storage();

    $bucket = $storage->bucket($bucketName);
    $object = $bucket->object('gallery/' . $del_name);
    $getUrl = $object->copy($bucketName, ['name' => 'gallery/' . $new_name]);


    $urlDownload = "https://{$bucket->name()}.storage.googleapis.com/{$getUrl->name()}";

    $updateData = [
      'image_name' => $new_name,
      'image_file' => "./assets/uploads/gallery/" . $ext_file,
      'image_posted' => $date,
      'fulldate' => $fulldate,
      'download_url' => $urlDownload,
      'image_description' => $image_description
    ];
    $update_tbl = 'gallery/' . $key_child;
    $update_query = $database->getReference($update_tbl)->update($updateData);

    if ($update_query) {
      $object->delete();
      echo $alert_update = '<div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
          <i class="fa fa-check mr-1" aria-hidden="true"></i><strong>Image has been updated!</strong>
        </div>';
    } else {
      echo $alert_update = '<div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
          <strong>Failed to update the image!</strong>
        </div>';
    }
  }
}
