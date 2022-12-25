<?php

include_once("test-createmodel.php");
include_once("test-authmodel.php");
include_once("test-fetchmodel.php");
include_once("test-updatemodel.php");
include_once("test-deletemodel.php");

$CreateModelUT = new CreateModelUT();
$CreateModelUT->run();
$CreateTestCount = $CreateModelUT->getTestCount();
$CreateTests = $CreateModelUT->getTests();

$AuthModelUT = new AuthModelUT();
$AuthModelUT->run();
$AuthTestCount = $AuthModelUT->getTestCount();
$AuthTests = $AuthModelUT->getTests();

$FetchModelUT = new FetchModelUT();
$FetchModelUT->run();
$FetchTestCount = $FetchModelUT->getTestCount();
$FetchTests = $FetchModelUT->getTests();

$UpdateModelUT = new UpdateModelUT();
$UpdateModelUT->run();
$UpdateTestCount = $UpdateModelUT->getTestCount();
$UpdateTests = $UpdateModelUT->getTests();

$DeleteModelUT = new DeleteModelUt();
$DeleteModelUT->run();
$DeleteTestCount = $DeleteModelUT->getTestCount();
$DeleteTests = $DeleteModelUT->getTests();

$totalPassed = $FetchTestCount["passed"] + $UpdateTestCount["passed"] + $AuthTestCount["passed"] + $DeleteTestCount["passed"] + $CreateTestCount["passed"];
$totalFailed = $FetchTestCount["failed"] + $UpdateTestCount["failed"] + $AuthTestCount["failed"] + $DeleteTestCount["failed"] + $CreateTestCount["failed"];

$totalTestCount = $totalPassed + $totalFailed;

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Run Unit Tests | ISA</title>
    <style>
        body {
            background-color: #333;
            color: #e5e5e5;
            font-family: Arial, sans-serif;
        }

        section {
            display: block;
            padding: .5em 0;
        }

        .button:hover {
            background-color: rgb(10 140 140);
        }

        .boxed {
            background-color: #222;
            padding: .7em .7em;
            border-radius: .3em;
            display: inline-block;
            text-decoration: none;
            margin: .3em;
            word-wrap: break-word;
        }

        .block {
            display: block;
        }

        .button {
            background-color: rgb(30 150 150);
            padding: .7em 1em;
            border-radius: .3em;
            text-decoration: none;
        }

        .tests-container {
            display: none;
        }

        .failed {
            background-color: rgb(110 30 30);
        }

        .passed {
            background-color: rgb(30 110 30);
        }
    </style>
</head>

