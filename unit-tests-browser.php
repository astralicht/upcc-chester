<?php

use Main\Controllers\RecommendationController;
use Main\Models\FetchModel;

include_once "vendor/autoload.php";

function printSuccess($task) { echo "<br>$task: <span style='background-color: green; color: #f5f5f5; padding: .05em;'>SUCCESS</span>"; }
function printFailed($task) { echo "<br>$task: <span style='background-color: red; color: #f5f5f5; padding: .05em;'>FAILED</span>"; }

/**
 * Fetch model
 */

 // New fetch instance
$task = "New fetch instance";
try {
    $FetchModel = new FetchModel();
    if (get_class($FetchModel) === "Main\Models\FetchModel") printSuccess($task);
} catch (Error $e) {
    printFailed($task);
    echo "<li>$e</li>";
}

// Fetch all users
$task = "Fetch all users";
try {
    if($FetchModel->getResult("SELECT * FROM users")["status"] === 200) printSuccess($task);
} catch(mysqli_sql_exception $e) {
    printFailed($task);
    echo "<li>$e</li>";
} catch(Error $e) {
    printFailed($task);
    echo "<li>$e</li>";
}

// Fetch all users count
$task = "Fetch all users count";
try {
    if($FetchModel->usersCount()["status"] === 200) printSuccess($task);
} catch(mysqli_sql_exception $e) {
    printFailed($task);
    echo "<li>$e</li>";
} catch(Error $e) {
    printFailed($task);
    echo "<li>$e</li>";
}

// Fetch all products count
$task = "Fetch all products count";
try {
    if($FetchModel->usersCount()["status"] === 200) printSuccess($task);
} catch(mysqli_sql_exception $e) {
    printFailed($task);
    echo "<li>$e</li>";
} catch(Error $e) {
    printFailed($task);
    echo "<li>$e</li>";
}

// Fetch all orders count
$task = "Fetch all orders count";
try {
    if($FetchModel->ordersCount()["status"] === 200) printSuccess($task);
} catch(mysqli_sql_exception $e) {
    printFailed($task);
    echo "<li>$e</li>";
} catch(Error $e) {
    printFailed($task);
    echo "<li>$e</li>";
}

// Fetch all cart items count
$task = "Fetch all cart items count";
try {
    if($FetchModel->cartItemsCount()["status"] === 200) printSuccess($task);
} catch(mysqli_sql_exception $e) {
    printFailed($task);
    echo "<li>$e</li>";
} catch(Error $e) {
    printFailed($task);
    echo "<li>$e</li>";
}

// Fetch all users without filter
$task = "Fetch all users without filter";
try {
    if($FetchModel->users([
        "filter" => "",
        "page" => "0",
        "limit" => "20",
    ])["status"] === 200) printSuccess($task);
} catch(mysqli_sql_exception $e) {
    printFailed($task);
    echo "<li>$e</li>";
} catch(Error $e) {
    printFailed($task);
    echo "<li>$e</li>";
}

// Fetch all users with existing 'User' filter
$task = "Fetch all users with existing 'User' filter";
try {
    $filter = "User";
    $response = $FetchModel->users([
        "filter" => $filter,
        "page" => "0",
        "limit" => "20",
    ]);
    if($response["status"] === 200 && count($response["rows"]) > 0) printSuccess($task);
} catch(mysqli_sql_exception $e) {
    printFailed($task);
    echo "<li>$e</li>";
} catch(Error $e) {
    printFailed($task);
    echo "<li>$e</li>";
}

// Fetch all users with non-existent 'banana' filter
$task = "Fetch all users with non-existent 'banana' filter";
try {
    $filter = "banana";
    $response = $FetchModel->users([
        "filter" => $filter,
        "page" => "0",
        "limit" => "20",
    ]);
    if($response["status"] === 200 && count($response["rows"]) < 1) printSuccess($task);
} catch(mysqli_sql_exception $e) {
    printFailed($task);
    echo "<li>$e</li>";
} catch(Error $e) {
    printFailed($task);
    echo "<li>$e</li>";
}


/**
 * Recommendation Engine
 */

// New rec controller instance
$task = "New rec controller instance";
try {
    $RecController = new RecommendationController();
    if (get_class($RecController) === "Main\Controllers\RecommendationController") printSuccess($task);
} catch (Error $e) {
    printFailed($task);
    echo "<li>$e</li>";
}

// Get cookies
$task = "Get cookies";
try {
    $RecController = new RecommendationController();
    $cookies = $RecController->getCookies();
    if (gettype($cookies) === "array") printSuccess($task);
} catch (Error $e) {
    printFailed($task);
    echo "<li>$e</li>";
}

// Create a new cookie containing null values, and with a 30-second expiration.
$task = "New null-valued, 30-second cookie";
try {
    $RecController = new RecommendationController();
    $cookies = $RecController->getCookies();
    $count = count($cookies);
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
        time()+30,
        "/"
    );
    $newCount = count($cookies);
    $diff = $newCount - $count;
    if ($diff > 0) printSuccess($task);
    var_dump($diff);
} catch (Error $e) {
    printFailed($task);
    echo "<li>$e</li>";
}


/**
 * Fetch model (continuation)
 */

// Fetch all products without filter
$task = "Fetch all products without filter";
try {
    $filter = "";
    $brand = "";
    $typeId = "";
    $response = $FetchModel->products([
        "filter" => $filter,
        "brand" => $brand,
        "typeid" => $typeId,
        "page" => "0",
        "limit" => "20",
    ]);
    if($response["status"] === 200) printSuccess($task);
} catch(mysqli_sql_exception $e) {
    printFailed($task);
    echo "<li>$e</li>";
} catch(Error $e) {
    printFailed($task);
    echo "<li>$e</li>";
}