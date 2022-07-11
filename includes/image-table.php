<?php
include 'dbcon.php';
$ref_table = 'gallery';
$fetchData = $database->getReference($ref_table)->getValue();

if ($fetchData > 0) {
  foreach ($fetchData as $key => $row) {
    echo "<tr>
            <td>" . $row['image_name'] . "</td>
            <td><img src='" . $row['image_file'] . "'></td>
            <td>" . $row['image_posted'] . "</td>
            <td>
            
            <button type='button' class='btn btn-primary mr-1 edit-btn' id='edit-btn'><i class='fa fa-pencil fa-lg'></i></button>
            <button type='button' class='btn btn-primary del-btn'><i class='fa fa-archive fa-lg'></i></button>
            </td>
          </tr>";
  }
} else {
  echo "<tr>
            <td colspan='6'>NO RECORD FOUND</td>
        </tr>";
}
