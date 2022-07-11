<?php

include 'dbcon.php';

use Google\Cloud\Storage\StorageClient;

if (isset($_POST['add-to-inventory'])) {
  $prod_name = $_POST['product-name'];
  $prod_quantity = $_POST['product-quantity'];
  $alert = '';

  // image part
  $prod_file = $_FILES['product-file'];
  $fulldate = date("y-m-d");

  $image_fileName = $_FILES['product-file']['name'];
  $image_tmpName = $prod_file['tmp_name'];
  $image_error =  $prod_file['error'];

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

      $object = $bucket->upload(fopen($prod_file['tmp_name'], 'r'),  [
        'name' => "inventory/" . $prod_name,
        'metadata' => [
          'contentType' => 'image/jpeg',
        ],
        'predefinedAcl' => 'publicRead',
      ]);

      $publicUrl = "https://{$bucket->name()}.storage.googleapis.com/{$object->name()}";

      $file_newName = uniqid('', true) . "." . $image_fileActualExt;
      $file_destination = "./assets/uploads/inventory/" . $file_newName;
      move_uploaded_file($image_tmpName, $file_destination);
      $postData = [
        'product_name' => $prod_name,
        'product_file' => $file_destination,
        'product_quantity' => $prod_quantity,
        'fulldate' => $fulldate,
        'download_url' => $publicUrl
      ];

      $ref_table = 'inventory';
      $postRef_result = $database->getReference($ref_table)->push($postData);

      if ($postRef_result) {
        echo $alert = '<div class="alert alert-success alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
                    <i class="fa fa-check mr-1" aria-hidden="true"></i> <strong>New product has been added!</strong>
                  </div>';
      } else {
        echo $alert = '<div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
                    <strong>Failed to add the product!</strong>
                  </div>';
      }
    } else {
      echo $alert = "<div class='alert alert-warning alert-dismissible fade show'>
                <button type='button' class='close' data-dismiss='alert'><i class='fa fa-window-close' aria-hidden='true'></i></button>
                <strong>There's an error uploading the image. Please, try again!</strong>
                </div>";
    }
  } else {
    echo  $alert = '<div class="alert alert-warning alert-dismissible fade show">
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

  $fulldate = date("y-m-d");
  $filename = $_GET['del-filename'];
  $nameFile = $_GET['del-name'];
  $prod_qty = $_GET['del-quantity'];

  $storage = new StorageClient([
    'keyFilePath' => './config/trendz-ph-firebase-adminsdk-229z9-86a489b52e.json',
  ]);
  $bucketName = 'trendz-ph.appspot.com';
  $bucket = $storage->bucket($bucketName);
  $object = $bucket->object("inventory/" . $nameFile);
  $getmine = $object->copy($bucketName, ['name' =>  "folder/" . $nameFile]);
  $urlDownload = "https://{$bucket->name()}.storage.googleapis.com/{$getmine->name()}";


  $postData = [
    'product_name' => $nameFile,
    'product_file' => "./assets/uploads/inventory/" . $filename,
    'product_quantity' => $prod_qty,
    'fulldate' => $fulldate,
    'download_url' => $urlDownload
  ];

  $ref_table = 'archive_prod';
  $postRef_result = $database->getReference($ref_table)->push($postData);

  $ref_tbl = 'inventory/' . $del_id;


  if ($postRef_result) {
    $object->delete();
    $del_result = $database->getReference($ref_tbl)->remove();
    if ($del_result) {
      echo $alert_image = '<div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
      <i class="fa fa-check mr-1" aria-hidden="true"></i><strong>Product has been deleted!</strong>
    </div>';
    } else {
      echo $alert_image = '<div class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
      <strong>Product failed to delete!</strong>
    </div>';
    }
  } else {
    echo $alert_image = '<div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
          <strong>Product failed to delete!</strong>
        </div>';
  }
}

?>

<?php

include 'dbcon.php';
if (isset($_POST['prod-update-id'])) {

  if ($_FILES['update-product-file']['size'] > 1) {
    $key_child = $_POST['prod-update-id'];
    $ref_tbl = 'inventory';
    $alert_update = '';

    $fetch_result = $database->getReference($ref_tbl)->getChild($key_child)->getValue();

    $new_name = $_POST['update-product-name'];
    $new_file = $_FILES['update-product-file'];
    $new_quantity = $_POST['update-product-quantity'];

    $bucketName = 'trendz-ph.appspot.com';
    $storage = new StorageClient();
    $storage = $cloud->storage();
    $bucket = $storage->bucket($bucketName);

    $delete_me_name = 'inventory/' . $name_del;

    $NewObject = $bucket->upload(fopen($new_file['tmp_name'], 'r'),  [
      'name' => "gallery/" . $new_name,
      'metadata' => [
        'contentType' => 'image/jpeg',
      ],
      'predefinedAcl' => 'publicRead',
    ]);

    $urlDownload = "https://{$bucket->name()}.storage.googleapis.com/{$NewObject->name()}";

    // image part
    $prod_file = $_FILES['update-product-file'];

    $image_fileName = $_FILES['update-product-file']['name'];
    $image_tmpName = $prod_file['tmp_name'];
    $image_error =  $prod_file['error'];

    $image_fileExt = explode('.', $image_fileName);
    $image_fileActualExt = strtolower(end($image_fileExt));

    $allowed = array('jpg', 'jpeg', 'png');

    if (in_array($image_fileActualExt, $allowed)) {
      if ($image_error === 0) {
        $file_newName = uniqid('', true) . "." . $image_fileActualExt;
        $file_destination = "./assets/uploads/inventory/" . $file_newName;
        move_uploaded_file($image_tmpName, $file_destination);
        $updateData = [
          'product_name' => $new_name,
          'product_file' => $file_destination,
          'product_quantity' => $new_quantity
        ];

        $update_tbl = 'inventory/' . $key_child;
        $update_query = $database->getReference($update_tbl)->update($updateData);


        if ($update_query) {
          echo $alert_update = '<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
                    <i class="fa fa-check mr-1" aria-hidden="true"></i><strong>Product has been updated!</strong>
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
                  <i class='fa fa-check mr-1' aria-hidden='true'></i><strong>There's an error uploading the image. Please, try again!</strong>
                  </div>";
      }
    } else {
      echo  $alert_update = '<div class="alert alert-warning alert-dismissible fade show">
              <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
              <strong>The file uploaded is not an image file. Please, try again!</strong>
              </div>';
    }
  } else {
    $key_child = $_POST['prod-update-id'];
    $ref_tbl = 'inventory';
    $alert_update = '';

    $fetch_result = $database->getReference($ref_tbl)->getChild($key_child)->getValue();

    $new_name = $_POST['update-product-name'];
    $ext_file = $_POST['prod-ext-file'];
    $new_quantity = $_POST['update-product-quantity'];

    $updateData = [
      'product_name' => $new_name,
      'product_file' => "./assets/uploads/inventory/" . $ext_file,
      'product_quantity' => $new_quantity
    ];
    $update_tbl = 'inventory/' . $key_child;
    $update_query = $database->getReference($update_tbl)->update($updateData);

    if ($update_query) {
      echo $alert_update = '<div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
          <i class="fa fa-check mr-1" aria-hidden="true"></i><strong>Product has been updated!</strong>
        </div>';
    } else {
      echo $alert_update = '<div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
          <strong>Failed to update the product!</strong>
        </div>';
    }
  }
}
?>

