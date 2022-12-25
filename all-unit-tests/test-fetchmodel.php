<?php

use Main\Models\FetchModel;

include_once("../models/FetchModel.php");
include_once("../Config.php");

class FetchModelUT {

    static private $testCount;
    static private $tests;

    
    function __construct() {
        self::$testCount = [
            "passed" => 0,
            "failed" => 0,
        ];

        self::$tests = [];
    }


    function getTestCount() {
        return self::$testCount;
    }


    function addTestCount($index) {
        self::$testCount[$index]++;
    }


    function getTests() {
        return self::$tests;
    }


    function setTests($tests) {
        self::$tests = $tests;
    }


    /**
     * Raises error. Shows input and output by default.
     * @param mixed $input data inputted for test
     * @param mixed $output result of test
     */
    function raiseError($input = null, $output = null) {

    }


    /**
     * Prints success.
     * @param mixed $input data inputted for test
     * @param mixed $output result of test
     * @param array $showIO accepts two inputs "showI" (set to true to display input), and "showO" (set to true to display output)
     */
    function printSuccess($input = null, $output = null, $showIO = ["showI" => false, "showO" => false]) {

    }


    /**
     * Runs all tests in the Fetch Model.
     */
    function run() {
        $tests = self::getTests();


        $testName = "New fetch instance";
        $testInput = [
            'host' => 'localhost',
            'username' => 'root',
            'password' => '',
            'db_name' => 'upcc_unit_tests',
        ];
        $testOutput = null;
        try {
            $FetchModel = new FetchModel($testInput);
            if (get_class($FetchModel) === "Main\Models\FetchModel") {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => get_class($FetchModel), "status" => "passed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        $testName = "Users count";
        $testInput = null;
        $testOutput = null;
        try {
            $testOutput = $FetchModel->usersCount();
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


        $testName = "Products count";
        $testInput = null;
        $testOutput = null;
        try {
            $testOutput = $FetchModel->productsCount();
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


        $testName = "Orders count";
        $testInput = null;
        $testOutput = null;
        try {
            $testOutput = $FetchModel->ordersCount();
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


        $_SESSION["id"] = 1;
        $testName = "Cart items count";
        $testInput = null;
        $testOutput = null;
        try {
            $testOutput = $FetchModel->cartItemsCount();
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
        unset($_SESSION["id"]);


        $testName = "Users";
        $testInput = [
            "filter" => "",
            "page" => 0,
            "limit" => 25,
        ];
        $testOutput = null;
        try {
            $testOutput = $FetchModel->users($testInput);
            if ($testOutput["status"] == 200) {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "passed"];
            } else {
                self::addTestCount("failed");
                $testOutput = $e;
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        $testName = "Products";
        $testInput = [
            "filter" => "",
            "brand" => "",
            "typeid" => "",
            "page" => 0,
            "limit" => 25,
        ];
        $testOutput = null;
        try {
            $testOutput = $FetchModel->products($testInput);
            if ($testOutput["status"] == 200) {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "passed"];
            } else {
                self::addTestCount("failed");
                $testOutput = $e;
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        $testName = "Products filter only";
        $testInput = [
            "filter" => "",
            "page" => 0,
            "limit" => 25,
        ];
        $testOutput = null;
        try {
            $testOutput = $FetchModel->products($testInput);
            if ($testOutput["status"] == 200) {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "passed"];
            } else {
                self::addTestCount("failed");
                $testOutput = $e;
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        $testName = "All product ids";
        $testInput = null;
        $testOutput = null;
        try {
            $testOutput = $FetchModel->allProductIds();
            if ($testOutput["status"] == 200) {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "passed"];
            } else {
                self::addTestCount("failed");
                $testOutput = $e;
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        $testName = "All products complete";
        $testInput = null;
        $testOutput = null;
        try {
            $testOutput = $FetchModel->allProductsComplete();
            if ($testOutput["status"] == 200) {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "passed"];
            } else {
                self::addTestCount("failed");
                $testOutput = $e;
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        $testName = "Product details complete";
        $testInput = 1;
        $testOutput = null;
        try {
            $testOutput = $FetchModel->allProductsComplete();
            if ($testOutput["status"] == 200) {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "passed"];
            } else {
                self::addTestCount("failed");
                $testOutput = $e;
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        $testName = "All orders";
        $testInput = [
            "filter" => "",
            "page" => 0,
            "limit" => 25,
        ];
        $testOutput = null;
        try {
            $testOutput = $FetchModel->allOrders($testInput);
            if ($testOutput["status"] == 200) {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "passed"];
            } else {
                self::addTestCount("failed");
                $testOutput = $e;
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        $_SESSION["id"] = 1;
        $testName = "Client orders";
        $testInput = null;
        $testOutput = null;
        try {
            $testOutput = $FetchModel->clientOrders();
            if ($testOutput["status"] == 200) {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "passed"];
            } else {
                self::addTestCount("failed");
                $testOutput = $e;
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }
        unset($_SESSION["id"]);


        // $testName = "Orders with products";
        // $testInput = [
        //     "filter" => "",
        //     "page" => 0,
        //     "limit" => 25,
        // ];
        // $testOutput = null;
        // try {
        //     $testOutput = $FetchModel->ordersWithProducts($testInput);
        //     if ($testOutput["status"] == 200) {
        //         self::addTestCount("passed");
        //         $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "passed"];
        //     } else {
        //         self::addTestCount("failed");
        //         $testOutput = $e;
        //         $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        //     }
        // } catch (Error $e) {
        //     self::addTestCount("failed");
        //     $testOutput = $e;
        //     $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        // }


        $testName = "Order";
        $testInput = [
            "id" => 1,
        ];
        $testOutput = null;
        try {
            $testOutput = $FetchModel->order($testInput);
            if ($testOutput["status"] == 200) {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "passed"];
            } else {
                self::addTestCount("failed");
                $testOutput = $e;
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        $testName = "Company natures";
        $testInput = null;
        $testOutput = null;
        try {
            $testOutput = $FetchModel->companyNatures();
            if ($testOutput["status"] == 200) {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "passed"];
            } else {
                self::addTestCount("failed");
                $testOutput = $e;
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        $testName = "Product";
        $testInput = [
            "id" => 1,
        ];
        $testOutput = null;
        try {
            $testOutput = $FetchModel->product($testInput);
            if ($testOutput["status"] == 200) {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "passed"];
            } else {
                self::addTestCount("failed");
                $testOutput = $e;
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        $testName = "User";
        $testInput = [
            "id" => 1,
        ];
        $testOutput = null;
        try {
            $testOutput = $FetchModel->user($testInput);
            if ($testOutput["status"] == 200) {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "passed"];
            } else {
                self::addTestCount("failed");
                $testOutput = $e;
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        $testName = "Product types";
        $testInput = [
            "filter" => "",
            "page" => 0,
            "limit" => 25,
        ];
        $testOutput = null;
        try {
            $testOutput = $FetchModel->productTypes($testInput);
            if ($testOutput["status"] == 200) {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "passed"];
            } else {
                self::addTestCount("failed");
                $testOutput = $e;
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        $testName = "Product types all";
        $testInput = null;
        $testOutput = null;
        try {
            $testOutput = $FetchModel->productTypesAll();
            if ($testOutput["status"] == 200) {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "passed"];
            } else {
                self::addTestCount("failed");
                $testOutput = $e;
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        $testName = "Client cart";
        $testInput = [
            "client_id" => 1,
        ];
        $testOutput = null;
        try {
            $testOutput = $FetchModel->clientCart($testInput);
            if ($testOutput["status"] == 200) {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "passed"];
            } else {
                self::addTestCount("failed");
                $testOutput = $e;
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        $testName = "Types and brands";
        $testInput = null;
        $testOutput = null;
        try {
            $testOutput = $FetchModel->typesAndBrands();
            if ($testOutput["status"] == 200) {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "passed"];
            } else {
                self::addTestCount("failed");
                $testOutput = $e;
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        $testName = "Is account email";
        $testInput = [
            "email" => "kizuminato@gmail.com",
        ];
        $testOutput = null;
        try {
            $testOutput = $FetchModel->isAccountEmail($testInput);
            if ($testOutput["status"] == 200) {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "passed"];
            } else {
                self::addTestCount("failed");
                $testOutput = $e;
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        $testName = "Get product names from ids";
        $testInput = [
            1, 2, 3
        ];
        $testOutput = null;
        try {
            $testOutput = $FetchModel->getProductNamesFromIds($testInput);
            if ($testOutput["status"] == 200) {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "passed"];
            } else {
                self::addTestCount("failed");
                $testOutput = $e;
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        $testName = "Agent emails";
        $testInput = null;
        $testOutput = null;
        try {
            $testOutput = $FetchModel->agentEmails();
            if ($testOutput["status"] == 200) {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "passed"];
            } else {
                self::addTestCount("failed");
                $testOutput = $e;
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        $testName = "Previous ordered products";
        $testInput = 10;
        $testOutput = null;
        try {
            $testOutput = $FetchModel->previousOrderedProducts($testInput);
            if ($testOutput["status"] == 200) {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "passed"];
            } else {
                self::addTestCount("failed");
                $testOutput = $e;
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        $testName = "Featured products";
        $testInput = 10;
        $testOutput = null;
        try {
            $testOutput = $FetchModel->featuredProducts($testInput);
            if ($testOutput["status"] == 200) {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "passed"];
            } else {
                self::addTestCount("failed");
                $testOutput = $e;
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        $testName = "Featured shops";
        $testInput = 10;
        $testOutput = null;
        try {
            $testOutput = $FetchModel->featuredShops($testInput);
            if ($testOutput["status"] == 200) {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "passed"];
            } else {
                self::addTestCount("failed");
                $testOutput = $e;
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        $testName = "Shops";
        $testInput = null;
        $testOutput = null;
        try {
            $testOutput = $FetchModel->shops();
            if ($testOutput["status"] == 200) {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "passed"];
            } else {
                self::addTestCount("failed");
                $testOutput = $e;
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        $testName = "Admin shops";
        $testInput = [
            "filter" => "",
            "limit" => 25,
        ];
        $testOutput = null;
        try {
            $testOutput = $FetchModel->adminShops($testInput);
            if ($testOutput["status"] == 200) {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "passed"];
            } else {
                self::addTestCount("failed");
                $testOutput = $e;
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        $testName = "Shops count";
        $testInput = null;
        $testOutput = null;
        try {
            $testOutput = $FetchModel->shopsCount();
            if ($testOutput["status"] == 200) {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "passed"];
            } else {
                self::addTestCount("failed");
                $testOutput = $e;
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        $testName = "Shop";
        $testInput = [
            "id" => 1,
        ];
        $testOutput = null;
        try {
            $testOutput = $FetchModel->shop($testInput);
            if ($testOutput["status"] == 200) {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "passed"];
            } else {
                self::addTestCount("failed");
                $testOutput = $e;
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        $testName = "Shop products";
        $testInput = 1;
        $testOutput = null;
        try {
            $testOutput = $FetchModel->shopProducts($testInput);
            if ($testOutput["status"] == 200) {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "passed"];
            } else {
                self::addTestCount("failed");
                $testOutput = $e;
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        $testName = "Shop rating";
        $testInput = 1;
        $testOutput = null;
        try {
            $testOutput = $FetchModel->shopRating($testInput);
            if ($testOutput["status"] == 200) {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "passed"];
            } else {
                self::addTestCount("failed");
                $testOutput = $e;
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        $testName = "Items sold";
        $testInput = 1;
        $testOutput = null;
        try {
            $testOutput = $FetchModel->itemsSold($testInput);
            if ($testOutput["status"] == 200) {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "passed"];
            } else {
                self::addTestCount("failed");
                $testOutput = $e;
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        $testName = "Shop products count";
        $testInput = 1;
        $testOutput = null;
        try {
            $testOutput = $FetchModel->shopProductsCount($testInput);
            if ($testOutput["status"] == 200) {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "passed"];
            } else {
                self::addTestCount("failed");
                $testOutput = $e;
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        $testName = "Notifications";
        $testInput = [
            "user_id"=> 1,
        ];
        $testOutput = null;
        try {
            $testOutput = $FetchModel->notificationsAll($testInput);
            if ($testOutput["status"] == 200) {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "passed"];
            } else {
                self::addTestCount("failed");
                $testOutput = $e;
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
            }
        } catch (Error $e) {
            self::addTestCount("failed");
            $testOutput = $e;
            $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "failed"];
        }


        $testName = "Notifications unread";
        $testInput = [
            "user_id" => 1,
        ];
        $testOutput = null;
        try {
            $testOutput = $FetchModel->notificationsUnread($testInput);
            if ($testOutput["status"] == 200) {
                self::addTestCount("passed");
                $tests[] = ["name" => $testName, "input" => $testInput, "output" => $testOutput, "status" => "passed"];
            } else {
                self::addTestCount("failed");
                $testOutput = $e;
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