<?php

use Main\Controllers\RecommendationController;
use Main\Models\FetchModel;

include_once "vendor/autoload.php";

function printSuccess($task) { echo "<style>* {color: #e5e5e5; font-family: Segoe UI;} body {background-color: #333}</style><br>$task: <span style='background-color: green; color: #f5f5f5; height: 1em; width: 1em; display: inline-block; border-radius: 100%;'></span>"; }
function printFailed($task) { echo "<style>* {color: #e5e5e5; font-family: Segoe UI;} body {background-color: #333}</style><br>$task: <span style='background-color: red; color: #f5f5f5; height: 1em; width: 1em; display: inline-block; border-radius: 100%;'></span>"; }

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
try {
    if ($FetchModel->getResult("SELECT * FROM users")["status"] === 200) printSuccess($task);
    else {
        printFailed($task);
        echo "<br><br><li>".$response["message"]."</li>";
    }
} catch(mysqli_sql_exception $e) {
    printFailed($task);
    echo "<li>$e</li>";
} catch(Error $e) {
    printFailed($task);
    echo "<li>$e</li>";
}


$task = "Fetch all users count";
try {
    if ($FetchModel->usersCount()["status"] === 200) printSuccess($task);
    else {
        printFailed($task);
        echo "<br><br><li>".$response["message"]."</li>";
    }
} catch(mysqli_sql_exception $e) {
    printFailed($task);
    echo "<li>$e</li>";
} catch(Error $e) {
    printFailed($task);
    echo "<li>$e</li>";
}


$task = "Fetch all products count";
try {
    if ($FetchModel->usersCount()["status"] === 200) printSuccess($task);
    else {
        printFailed($task);
        echo "<br><br><li>".$response["message"]."</li>";
    }
} catch(mysqli_sql_exception $e) {
    printFailed($task);
    echo "<li>$e</li>";
} catch(Error $e) {
    printFailed($task);
    echo "<li>$e</li>";
}


$task = "Fetch all orders count";
try {
    if ($FetchModel->ordersCount()["status"] === 200) printSuccess($task);
    else {
        printFailed($task);
        echo "<br><br><li>".$response["message"]."</li>";
    }
} catch(mysqli_sql_exception $e) {
    printFailed($task);
    echo "<li>$e</li>";
} catch(Error $e) {
    printFailed($task);
    echo "<li>$e</li>";
}


$task = "Fetch all cart items count";
try {
    if ($FetchModel->cartItemsCount()["status"] === 200) printSuccess($task);
    else {
        printFailed($task);
        echo "<br><br><li>".$response["message"]."</li>";
    }
} catch(mysqli_sql_exception $e) {
    printFailed($task);
    echo "<li>$e</li>";
} catch(Error $e) {
    printFailed($task);
    echo "<li>$e</li>";
}


$task = "Fetch all users without filter";
try {
    if ($FetchModel->users([
        "filter" => "",
        "page" => "0",
        "limit" => "20",
    ])["status"] === 200) printSuccess($task);
    else {
        printFailed($task);
        echo "<br><br><li>".$response["message"]."</li>";
    }
} catch(mysqli_sql_exception $e) {
    printFailed($task);
    echo "<li>$e</li>";
} catch(Error $e) {
    printFailed($task);
    echo "<li>$e</li>";
}


$task = "Fetch all users with existing 'User' filter";
try {
    $filter = "User";
    $response = $FetchModel->users([
        "filter" => $filter,
        "page" => "0",
        "limit" => "20",
    ]);
    if ($response["status"] === 200 && count($response["rows"]) > 0) printSuccess($task);
    else {
        printFailed($task);
        echo "<br><br><li>".$response["message"]."</li>";
    }
} catch(mysqli_sql_exception $e) {
    printFailed($task);
    echo "<li>$e</li>";
} catch(Error $e) {
    printFailed($task);
    echo "<li>$e</li>";
}


$task = "Fetch all users with non-existent 'banana' filter";
try {
    $filter = "banana";
    $response = $FetchModel->users([
        "filter" => $filter,
        "page" => "0",
        "limit" => "20",
    ]);
    if ($response["status"] === 200 && count($response["rows"]) < 1) printSuccess($task);
    else {
        printFailed($task);
        echo "<br><br><li>".$response["message"]."</li>";
    }
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
    if ($response["status"] === 200) printSuccess($task);
    else {
        printFailed($task);
        echo "<br><br><li>".$response["message"]."</li>";
    }
} catch(mysqli_sql_exception $e) {
    printFailed($task);
    echo "<li>$e</li>";
} catch(Error $e) {
    printFailed($task);
    echo "<li>$e</li>";
}


$task = "Fetch products with existing filter only (no other params)";
try {
    $filter = "pipe";
    $response = $FetchModel->productsFilterOnly(["filter" => $filter]);
    if ($response["status"] === 200 && count($response["rows"]) > 0) printSuccess($task);
    else {
        printFailed($task);
        echo "<br><br><li>".$response["message"]."</li>";
    }
} catch (mysqli_sql_exception $e) {
    printFailed($task);
    echo "<li>$e</li>";
} catch (Error $e) {
    printFailed($task);
    echo "<li>$e</li>";
}