<body>
    <section>
        <h3 class="boxed block" style="width: fit-content;">Models Unit Tests</h3>
        <span class="boxed">Total Tests: <b><?= $totalTestCount ?></b></span>
        <span class="boxed">Successful Tests: <b><?= $totalPassed ?></b></span>
        <span class="boxed">Failed Tests: <b><?= $totalFailed ?></b></span>

        <i class="boxed block button" style="cursor: pointer; width: fit-content; background-color: rgb(30 150 150);" onclick="showCreate()">Click here to show Create Model tests</i>
        <div class="tests-container boxed block" id="create" style="background-color: #444;">
            <?php
            foreach ($CreateTests as $test) {
            ?>
                <div class="boxed block <?= $test["status"] === "passed" ? "passed" : "failed"; ?>">
                    <?=
                    "<b>Name: {$test['name']}</b><br>
                    Input: " . json_encode($test['input']) . "<br>
                    Output: " . json_encode($test['output']) . "<br>"
                    ?>
                </div>
            <?php
            }
            ?>
        </div>

        <i class="boxed block button" style="cursor: pointer; width: fit-content; background-color: rgb(30 150 150);" onclick="showAuth()">Click here to show Auth Model tests</i>
        <div class="tests-container boxed block" id="auth" style="background-color: #444;">
            <?php
            foreach ($AuthTests as $test) {
            ?>
                <div class="boxed block <?= $test["status"] === "passed" ? "passed" : "failed"; ?>">
                    <?=
                    "<b>Name: {$test['name']}</b><br>
                    Input: " . json_encode($test['input']) . "<br>
                    Output: " . json_encode($test['output']) . "<br>"
                    ?>
                </div>
            <?php
            }
            ?>
        </div>

        <i class="boxed block button" style="cursor: pointer; width: fit-content;" onclick="showFetch()">Click here to show Fetch Model tests</i>
        <div class="tests-container boxed block" id="fetch" style="background-color: #444;">
            <?php
            foreach ($FetchTests as $test) {
            ?>
                <div class="boxed block <?= $test["status"] === "passed" ? "passed" : "failed"; ?>">
                    <?=
                    "<b>Name: {$test['name']}</b><br>
                    Input: " . json_encode($test['input']) . "<br>
                    Output: " . json_encode($test['output']) . "<br>"
                    ?>
                </div>
            <?php
            }
            ?>
        </div>

        <i class="boxed block button" style="cursor: pointer; width: fit-content; background-color: rgb(30 150 150);" onclick="showUpdate()">Click here to show Update Model tests</i>
        <div class="tests-container boxed block" id="update" style="background-color: #444;">
            <?php
            foreach ($UpdateTests as $test) {
            ?>
                <div class="boxed block <?= $test["status"] === "passed" ? "passed" : "failed"; ?>">
                    <?=
                    "<b>Name: {$test['name']}</b><br>
                    Input: " . json_encode($test['input']) . "<br>
                    Output: " . json_encode($test['output']) . "<br>"
                    ?>
                </div>
            <?php
            }
            ?>
        </div>

        <i class="boxed block button" style="cursor: pointer; width: fit-content; background-color: rgb(30 150 150);" onclick="showDelete()">Click here to show Delete Model tests</i>
        <div class="tests-container boxed block" id="delete" style="background-color: #444;">
            <?php
            foreach ($DeleteTests as $test) {
            ?>
                <div class="boxed block <?= $test["status"] === "passed" ? "passed" : "failed"; ?>">
                    <?=
                    "<b>Name: {$test['name']}</b><br>
                    Input: " . json_encode($test['input']) . "<br>
                    Output: " . json_encode($test['output']) . "<br>"
                    ?>
                </div>
            <?php
            }
            ?>
        </div>

        <script>
            let createContainerStatus = false
            let authContainerStatus = false
            let fetchContainerStatus = false
            let updateContainerStatus = false
            let deleteContainerStatus = false

            function showCreate() {
                if (!createContainerStatus) {
                    document.querySelector('.tests-container#create').style.display = 'block'
                    createContainerStatus = true
                } else {
                    document.querySelector('.tests-container#create').style.display = 'none'
                    createContainerStatus = false
                }
            }


            function showAuth() {
                if (!authContainerStatus) {
                    document.querySelector('.tests-container#auth').style.display = 'block'
                    authContainerStatus = true
                } else {
                    document.querySelector('.tests-container#auth').style.display = 'none'
                    authContainerStatus = false
                }
            }


            function showFetch() {
                if (!fetchContainerStatus) {
                    document.querySelector('.tests-container#fetch').style.display = 'block'
                    fetchContainerStatus = true
                } else {
                    document.querySelector('.tests-container#fetch').style.display = 'none'
                    fetchContainerStatus = false
                }
            }


            function showUpdate() {
                if (!updateContainerStatus) {
                    document.querySelector('.tests-container#update').style.display = 'block'
                    updateContainerStatus = true
                } else {
                    document.querySelector('.tests-container#update').style.display = 'none'
                    updateContainerStatus = false
                }
            }


            function showDelete() {
                if (!deleteContainerStatus) {
                    document.querySelector('.tests-container#delete').style.display = 'block'
                    deleteContainerStatus = true
                } else {
                    document.querySelector('.tests-container#delete').style.display = 'none'
                    deleteContainerStatus = false
                }
            }
        </script>
</body>

</html>