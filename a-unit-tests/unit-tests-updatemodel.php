<?php

use Main\Models\UpdateModel;

include_once "../vendor/autoload.php";
include_once "unit-test-tools.php";

$task = "New Update model instance";
try {
    $UpdateModel = new UpdateModel;
    if (get_class($UpdateModel) === "Main\Models\UpdateModel") printSuccess($task);
} catch (Error $e) {
    printFailed($task);
    echo "<li>$e</li>";
}

$task = "Update client info";
checkIfSuccess($task, $UpdateModel, "clientInfo", json_encode([
    "Unit",
    "Testing",
    "UPCC",
    "NA",
    "09012345678",
    "Steam and Water Supply",
    "32",
]));

$task = "Update order status";
checkIfSuccess($task, $UpdateModel, "orderStatus", json_encode([
    "status" => "APPROVED",
    "order_id" => "105",
]));

$task = "Update image data for an existing product";
checkIfSuccess($task, $UpdateModel, "updateImageData", [
    "options" => "MULTIPLE",
    "banana/peel",
    "banana.jpg",
    "PRODUCT",
    "12",
]);

$task = "Update image data for a non-existent product";
checkIfSuccess($task, $UpdateModel, "updateImageData", [
    "options" => "MULTIPLE",
    "banana/peel",
    "banana.jpg",
    "PRODUCT",
    "11032",
]);

$task = "Update image data for an existing user";
checkIfSuccess($task, $UpdateModel, "updateImageData", [
    "options" => "MULTIPLE",
    "banana/peel/banana.jpg",
    "banana.jpg",
    "USER",
    "31",
]);

$task = "Update image data for a non-existent user";
checkIfSuccess($task, $UpdateModel, "updateImageData", [
    "options" => "MULTIPLE",
    "banana/peel/banana.jpg",
    "banana.jpg",
    "USER",
    "11032",
]);

$task = "Update image data for user with blank id";
checkIfSuccess($task, $UpdateModel, "updateImageData", [
    "options" => "MULTIPLE",
    "banana/peel/banana.jpg",
    "banana.jpg",
    "USER",
    "",
]);

$task = "Update image data for user with null id";
checkIfSuccess($task, $UpdateModel, "updateImageData", [
    "options" => "MULTIPLE",
    "banana/peel/banana.jpg",
    "banana.jpg",
    "USER",
    null,
]);

$task = "Update existing product";
checkIfSuccess($task, $UpdateModel, "product", [
    "" => "",
]);

$task = "Update non-existent product";
checkIfSuccess($task, $UpdateModel, "product", [
    "" => "",
]);

$task = "Update product with blank id";
checkIfSuccess($task, $UpdateModel, "product", [
    "" => "",
]);

$task = "Update product with null id";
checkIfSuccess($task, $UpdateModel, "product", [
    "" => "",
]);

$task = "Update password of existing user";
checkIfSuccess($task, $UpdateModel, "password", "");

$task = "Update password of non-existent user";
checkIfSuccess($task, $UpdateModel, "password", "");

$task = "Update password of user with blank id";
checkIfSuccess($task, $UpdateModel, "password", "");

$task = "Update password of user with null id";
checkIfSuccess($task, $UpdateModel, "password", "");