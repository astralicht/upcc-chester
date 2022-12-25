<?php

use Main\Models\UpdateModel;

include_once("../models/UpdateModel.php");
include_once("../models/CreateModel.php");
include_once("../Config.php");

class UpdateModelUT
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


        $testName = "New update instance";
        $testInput = [
            'host' => 'localhost',
            'username' => 'root',
            'password' => '',
            'db_name' => 'upcc_unit_tests',
        ];
        $testOutput = null;
        try {
            $UpdateModel = new UpdateModel($testInput);
            if (get_class($UpdateModel) === "Main\Models\UpdateModel") {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => get_class($UpdateModel), "status" => "passed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        $testName = "Client Info";
        $testInput = [
            "Unit", "Test", "Company Name", "Company Address", "09012345678", "Company Nature", 1
        ];
        $testOutput = null;
        try {
            $testOutput = $UpdateModel->clientInfo(json_encode($testInput));
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


        $testName = "Order status";
        $testInput = [
            "redirect_flag" => false,
            "order_id" => 1,
            "status" => "DELIVERED",
        ];
        $testOutput = null;
        try {
            $testOutput = $UpdateModel->orderStatus(json_encode($testInput));
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


        $testName = "Update image data (user)";
        $testInput = null;
        $testOutput = null;
        try {
            $testOutput = $UpdateModel->updateImageData("uploads/img/test.jpg", "Test Image", "USER", "1");
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


        $testName = "Update image data (product)";
        $testInput = null;
        $testOutput = null;
        try {
            $testOutput = $UpdateModel->updateImageData("uploads/img/test.jpg", "Test Image", "PRODUCT", "1");
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


        $testName = "Product";
        $testInput = [
            "image-input" => "",
            "image-type" => "",
            "old-image-path" => "",
            "unit-price" => "10.01",
            "product-id" => "1",
            "name" => "Test Product",
            "material" => "Test Material",
            "brand" => "Test Brand",
            "connection_type" => "Test Connection Type",
            "length" => "5",
            "width" => "5",
            "thickness" => "5",
            "company_name" => "Test Company",
            "office_address" => "Test Company Address",
            "contact_number" => "Test Company Contact",
            "type_id" => "1",
            "shop_id" => "1",
        ];
        $testOutput = null;
        try {
            $testOutput = $UpdateModel->product(json_encode($testInput));
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


        $_SESSION["email-for-password-reset"] = "unit-test@mail.com";
        $testName = "Password";
        $testInput = "newpassword";
        $testOutput = null;
        try {
            $testOutput = $UpdateModel->password($testInput);
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
        unset($_SESSION["email-for-password-reset"]);


        $testName = "Products clicks";
        $testInput = "1";
        $testOutput = null;
        try {
            $testOutput = $UpdateModel->productClicks($testInput);
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


        $testName = "Admin info";
        $testInput = [
            "Test Admin",
            "Account",
            "Test Company",
            "Test Company Address",
            "Test Company Contact",
            "Test Company Nature",
            "1",
        ];
        $testOutput = null;
        try {
            $testOutput = $UpdateModel->adminInfo(json_encode($testInput));
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


        $testName = "Notifications mark all as read";
        $testInput = [
            "user_id" => "1",
        ];
        $testOutput = null;
        try {
            $testOutput = $UpdateModel->notificationsMarkAllRead($testInput, "TEST");
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


        $testName = "Admin edit shop";
        $testInput = [
            "name" => "Test Shop 1",
            "id" => "1",
        ];
        $testOutput = null;
        try {
            $testOutput = $UpdateModel->adminEditShop(json_encode($testInput));
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


        $testName = "User email status";
        $testInput = "unit-test@mail.com";
        $testOutput = null;
        try {
            $testOutput = $UpdateModel->userEmailStatus($testInput);
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
