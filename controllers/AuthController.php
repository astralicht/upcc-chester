<?php
namespace Main\Controllers;

use Main\Models\AuthModel;
use Main\Models\FetchModel;
use Main\Models\UpdateModel;

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

            if ($userDetails["is_email_confirmed"] === "FALSE") return ["status" => 401, "message" => "That email is not yet verified.", "COMMAND" => "REDIRECT-TO-VERIFY-CONFIRMATION"];

            $_SESSION["id"] = $userDetails["id"];
            $_SESSION["email"] = $userDetails["email"];
            $_SESSION["first_name"] = $userDetails["first_name"];
            $_SESSION["last_name"] = $userDetails["last_name"];
            $_SESSION["type"] = $userDetails["type"];
            $_SESSION["dp_path"] = $userDetails["dp_path"];

            $FetchModel = new FetchModel();
            $cart_items_count = $FetchModel->cartItemsCount()["rows"][0]["cart_items_count"];
            $_SESSION["cart_count"] = $cart_items_count;

            $_SESSION["shop_id"] = $FetchModel->userShopId($userDetails["id"])["rows"][0]["shop_id"];

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
        var_dump($_SESSION["type"]);
        if (!isset($_SESSION["type"])) return null;
        if ($_SESSION["type"] === "ADMIN") header("Location: ../admin/dashboard");
        if ($_SESSION["type"] === "CLIENT") header("Location: ../client/account-details");
        if ($_SESSION["type"] === "AGENT") header("Location: ../agent/dashboard");
        if ($_SESSION["type"] === "SHOP-ADMIN") header("Location: ../shop-admin/dashboard");
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

        session_start();
        $_SESSION["email-for-password-reset"] = $row["email"];
        
        header("Location: ../auth/reset-password");
        return;
    }


    function verifyTokenEmail() {
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
        
        header("Location: ../auth/email-verify");
        return;
    }


    function resetPasswordSubmit() {
        $newPassword = $_POST["password"];

        $UpdateModel = new UpdateModel();
        $response = $UpdateModel->password($newPassword);

        if ($response["status"] === 500) {
            header("Location: ../error/500");
            return;
        }

        header("Location: ../auth/password-reset-successful");
        return;
    }

}