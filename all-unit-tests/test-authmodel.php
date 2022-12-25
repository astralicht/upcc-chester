<?php

use Main\Models\AuthModel;

include_once("../models/AuthModel.php");
include_once("../Config.php");

class AuthModelUT
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


        $testName = "New auth instance";
        $testInput = [
            'host' => 'localhost',
            'username' => 'root',
            'password' => '',
            'db_name' => 'upcc_unit_tests',
        ];
        $testOutput = null;
        try {
            $AuthModel = new AuthModel($testInput);
            if (get_class($AuthModel) === "Main\Models\AuthModel") {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => get_class($AuthModel), "status" => "passed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        $testName = "User login";
        $testInput = [
            "email" => "unit-test@mail.com",
            "password" => "unit-test",
        ];
        $testOutput = null;
        try {
            $testOutput = $AuthModel->login(json_encode($testInput));
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
