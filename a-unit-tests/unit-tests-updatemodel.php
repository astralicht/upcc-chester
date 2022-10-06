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

$task = "";
checkIfSuccess($task, $UpdateModel, "");