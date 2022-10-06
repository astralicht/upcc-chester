<?php

use Main\Controllers\RecommendationController;
use Main\Models\FetchModel;

include_once "vendor/autoload.php";
include_once "unit-test-tools.php";

/**
 * Fetch model
 */

$task = "New fetch instance";
try {
    $FetchModel = new FetchModel();
    if (get_class($FetchModel) === "Main\Models\FetchModel") printSuccess($task);
} catch (Error $e) {
    printFailed($task);
    echo "<li>$e</li>";
}

$task = "Fetch all users";
checkIfSuccess($task, $FetchModel, "getResult", "SELECT * FROM users");

$task = "Fetch all users count";
checkIfSuccess($task, $FetchModel, "usersCount");

$task = "Fetch all products count";
checkIfSuccess($task, $FetchModel, "productsCount");

$task = "Fetch all orders count";
checkIfSuccess($task, $FetchModel, "ordersCount");

$task = "Fetch all cart items count";
checkIfSuccess($task, $FetchModel, "cartItemsCount");

$task = "Fetch all users without filter";
checkIfSuccess($task, $FetchModel, "users", [
    "filter" => "",
    "page" => "0",
    "limit" => "20",
]);

$task = "Fetch all users with existing 'User' filter";
checkIfSuccess($task, $FetchModel, "users", [
    "filter" => "",
    "page" => "0",
    "limit" => "20",
], "non-zero");

$task = "Fetch all users with non-existent 'banana' filter";
checkIfSuccess($task, $FetchModel, "users", [
    "filter" => "banana",
    "page" => "0",
    "limit" => "20",
], "zero");



/**
 * Recommendation Engine
 */

$task = "New rec controller instance";
try {
    $RecController = new RecommendationController();
    if (get_class($RecController) === "Main\Controllers\RecommendationController") printSuccess($task);
} catch (Error $e) {
    printFailed($task);
    echo "<li>$e</li>";
}

$task = "Get cookies";
try {
    $RecController = new RecommendationController();
    $cookies = $RecController->getCookies();
    if (gettype(array_values($cookies)) === "array") printSuccess($task);
} catch (Error $e) {
    printFailed($task);
    echo "<li>$e</li>";
}

$task = "New null-valued, 5-second cookie";
try {
    $RecController = new RecommendationController();
    $cookies = $RecController->getCookies();
    $count = count(array_values($cookies)[0]);
    $cookieValues = json_encode([
        "product_id" => null,
        "type" => null,
        "material" => null,
        "brand" => null,
        "connection_type" => null,
    ]);
    setcookie(
        $_SESSION["id"] . "_" . uniqid(),
        $cookieValues,
        time()+5,
        "/"
    );

    $newCount = count(array_values($cookies)[0]);
    $diff = $newCount - $count;
    if ($diff > 0) printSuccess($task);
} catch (Error $e) {
    printFailed($task);
    echo "<li>$e</li>";
}


/**
 * Fetch model (continuation)
 */

$task = "Fetch all products without filter";
checkIfSuccess($task, $FetchModel, "products", [
    "filter" => "",
    "brand" => "",
    "typeid" => "",
    "page" => "0",
    "limit" => "20",
]);

$task = "Fetch products with existing filter only (no other params)";
checkIfSuccess($task, $FetchModel, "productsFilterOnly", [
    "filter" => "banana",
], "non-zero");

$task = "Fetch products with empty filter only (no other params)";
checkIfSuccess($task, $FetchModel, "productsFilterOnly", [
    "filter" => "",
], "non-zero");

$task = "Fetch products with null filter only (no other params)";
checkIfSuccess($task, $FetchModel, "productsFilterOnly", [
    "filter" => null,
], "non-zero");

$task = "Fetch all product ids";
checkIfSuccess($task, $FetchModel, "allProductIds");

$task = "Fetch all products complete";
checkIfSuccess($task, $FetchModel, "allProductsComplete");

$task = "Fetch all specific product details complete with existing id";
checkIfSuccess($task, $FetchModel, "productDetailsComplete", "12", "non-zero");

$task = "Fetch all specific product details complete with blank id";
checkIfSuccess($task, $FetchModel, "productDetailsComplete", "", "zero");

$task = "Fetch all specific product details complete with null id";
checkIfSuccess($task, $FetchModel, "productDetailsComplete", null, "zero");

$task = "Fetch all orders";
checkIfSuccess($task, $FetchModel, "allOrders", [
    "page" => "0",
    "limit" => "20",
]);

$task = "Fetch all orders of existing client";
checkIfSuccess($task, $FetchModel, "clientOrders", "13", "zero");

//$task = "Fetch all orders with product info with existing filter";
// try {
//     $response = $FetchModel->ordersWithProducts([
//         "filter" => "",
//     ]);
//     if ($response["status"] === 200) printSuccess($task);
//     else {
//         printFailed($task);
//         echo "<br><br><li>".$response["message"]."</li>";
//     }
// }

