<?php

namespace Main\Controllers;

use Main\Models\DeleteModel;

session_start();

class DeleteController {

    function users($data) { if ($_SESSION["type"] === "ADMIN") return (new DeleteModel)->users($data); }
    function products($data) { if ($_SESSION["type"] === "ADMIN") return (new DeleteModel)->products($data); }
    function clientCartItem($data) { 
        if ($_SESSION["type"] !== "CLIENT") echo "You must be logged in to access this!";

        $response = (new DeleteModel)->clientCartItem($data);

        if ($response["status"] !== 200) {
            echo $response["message"];
        }

        --$_SESSION["cart_count"];
        header("Location: ../../client/cart");
        die;
    }
    function productTypes($data) { if ($_SESSION["type"] === "ADMIN") return (new DeleteModel)->productTypes($data); }
    function orders($data) { if ($_SESSION["type"] === "AGENT") return (new DeleteModel)->orders($data); }
    
}
