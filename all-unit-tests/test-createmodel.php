<?php

use Main\Models\CreateModel;

include_once("../models/CreateModel.php");
include_once("../Config.php");

class CreateModelUT
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


        $testName = "New create instance";
        $testInput = [
            'host' => 'localhost',
            'username' => 'root',
            'password' => '',
            'db_name' => 'upcc_unit_tests',
        ];
        $testOutput = null;
        try {
            $CreateModel = new CreateModel($testInput);
            if (get_class($CreateModel) === "Main\Models\CreateModel") {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => get_class($CreateModel), "status" => "passed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        $testName = "User 1";
        $testInput = [
            "search-bar" => "",
            "first_name" => "Unit Test",
            "last_name" => "User 1",
            "company_name" => "Test Company",
            "email" => "unit-test@mail.com",
            "phone_number" => "09012345678",
            "password" => "unit-test",
            "confirm_password" => "unit-test",
            "company_nature" => "Test Nature",
            "company_address" => "Test Address",
        ];
        $testOutput = null;
        try {
            $testOutput = $CreateModel->user(json_encode($testInput));
            if ($testOutput["status"] == 200 || $testOutput["status"] == 409) {
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


        $_SESSION["type"] = "ADMIN";

        $testName = "Product types (product type 1)";
        $testInput = [
            "name" => "Product Type 1",
            "description" => "type 1",
        ];
        $testOutput = null;
        try {
            $testOutput = $CreateModel->productType(json_encode($testInput));
            if ($testOutput["status"] == 200 || $testOutput["status"] == 409) {
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


        $testName = "Product types (product type 2)";
        $testInput = [
            "name" => "Product Type 2",
            "description" => "type 2",
        ];
        $testOutput = null;
        try {
            $testOutput = $CreateModel->productType(json_encode($testInput));
            if ($testOutput["status"] == 200 || $testOutput["status"] == 409) {
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


        $testName = "Product 1";
        $testInput = [
            "name" => "Product 1",
            "material" => "Test Material",
            "brand" => "Test Brand",
            "connection_type" => "Test Connection Type",
            "length" => "10.01",
            "width" => "10.01",
            "thickness" => "10.01",
            "company_name" => "Test Company",
            "office_address" => "Test Address",
            "contact_number" => "Test Contact",
            "shop_id" => "1",
            "type_id" => "1",
            "unit-price" => "10.01",
        ];
        $testOutput = null;
        try {
            $testOutput = $CreateModel->product(json_encode($testInput));
            if ($testOutput["status"] == 200 || $testOutput["status"] == 400) {
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


        $testName = "Product 2";
        $testInput = [
            "name" => "Product 2",
            "material" => "Test Material",
            "brand" => "Test Brand",
            "connection_type" => "Test Connection Type",
            "length" => "10.01",
            "width" => "10.01",
            "thickness" => "10.01",
            "company_name" => "Test Company",
            "office_address" => "Test Address",
            "contact_number" => "Test Contact",
            "shop_id" => "1",
            "type_id" => "1",
            "unit-price" => "10.01",
        ];
        $testOutput = null;
        try {
            $testOutput = $CreateModel->product(json_encode($testInput));
            if ($testOutput["status"] == 200 || $testOutput["status"] == 400) {
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

        unset($_SESSION["type"]);


        $_SESSION["type"] = "AGENT";

        $testName = "Order 1";
        $testInput = [
            "user-email" => "unit-test@mail.com",
            "product-ids" => ["prod-1" => 1, "prod-2" => 1],
        ];
        $testOutput = null;
        try {
            $testOutput = $CreateModel->order(json_encode($testInput));
            if ($testOutput["status"] == 200 || $testOutput["status"] == 409) {
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


        $testName = "Order 2";
        $testInput = [
            "user-email" => "unit-test@mail.com",
            "product-ids" => ["prod-1" => 1, "prod-2" => 1],
        ];
        $testOutput = null;
        try {
            $testOutput = $CreateModel->order(json_encode($testInput));
            if ($testOutput["status"] == 200 || $testOutput["status"] == 409) {
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

        unset($_SESSION["type"]);


        $_SESSION["id"] = 1;
        $_SESSION["cart_count"] = 0;

        $testName = "Cart item 1";
        $testInput = [
            "product_id" => "1",
            "quantity" => "1",
        ];
        $testOutput = null;
        try {
            $testOutput = $CreateModel->cartItem($testInput);
            if ($testOutput["status"] == 200 || $testOutput["status"] == 409) {
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


        $testName = "Cart item 2";
        $testInput = [
            "product_id" => "2",
            "quantity" => "1",
        ];
        $testOutput = null;
        try {
            $testOutput = $CreateModel->cartItem($testInput);
            if ($testOutput["status"] == 200 || $testOutput["status"] == 409) {
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

        unset($_SESSION["id"], $_SESSION["cart_count"]);


        self::setTests($tests);
    }
}
