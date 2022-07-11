<?php

require 'vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;
use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Core\ServiceBuilder;


$factory = (new Factory)
    ->withServiceAccount('./config/trendz-ph-firebase-adminsdk-229z9-86a489b52e.json')
    ->withDatabaseUri('https://trendz-ph-default-rtdb.firebaseio.com/');

$storage = (new Factory())
    ->withDefaultStorageBucket('gs://trendz-ph.appspot.com/')
    ->createStorage();
$auth = $factory->createAuth();
$cloud = new ServiceBuilder([
    'keyFilePath' => './config/trendz-ph-firebase-adminsdk-229z9-86a489b52e.json'
]);

$storage = $cloud->storage();

$database = $factory->createDatabase();
$ref_table = 'inventory';
$ref_table_emp = 'inventory';
$inventory_total = count($database->getReference($ref_table)->shallow()->getValue());
$employee_total = count($database->getReference('employee')->shallow()->getValue());
$book_total = count($database->getReference('reservation')->shallow()->getValue());
$user_total = count($database->getReference('customer')->shallow()->getValue());

$success_total = count($database->getReference('success_appointment')->shallow()->getValue());
$canceled_total = count($database->getReference('canceled_appointment')->shallow()->getValue());

$i = 0;
$fetchData = $database->getReference('success_appointment')->orderByChild('month')->equalTo('Feb')->getValue();
if ($fetchData > 0) {
    foreach ($fetchData as $key => $row) {
        $i++;
    }
}

$x = 0;
$canc = $database->getReference('canceled_appointment')->orderByChild('month')->equalTo('Feb')->getValue();
if ($canc > 0) {
    foreach ($canc as $key => $row) {
        $x++;
    }
}
$totalBookMonth = $i + $x;
