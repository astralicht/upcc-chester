<?php

use Main\Models\DeleteModel;

include_once "../vendor/autoload.php";
include_once "unit-test-tools.php";

$task = "New Delete model instance";
try {
    $DeleteModel = new DeleteModel;
    if (get_class($DeleteModel) === "Main\Models\DeleteModel") printSuccess($task);
} catch (Error $e) {
    printFailed($task);
    echo "<li>$e</li>";
}

/**
 * Users
 */

$task = "Delete existing single user";
checkIfSuccess($task, $DeleteModel, "users", json_encode(["30"]));

$task = "Delete non-existing single user";
checkIfSuccess($task, $DeleteModel, "users", json_encode(["1080"]));

$task = "Delete single user with empty id";
checkIfSuccess($task, $DeleteModel, "users", json_encode([""]));

$task = "Delete single user with null id";
checkIfSuccess($task, $DeleteModel, "users", json_encode([null]));


$task = "Delete existing multiple users";
checkIfSuccess($task, $DeleteModel, "users", json_encode(["30", "31", "32"]));

$task = "Delete non-existing multiple user";
checkIfSuccess($task, $DeleteModel, "users", json_encode(["1080", "250", "602"]));

$task = "Delete multiple users with empty id";
checkIfSuccess($task, $DeleteModel, "users", json_encode(["", "", ""]));

$task = "Delete multiple users with null id";
checkIfSuccess($task, $DeleteModel, "users", json_encode([null, null, null]));


/**
 * Products
 */

$task = "Delete existing single product";
checkIfSuccess($task, $DeleteModel, "products", json_encode(["1"]));

$task = "Delete non-existing single product";
checkIfSuccess($task, $DeleteModel, "products", json_encode(["1080"]));

$task = "Delete single product with empty id";
checkIfSuccess($task, $DeleteModel, "products", json_encode([""]));

$task = "Delete single product with null id";
checkIfSuccess($task, $DeleteModel, "products", json_encode([null]));


$task = "Delete existing multiple products";
checkIfSuccess($task, $DeleteModel, "products", json_encode(["1", "12", "14"]));

$task = "Delete non-existing multiple products";
checkIfSuccess($task, $DeleteModel, "products", json_encode(["1080", "250", "602"]));

$task = "Delete multiple products with empty id";
checkIfSuccess($task, $DeleteModel, "products", json_encode(["", "", ""]));

$task = "Delete multiple products with null id";
checkIfSuccess($task, $DeleteModel, "products", json_encode([null, null, null]));


/**
 * Product Types
 */

$task = "Delete existing single product type";
checkIfSuccess($task, $DeleteModel, "productTypes", json_encode(["8"]));

$task = "Delete non-existing single product type";
checkIfSuccess($task, $DeleteModel, "productTypes", json_encode(["1080"]));

$task = "Delete single product type with empty id";
checkIfSuccess($task, $DeleteModel, "productTypes", json_encode([""]));

$task = "Delete single product type with null id";
checkIfSuccess($task, $DeleteModel, "productTypes", json_encode([null]));


$task = "Delete existing multiple product types";
checkIfSuccess($task, $DeleteModel, "productTypes", json_encode(["8", "9", "11"]));

$task = "Delete non-existing multiple product types";
checkIfSuccess($task, $DeleteModel, "productTypes", json_encode(["1080", "250", "602"]));

$task = "Delete multiple product types with empty id";
checkIfSuccess($task, $DeleteModel, "productTypes", json_encode(["", "", ""]));

$task = "Delete multiple product types with null id";
checkIfSuccess($task, $DeleteModel, "productTypes", json_encode([null, null, null]));


/**
 * Client cart item
 */

$task = "Delete existing single client cart item";
checkIfSuccess($task, $DeleteModel, "clientCartItem", ["id" => "126"]);

$task = "Delete non-existing single client cart item";
checkIfSuccess($task, $DeleteModel, "clientCartItem", ["id" => "1020"]);

$task = "Delete single client cart item with empty id";
checkIfSuccess($task, $DeleteModel, "clientCartItem", ["id" => ""]);

$task = "Delete single client cart item with null id";
checkIfSuccess($task, $DeleteModel, "clientCartItem", ["id" => null]);


/**
 * Orders
 */

$task = "Delete existing single order";
checkIfSuccess($task, $DeleteModel, "orders", json_encode(["38"]));

$task = "Delete non-existing single order";
checkIfSuccess($task, $DeleteModel, "orders", json_encode(["10101"]));

$task = "Delete single order with empty id";
checkIfSuccess($task, $DeleteModel, "orders", json_encode([""]));

$task = "Delete single order with null id";
checkIfSuccess($task, $DeleteModel, "orders", json_encode([null]));


$task = "Delete existing multiple orders";
checkIfSuccess($task, $DeleteModel, "orders", json_encode(["38", "39"]));

$task = "Delete non-existing multiple orders";
checkIfSuccess($task, $DeleteModel, "orders", json_encode(["10101", "10102"]));

$task = "Delete multiple orders with empty id";
checkIfSuccess($task, $DeleteModel, "orders", json_encode(["", ""]));

$task = "Delete multiple orders with null id";
checkIfSuccess($task, $DeleteModel, "orders", json_encode([null, null]));