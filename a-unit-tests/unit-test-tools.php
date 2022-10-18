<?php

function printSuccess($task) { echo "<style>* {color: #e5e5e5; font-family: Segoe UI;} body {background-color: #333}</style><br>$task: <span style='background-color: green; color: #f5f5f5; height: 1em; width: 1em; display: inline-block; border-radius: 100%;'></span>"; }
function printFailed($task) { echo "<style>* {color: #e5e5e5; font-family: Segoe UI;} body {background-color: #333}</style><br>$task: <span style='background-color: red; color: #f5f5f5; height: 1em; width: 1em; display: inline-block; border-radius: 100%;'></span>"; }
function checkIfSuccess($task, $class, $method, $params = [], $otherConditions = true) {
    try {
        if (!empty($params)) {
            if (gettype($params) === "string" && $params !== "") {
                $response = $class->$method($params);
            }
            else if (isset($params["options"]) && $params["options"] === "MULTIPLE") {
                unset($params["options"]);
                $response = call_user_func_array(array($class, $method), $params);
            } else {
                $response = $class->$method($params);
            }
        }
        else  {
            $response = $class->$method();
        }

        if ($otherConditions === "non-zero") $otherConditions = count($response["rows"]) > 0;
        else if ($otherConditions === "zero") $otherConditions = count($response["rows"]) < 1;

        if ($response["status"] === 200 && $otherConditions) printSuccess($task);
        else {
            printFailed($task);
            echo "<li>".$response["message"]."</li>";
        }
    } catch(mysqli_sql_exception $e) {
        printFailed($task);
        echo "<li>$e</li>";
    } catch(Error $e) {
        printFailed($task);
        echo "<li>$e</li>";
    }
}
