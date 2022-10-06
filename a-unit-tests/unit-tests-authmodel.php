<?php

use Main\Models\AuthModel;

include_once "../vendor/autoload.php";
include_once "unit-test-tools.php";

$task = "New Auth model instance";
try {
    $AuthModel = new AuthModel;
    if (get_class($AuthModel) === "Main\Models\AuthModel") printSuccess($task);
} catch (Error $e) {
    printFailed($task);
    echo "<li>$e</li>";
}

$task = "Login existing user";
checkIfSuccess($task, $AuthModel, "login", json_encode(["email" => "juandc@gmail.com", "password" => "juandc"]));