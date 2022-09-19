<?php
namespace Main\Controllers;

use Main\Models\AuthModel;
use Main\Models\FetchModel;

session_start();

class AuthController {

    function login($data) { 
        $response = (new AuthModel)->login($data);

        if ($response["status"] === 401) return [
            "status" => 401,
            "message" => "401 Unauthorized. Please try again."
        ];

        if ($response["status"] === 404) {
            return [
                "status" => 404,
                "message" => "User does not exist."
            ];
        }

        if ($response["status"] === 200) {
            $userDetails = $response["user"];

            $_SESSION["id"] = $userDetails["id"];
            $_SESSION["first_name"] = $userDetails["first_name"];
            $_SESSION["last_name"] = $userDetails["last_name"];
            $_SESSION["type"] = $userDetails["type"];
            $_SESSION["dp_path"] = $userDetails["dp_path"];

            $FetchController = new FetchController();
            $cart_items_count = $FetchController->cartItemsCount()["rows"][0]["cart_items_count"];

            $_SESSION["cart_count"] = $cart_items_count;

            return [
                "status" => 200,
                "message" => "200 Login success."
            ];
        }

        return [
            "status" => 500,
            "message" => "500 Internal Error. Please consult with the IT administrator."
        ];
    }


    function logout() {
        unset($_SESSION);
        session_destroy();
        header("Location: ../login/index");
    }


    function loginRedirect() {
        if (!isset($_SESSION["type"])) return null;
        if ($_SESSION["type"] === "ADMIN") header("Location: ../admin/dashboard");
        if ($_SESSION["type"] === "CLIENT") header("Location: ../client/account-details");
        if ($_SESSION["type"] === "AGENT") header("Location: ../agent/dashboard");
    }


    function checkAuth() {
        if (isset($_SESSION["type"])) return ["is_auth" => "TRUE"];
        return ["is_auth" => "FALSE"];
    }


    function verifyToken() {
        $token = $_GET["token"];

        $FetchModel = new FetchModel();
        $response = $FetchModel->isTokenValid($token);

        if ($response["status"] === 500) {
            header("Location: ../error/500");
            return;
        }

        if (count($response["rows"]) < 1) {
            header("Location: ../auth/invalid-token");
            return;
        }

        $row = $response["rows"][0];
        $diff = date_create(date("Y-m-d H:i:s"))->diff(date_create($row["expiry_date"]));

        if ($diff->i > 5) {
            header("Location: ../auth/invalid-token");
            return;
        }
    }

}