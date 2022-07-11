
<?php
// archive
include 'dbcon.php';

if (isset($_GET['confirm-btn'])) {
    $del_id = $_GET['confirm-btn'];
    $alert_image = '';

    $fulldate = date("y-m-d");
    $filename = $_GET['del-filename'];
    $nameFile = $_GET['del-name'];
    $prod_qty = $_GET['del-quantity'];
    $file = $_GET['del-file'];

    $postData = [
        'product_name' => $nameFile,
        'product_file' => $file,
        'product_quantity' => $prod_qty,
        'fulldate' => $fulldate,
    ];

    $ref_table = 'inventory';
    $postRef_result = $database->getReference($ref_table)->push($postData);

    $ref_tbl = 'archive_prod/' . $del_id;


    if ($postRef_result) {
        $del_result = $database->getReference($ref_tbl)->remove();
        if ($del_result) {
            echo $alert_image = '<div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
      <i class="fa fa-check mr-1" aria-hidden="true"></i><strong>Product has been restored!</strong>
    </div>';
        } else {
            echo $alert_image = '<div class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
      <strong>Product failed to restore!</strong>
    </div>';
        }
    } else {
        echo $alert_image = '<div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert"><i class="fa fa-window-close" aria-hidden="true"></i></button>
          <strong>Product failed to restore!</strong>
        </div>';
    }
}

?>