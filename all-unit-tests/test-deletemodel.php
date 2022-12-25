<?php

use Main\Models\DeleteModel;

include_once("../models/DeleteModel.php");
include_once("../Config.php");

class DeleteModelUT
{

    static private $testCount;
    static private $tests;


    function __construct()
    {
        self::$testCount = [
            "passed" => 0,
            "failed" => 0,
        ];

        self::$tests = [];
    }


    function getTestCount()
    {
        return self::$testCount;
    }


    function addTestCount($index)
    {
        self::$testCount[$index]++;
    }


    function getTests()
    {
        return self::$tests;
    }


    function setTests($tests)
    {
        self::$tests = $tests;
    }


    /**
     * Raises error. Shows input and output by default.
     * @param mixed $input data inputted for test
     * @param mixed $output result of test
     */
    function raiseError($input = null, $output = null)
    {
    }


    /**
     * Prints success.
     * @param mixed $input data inputted for test
     * @param mixed $output result of test
     * @param array $showIO accepts two inputs "showI" (set to true to display input), and "showO" (set to true to display output)
     */
    function printSuccess($input = null, $output = null, $showIO = ["showI" => false, "showO" => false])
    {
    }


    /**
     * Runs all tests in the Update Model.
     */
    function run()
    {
        $tests = self::getTests();


        $testName = "New delete instance";
        $testInput = [
            'host' => 'localhost',
            'username' => 'root',
            'password' => '',
            'db_name' => 'upcc_unit_tests',
        ];
        $testOutput = null;
        try {
            $DeleteModel = new DeleteModel($testInput);
            if (get_class($DeleteModel) === "Main\Models\DeleteModel") {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => get_class($DeleteModel), "status" => "passed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        $testName = "Users";
        $testInput = [
            1, 2,
        ];
        $testOutput = null;
        try {
            $testOutput = $DeleteModel->users(json_encode($testInput));
            if ($testOutput["status"] == 200) {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "passed"];
            } else {
                self::addTestCount("failed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        $testName = "Products";
        $testInput = [
            1, 2,
        ];
        $testOutput = null;
        try {
            $testOutput = $DeleteModel->products(json_encode($testInput));
            if ($testOutput["status"] == 200) {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "passed"];
            } else {
                self::addTestCount("failed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        $testName = "Product Types";
        $testInput = [
            1, 2,
        ];
        $testOutput = null;
        try {
            $testOutput = $DeleteModel->productTypes(json_encode($testInput));
            if ($testOutput["status"] == 200) {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "passed"];
            } else {
                self::addTestCount("failed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        $testName = "Client cart item";
        $testInput = [
            "id" => "1",
        ];
        $testOutput = null;
        try {
            $testOutput = $DeleteModel->clientCartItem($testInput);
            if ($testOutput["status"] == 200) {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "passed"];
            } else {
                self::addTestCount("failed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        $testName = "Orders";
        $testInput = [
            1, 2,
        ];
        $testOutput = null;
        try {
            $testOutput = $DeleteModel->orders(json_encode($testInput));
            if ($testOutput["status"] == 200) {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "passed"];
            } else {
                self::addTestCount("failed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        $testName = "Admin remove shops";
        $testInput = [
            1, 2,
        ];
        $testOutput = null;
        try {
            $testOutput = $DeleteModel->adminRemoveShops(json_encode($testInput));
            if ($testOutput["status"] == 200) {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "passed"];
            } else {
                self::addTestCount("failed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        self::setTests($tests);
    }
}
