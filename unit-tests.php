<?php

use Main\Models\FetchModel;
use Main\Config;

include_once "models/FetchModel.php";
include_once "Config.php";

/**
 * Fetch model
 */

 // New fetch instance
$output = "New fetch instance: ";
$status = "FAILED";
$Config = new FetchModel();
if (get_class($Config) === "Main\Models\FetchModel") $status = "SUCCESS";
echo $output . $status . "\n";

// Fetch all users
$output = "Fetch all users: ";
$status = "FAILED";
$FetchModel = new FetchModel();
try {
    if($FetchModel->getResult("SELECT * FROM users")["status"] === 200) $status = "SUCCESS";
} catch(mysqli_sql_exception $e) {
    echo $output . $status . "\n";
}
echo $output . $status . "\n";

// Fetch all users count
$output = "Fetch all users count: ";
$status = "FAILED";
$FetchModel = new FetchModel();
try {
    if($FetchModel->usersCount()["status"] === 200) $status = "SUCCESS";
} catch(mysqli_sql_exception $e) {
    echo $output . $status . "\n";
}
echo $output . $status . "\n";

// Fetch all products count
$output = "Fetch all products count: ";
$status = "FAILED";
$FetchModel = new FetchModel();
try {
    if($FetchModel->usersCount()["status"] === 200) $status = "SUCCESS";
} catch(mysqli_sql_exception $e) {
    echo $output . $status . "\n";
}
echo $output . $status . "\n";