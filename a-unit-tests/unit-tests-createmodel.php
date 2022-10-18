<?php

use Main\Models\CreateModel;

include_once "../vendor/autoload.php";
include_once "unit-test-tools.php";

$task = "New Create model instance";
try {
    $CreateModel = new CreateModel;
    if (get_class($CreateModel) === "Main\Models\CreateModel") printSuccess($task);
} catch (Error $e) {
    printFailed($task);
    echo "<li>$e</li>";
}

$task = "Create user";
checkIfSuccess($task, $CreateModel, "user", json_encode([
    "first_name" => "Unit",
    "last_name" => "Testing",
    "company_name" => "UPCC",
    "email" => "unit-test@mail.com",
    "phone_number" => "",
    "password" => "unit-test",
    "confirm_password" => "unit-test",
    "company_nature" => "",
    "company_address" => "",
]));

$_SESSION["type"] = "ADMIN";

$task = "Create product type";
checkIfSuccess($task, $CreateModel, "productType", json_encode(["name" => "Unit Test Type", "description" => ""]));

$task = "Create product";
checkIfSuccess($task, $CreateModel, "product", json_encode([
    "unit-price" => "10.01",
    "name" => "Unit Test Product",
    "material" => "",
    "brand" => "",
    "connection_type" => "",
    "length" => "",
    "width" => "",
    "thickness" => "",
    "type_id" => "12",
]));

$task = "Create product price";
checkIfSuccess($task, $CreateModel, "productPrice", json_encode(["9", "10.01"]));

// $task = "Create product stock";
// checkIfSuccess($task, $CreateModel, "productStock", json_encode(["", ""]));

$_SESSION["type"] = "AGENT";
$_SESSION["id"] = "30";

$task = "Create order (agent)";
checkIfSuccess($task, $CreateModel, "order", json_encode([
    "user-email" => "unit-test@mail.com",
    "product-ids" => [
        "prod-1" => 1,
    ],
]));

$_SESSION["id"] = "33";
$_SESSION["type"] = "CLIENT";
$_SESSION["email"] = "julac_15@yahoo.com";
$_SESSION["first_name"] = "Julac";
$_SESSION["last_name"] = "Ontina";

$task = "Create cart item (client)";
checkIfSuccess($task, $CreateModel, "cartItem", [
    "product_id" => "1",
    "quantity" => "1",
]);

// $task = "Create order from cart (client)";
// checkIfSuccess($task, $CreateModel, "clientOrder");

$task = "Create 5-second cookie";
checkIfSuccess($task, $CreateModel, "cookie", 5);

unset($_SESSION["email"]);
unset($_SESSION["id"]);
unset($_SESSION["cookieId"]);
$_SESSION["type"] = "ADMIN";

$task = "Create user (admin)";
checkIfSuccess($task, $CreateModel, "user", json_encode([
    "first_name" => "Unit",
    "last_name" => "Testing",
    "company_name" => "UPCC",
    "email" => "unit-test@mail.com",
    "phone_number" => "",
    "password" => "unit-test",
    "confirm_password" => "unit-test",
    "company_nature" => "",
    "company_address" => "",
]));

$task = "Create new 5-minute token";
checkIfSuccess($task, $CreateModel, "token", "unit-test@mail.com");

unset($_SESSION["type"]);