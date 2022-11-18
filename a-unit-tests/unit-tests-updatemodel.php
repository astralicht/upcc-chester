<?php

use Main\Models\UpdateModel;

include_once "../vendor/autoload.php";
include_once "unit-test-tools.php";

$task = "New Update model instance";
try {
    $UpdateModel = new UpdateModel([
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'db_name' => 'upcc_unit_tests',
    ]);
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
checkIfSuccess($task, $UpdateModel, "product", json_encode([
    "product-id" => "1",
    "unit-price" => "50",
    "name" => "Rubber banana 30 pcs.",
    "material" => "Rubber",
    "brand" => "Banana Republic",
    "connection_type" => "",
    "length" => "5cm",
    "width" => "5cm",
    "thickness" => ".3cm",
    "type_id" => "9",
    "image-input" => "",
    "image-type" => "",
    "old-image-path" => "",
]));

$task = "Update non-existent product";
checkIfSuccess($task, $UpdateModel, "product", json_encode([
    "product-id" => "2",
    "unit-price" => "50",
    "name" => "Rubber banana 30 pcs.",
    "material" => "Rubber",
    "brand" => "Banana Republic",
    "connection_type" => "",
    "length" => "5cm",
    "width" => "5cm",
    "thickness" => ".3cm",
    "type_id" => "9",
    "image-input" => "",
    "image-type" => "",
    "old-image-path" => "",
]));

$task = "Update product with blank id";
checkIfSuccess($task, $UpdateModel, "product", json_encode([
    "product-id" => "",
    "unit-price" => "50",
    "name" => "Rubber banana 30 pcs.",
    "material" => "Rubber",
    "brand" => "Banana Republic",
    "connection_type" => "",
    "length" => "5cm",
    "width" => "5cm",
    "thickness" => ".3cm",
    "type_id" => "9",
    "image-input" => "",
    "image-type" => "",
    "old-image-path" => "",
]));

$task = "Update product with null id";
checkIfSuccess($task, $UpdateModel, "product", json_encode([
    "product-id" => null,
    "unit-price" => "50",
    "name" => "Rubber banana 30 pcs.",
    "material" => "Rubber",
    "brand" => "Banana Republic",
    "connection_type" => "",
    "length" => "5cm",
    "width" => "5cm",
    "thickness" => ".3cm",
    "type_id" => "9",
    "image-input" => "",
    "image-type" => "",
    "old-image-path" => "",
]));

$_SESSION["email-for-password-reset"] = "eneioarzew@gmail.com";
$task = "Update password of existing user";
checkIfSuccess($task, $UpdateModel, "password", "arcanE02!");

$_SESSION["email-for-password-reset"] = "mark@mail.com";
$task = "Update password of non-existent user";
checkIfSuccess($task, $UpdateModel, "password", "arcanE02!");

$_SESSION["email-for-password-reset"] = "";
$task = "Update password of user with blank email";
checkIfSuccess($task, $UpdateModel, "password", "arcanE02!");

$_SESSION["email-for-password-reset"] = null;
$task = "Update password of user with null email";
checkIfSuccess($task, $UpdateModel, "password", "arcanE02!");