$task = "Fetch specific order with existing id";
checkIfSuccess($task, $FetchModel, "order", ["id" => "1"], "non-zero");

$task = "Fetch specific order with blank id";
checkIfSuccess($task, $FetchModel, "order", ["id" => ""], "zero");

$task = "Fetch specific order with null id";
checkIfSuccess($task, $FetchModel, "order", ["id" => null], "zero");

$task = "Fetch all company natures";
checkIfSuccess($task, $FetchModel, "companyNatures");

$task = "Fetch specific product with existing id";
checkIfSuccess($task, $FetchModel, "product", ["id" => "12"], "non-zero");

$task = "Fetch specific product with blank id";
checkIfSuccess($task, $FetchModel, "product", ["id" => ""], "zero");

$task = "Fetch specific product with null id";
checkIfSuccess($task, $FetchModel, "product", ["id" => null], "zero");

$task = "Fetch specfic user with existing id";
checkIfSuccess($task, $FetchModel, "user", ["id" => "13"], "non-zero");

$task = "Fetch specfic user with blank id";
checkIfSuccess($task, $FetchModel, "user", ["id" => ""], "zero");

$task = "Fetch specfic user with null id";
checkIfSuccess($task, $FetchModel, "user", ["id" => null], "zero");

$task = "Fetch product type with existing filter";
checkIfSuccess($task, $FetchModel, "productTypes", [
    "filter" => "Miscellaneous",
    "page" => "0",
    "limit" => "20",
], "non-zero");

$task = "Fetch product type with blank filter";
checkIfSuccess($task, $FetchModel, "productTypes", [
    "filter" => "",
    "page" => "0",
    "limit" => "20",
]);

$task = "Fetch product type with null filter";
checkIfSuccess($task, $FetchModel, "productTypes", [
    "filter" => null,
    "page" => "0",
    "limit" => "20",
]);

$task = "Fetch all product types";
checkIfSuccess($task, $FetchModel, "productTypesAll");

$task = "Fetch specific client cart items with existing id";
checkIfSuccess($task, $FetchModel, "clientCart", [
    "client_id" => "13",
]);

$task = "Fetch specific client cart items with blank id";
checkIfSuccess($task, $FetchModel, "clientCart", [
    "client_id" => "",
], "zero");

$task = "Fetch specific client cart items with null id";
checkIfSuccess($task, $FetchModel, "clientCart", [
    "client_id" => null,
], "zero");

$task = "Fetch all featured products";
checkIfSuccess($task, $FetchModel, "featuredProducts");

$task = "Fetch all types and brands";
checkIfSuccess($task, $FetchModel, "typesAndBrands");

$task = "Check if email is registered to an account.";
checkIfSuccess($task, $FetchModel, "isAccountEmail", "admin@mail.com", "non-zero");

$task = "Check if non-existent email is registered to an account.";
checkIfSuccess($task, $FetchModel, "isAccountEmail", "sample@mail.com", "zero");

$task = "Check if blank email is registered to an account.";
checkIfSuccess($task, $FetchModel, "isAccountEmail", "", "zero");

$task = "Check if null email is registered to an account.";
checkIfSuccess($task, $FetchModel, "isAccountEmail", null, "zero");

$task = "Check if existing token is valid";
checkIfSuccess($task, $FetchModel, "isTokenValid", "678fcf69a6f5fa8d8f92bdf882aaeff3784cb2e084e74e9df75bfab3dee8548334bf902cc0c2c0d9bd13770e5299bf6438a1c69d4492ef5dab82a173d1c4bcd3", "non-zero");

$task = "Check if non-existent token is valid";
checkIfSuccess($task, $FetchModel, "isTokenValid", "", "zero");

$task = "Check if blank token is valid";
checkIfSuccess($task, $FetchModel, "isTokenValid", "", "zero");

$task = "Check if null token is valid";
checkIfSuccess($task, $FetchModel, "isTokenValid", null, "zero");

$task = "Fetch product names from array of existing ids";
checkIfSuccess($task, $FetchModel, "getProductNamesFromIds", [12, 15, 16, 17], "non-zero");

$task = "Fetch product names from array of non-existent ids";
checkIfSuccess($task, $FetchModel, "getProductNamesFromIds", [1, 2, 3], "zero");

$task = "Fetch product names from empty array";
checkIfSuccess($task, $FetchModel, "getProductNamesFromIds", [], "zero");

$task = "Fetch product names from string";
checkIfSuccess($task, $FetchModel, "getProductNamesFromIds", "banana", "zero");

$task = "Fetch product names from null";
checkIfSuccess($task, $FetchModel, "getProductNamesFromIds", null, "zero");

$task = "Fetch all active agent emails";
checkIfSuccess($task, $FetchModel, "agentEmails");