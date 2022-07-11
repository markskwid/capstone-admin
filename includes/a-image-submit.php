
<?php
include 'dbcon.php';

use Google\Cloud\Storage\StorageClient;

if (isset($_GET['confirm-btn'])) {
    $del_id = $_GET['confirm-btn'];
    $alert_image = '';

    $img_name = $_GET['imgs-name'];
    $img_date = $_GET['imgs-date'];
    $img_dl = $_GET['imgs-downloadlink'];
    $fulldate = date("y-m-d");

    $storage = new StorageClient([
        'keyFilePath' => './config/trendz-ph-firebase-adminsdk-229z9-86a489b52e.json',
    ]);
    $bucketName = 'trendz-ph.appspot.com';
    $bucket = $storage->bucket($bucketName);
    $object = $bucket->object("folder/" . $img_name);
    $getmine = $object->copy($bucketName, ['name' =>  "gallery/" . $img_name]);
    $urlDownload = "https://{$bucket->name()}.storage.googleapis.com/{$getmine->name()}";


    $postData = [
        'image_name' => $img_name,
        'image_posted' => $img_date,
        'download_url' => $urlDownload,
        'fulldate' => trim($fulldate),
    ];

    $ref_tbl = 'archive_gallery/' . $del_id;
    $del_result = $database->getReference($ref_tbl)->remove();
    $ref_table = 'gallery';

    if ($del_result) {
        $postRef_result = $database->getReference($ref_table)->push($postData);
        $object->delete();
        if ($postRef_result) {
            echo $alert_image = '<div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
      <i class="fa fa-check mr-1" aria-hidden="true"></i><strong>Image has been restored!</strong>
    </div>';
        } else {
            echo $alert_image = '<div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
          <i class="fa fa-exclamation-triangle" aria-hidden="true"></i><strong>Image failed to restore!</strong>
        </div>';
        }
    } else {
        echo $alert_image = '<div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
          <i class="fa fa-exclamation-triangle" aria-hidden="true"></i><strong>Image failed to delete!</strong>
        </div>';
    }
}