$task = "Fetch products with empty filter only (no other params)";
try {
    $filter = "";
    $response = $FetchModel->productsFilterOnly(["filter" => $filter]);
    if ($response["status"] === 200 && count($response["rows"]) > 0) printSuccess($task);
    else {
        printFailed($task);
        echo "<br><br><li>".$response["message"]."</li>";
    }
} catch (mysqli_sql_exception $e) {
    printFailed($task);
    echo "<li>$e</li>";
} catch (Error $e) {
    printFailed($task);
    echo "<li>$e</li>";
}


$task = "Fetch products with null filter only (no other params)";
try {
    $filter = null;
    $response = $FetchModel->productsFilterOnly(["filter" => $filter]);
    if ($response["status"] === 200 && count($response["rows"]) > 0) printSuccess($task);
    else {
        printFailed($task);
        echo "<br><br><li>".$response["message"]."</li>";
    }
} catch (mysqli_sql_exception $e) {
    printFailed($task);
    echo "<li>$e</li>";
} catch (Error $e) {
    printFailed($task);
    echo "<li>$e</li>";
}


$task = "Fetch all product ids";
try {
    $response = $FetchModel->allProductIds();
    if ($response["status"] === 200) printSuccess($task);
    else {
        printFailed($task);
        echo "<br><br><li>".$response["message"]."</li>";
    }
} catch (mysqli_sql_exception $e) {
    printFailed($task);
    echo "<li>$e</li>";
} catch (Error $e) {
    printFailed($task);
    echo "<li>$e</li>";
}


$task = "Fetch all products complete";
try {
    $response = $FetchModel->allProductsComplete();
    if ($response["status"] === 200) printSuccess($task);
    else {
        printFailed($task);
        echo "<br><br><li>".$response["message"]."</li>";
    }
} catch (mysqli_sql_exception $e) {
    printFailed($task);
    echo "<li>$e</li>";
} catch (Error $e) {
    printFailed($task);
    echo "<li>$e</li>";
}


$task = "Fetch all specific product details complete with existing id";
try {
    $id = "1";
    $response = $FetchModel->productDetailsComplete($id);
    if ($response["status"] === 200) printSuccess($task);
    else {
        printFailed($task);
        echo "<br><br><li>".$response["message"]."</li>";
    }
} catch (mysqli_sql_exception $e) {
    printFailed($task);
    echo "<li>$e</li>";
} catch (Error $e) {
    printFailed($task);
    echo "<li>$e</li>";
}


$task = "Fetch all specific product details complete with blank id";
try {
    $id = "";
    $response = $FetchModel->productDetailsComplete($id);
    if ($response["status"] === 200) printSuccess($task);
    else {
        printFailed($task);
        echo "<br><br><li>".$response["message"]."</li>";
    }
} catch (mysqli_sql_exception $e) {
    printFailed($task);
    echo "<li>$e</li>";
} catch (Error $e) {
    printFailed($task);
    echo "<li>$e</li>";
}


$task = "Fetch all specific product details complete with null id";
try {
    $id = null;
    $response = $FetchModel->productDetailsComplete($id);
    if ($response["status"] === 200) printSuccess($task);
    else {
        printFailed($task);
        echo "<br><br><li>".$response["message"]."</li>";
    }
} catch (mysqli_sql_exception $e) {
    printFailed($task);
    echo "<li>$e</li>";
} catch (Error $e) {
    printFailed($task);
    echo "<li>$e</li>";
}


$task = "Fetch specfic user with existing id";
try {
    $response = $FetchModel->getResult("SELECT * FROM users WHERE `id`=?", ["1"]);
    if ($response["status"] === 200 && count($response["rows"]) > 0) printSuccess($task);
    else {
        printFailed($task);
        echo "<br><br><li>".$response["message"]."</li>";
    }
} catch (mysqli_sql_exception $e) {
    printFailed($task);
    echo "<li>$e</li>";
} catch (Error $e) {
    printFailed($task);
    echo "<li>$e</li>";
}


$task = "Fetch specfic user with blank id";
try {
    $response = $FetchModel->getResult("SELECT * FROM users WHERE `id`=?", ["214"]);
    if ($response["status"] === 200 && count($response["rows"]) < 1) printSuccess($task);
    else {
        printFailed($task);
        echo "<br><br><li>".$response["message"]."</li>";
    }
} catch (mysqli_sql_exception $e) {
    printFailed($task);
    echo "<li>$e</li>";
} catch (Error $e) {
    printFailed($task);
    echo "<li>$e</li>";
}


$task = "Fetch specfic user with null id";
try {
    $response = $FetchModel->getResult("SELECT * FROM users WHERE `id`=?", [null]);
    if ($response["status"] === 200 && count($response["rows"]) < 1) printSuccess($task);
    else {
        printFailed($task);
        echo "<br><br><li>".$response["message"]."</li>";
    }
} catch (mysqli_sql_exception $e) {
    printFailed($task);
    echo "<li>$e</li>";
} catch (Error $e) {
    printFailed($task);
    echo "<li>$e</li>";
}