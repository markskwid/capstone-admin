<?php
include 'dbcon.php';
$ref_table = 'employee';
$fetchData = $database->getReference($ref_table)->getValue();

if ($fetchData > 0) {
  foreach ($fetchData as $key => $row) {
    echo "<tr>
            <td>" . $row['employee_name'] . "</td>
            <td>" . $row['employee_email'] . "</td>
            <td>" . $row['employee_contact'] . "</td>
            <td>" . $row['employee_schedule'] . "</td>
            <td>" . $row['employee_password'] . "</td>
            <td>
            <form class='form-inline' action='code.php' method='POST'>
            <button type='button' class='btn btn-primary mr-1 edit-btn' id='edit-btn'><i class='fa fa-pencil fa-lg'></i></button>
            <button type='submit' name='delete-btn' class='btn btn-primary del-btn' value='" . $key . "'><i class='fa fa-archive fa-lg'></i></button>
            </form>
            </td>
          </tr>";
  }
} else {
  echo "<tr>
            <td colspan='6'>NO RECORD FOUND</td>
        </tr>";
}
