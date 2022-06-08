<?php
namespace Main\Controllers;

use Main\Models\AuthModel;

session_start();

class AuthController {

    public function login($data) { 
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
            $_SESSION["first_name"] = $response["user"]["first_name"];
            $_SESSION["last_name"] = $response["user"]["last_name"];
            $_SESSION["type"] = $response["user"]["type"];

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

    public function logout() {
        unset($_SESSION);
        session_destroy();
        header("Location: ../login/");
    }

    public function loginRedirect() {
        var_dump($_SESSION);
        if (!isset($_SESSION["type"])) return null;
        if ($_SESSION["type"] === "ADMIN") header("Location: ../admin/dashboard");
        if ($_SESSION["type"] === "CLIENT") header("Location: ../client/dashboard");
    }

}