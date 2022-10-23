<?php
namespace Main\Models;

session_start();
date_default_timezone_set("Asia/Manila");

use Main\Config;
use Main\Controllers\MailController;
use Main\Models\FetchModel;

class CreateModel {

    private function executeQuery($sql, $params = null, $getLastInsertId = false) {
        $conn = (new Config())->openDbConnection(); 

        try {
            $query = $conn->prepare($sql);
        } catch (\Exception $e) {
            echo json_encode(["status" => 500, "message" => $e->getMessage(), "stack_trace" => $e->getTraceAsString()]);
            die;
        }
        
        if ($params !== NULL) {
            $literals = "";
            foreach ($params as $param) {
                $literals .= "s";
            }
            $query->bind_param($literals, ...$params);
        }

        try {
            $query->execute();
        } catch (\Exception $e) {
            echo json_encode(["status" => 500, "message" => $e->getMessage(), "stack_trace" => $e->getTraceAsString()]);
            die;
        }

        if ($getLastInsertId === true) {
            $lastInsertId = self::getLastInsertId($conn)[0]["id"];

            return ["status" => 200, "id" => $lastInsertId];
        }

        $conn->close();

        return ["status" => 200];
    }


    private function flattenAssocArray($array) {
        $flatArray = [];

        foreach ($array as $value) {
            $flatArray[] = $value;
        }

        return $flatArray;
    }


    private function executeQueryWithResult($sql, $params = null, $getLastInsertId = false) {
        $conn = (new Config())->openDbConnection();

        try {
            $query = $conn->prepare($sql);
        } catch (\Exception $e) {
            echo json_encode(["status" => 500, "message" => $e->getMessage(), "stack_trace" => $e->getTraceAsString()]);
            die;
        }

        if ($params !== NULL) {
            $literals = "";
            foreach ($params as $param) {
                $literals .= "s";
            }
            $query->bind_param($literals, ...$params);
        }

        try {
            $query->execute();
        } catch (\Exception $e) {
            echo json_encode(["status" => 500, "message" => $e->getMessage(), "stack_trace" => $e->getTraceAsString()]);
            die;
        }

        $result = $query->get_result();
        $rows = [];
        while ($row = $result->fetch_assoc()) $rows[] = $row;

        if ($getLastInsertId === true) {
            $lastInsertId = self::getLastInsertId($conn)[0]["id"];
            
            return ["status" => 200, "rows" => $rows, "id" => $lastInsertId];
        }

        $conn->close();

        return ["status" => 200, "rows" => $rows];
    }


    private function getLastInsertId($conn) {
        $sql = "SELECT LAST_INSERT_ID() AS id;";
        $query = $conn->prepare($sql);
        $query->execute();
        $result = $query->get_result();
        $rows = [];

        while ($row = $result->fetch_assoc()) $rows[] = $row;

        return $rows;
    }


    function user($data) {
        $data = json_decode($data, true);

        $sql = "SELECT `email` FROM users WHERE `email`=? AND `date_removed` IS NULL LIMIT 1";

        $result = self::executeQueryWithResult($sql, [$data["email"]]);

        if (count($result["rows"]) > 0) return ["status" => 409, "message" => "That email already exists!"];

        if ($data["password"] !== $data["confirm_password"]) return ["status" => 409, "message" => "Passwords do not match!"];

        unset($data["confirm_password"]);
        $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);

        $data = self::flattenAssocArray($data);

        var_dump($data);
        die;

        $sql = "INSERT INTO users(`first_name`, `last_name`, `company_name`,
                    `email`, `phone_number`, `password`, `company_nature`, `company_address`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?);";

        return self::executeQuery($sql, $data);
    }


    function product($data) {
        $data = json_decode($data, true);

        if (isset($data["product-type"])) {
            $data["type_id"] = $data["product-type"];
            unset($data["product-type"]);
        }

        if (empty($data["name"]) || $data["name"] == "" || $data["name"] == null) return ["status" => 409, "message" => "Product name is required."];
        if (empty($data["type_id"]) || $data["type_id"] == "" || $data["type_id"] == null || $data["type_id"] == 0) return ["status" => 409, "message" => "Product type is required."];

        $unitPrice = $data["unit-price"];
        unset($data["unit-price"]);

        $flatData = self::flattenAssocArray($data);

        $sql = "SELECT `name` FROM products WHERE `name`=? AND `date_removed` IS NULL";

        $result = self::executeQueryWithResult($sql, [$data["name"]]);

        if ($result["status"] == 500) return $result;

        $count = count($result["rows"]);

        if ($count > 0) return ["status" => 400, "message" => "That product already exists."];

        $sql = "INSERT INTO products(`name`, `material`, `brand`, `connection_type`, `length`, `width`, `thickness`, `company_name`, `office_address`, `contact_number`, `shop_id`, `type_id`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";

        // if ($_SESSION["type"] === "SHOP-ADMIN") {
        //     $sql = "INSERT INTO products(`name`, `material`, `brand`, `connection_type`, `length`, `width`, `thickness`, `shop_id`, `type_id`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?);";
        //     $flatData[] = $_SESSION["shop_id"];
        // }

        $result = self::executeQuery($sql, $flatData, true);
        $productId = $result["id"];

        $sql = "INSERT INTO products_prices(`product_id`, `unit_price`) VALUES (?, ?)";
        $data = [$productId, $unitPrice];

        return self::executeQuery($sql, $data);
    }


    function productPrice($data) {
        if ($_SESSION["type"] !== "ADMIN") return ["status" => 403, "message" => "You cannot have access to this resource!"];

        $data = json_decode($data, true);

        if (empty($data[0]) || $data[0] == "" || $data[0] == null || $data[0] == 0) return ["status" => 409, "message" => "Product id is required."];
        if (empty($data[1]) || $data[1] == "" || $data[1] == null || $data[1] == 0) return ["status" => 409, "message" => "Product unit price is required."];

        $sql = "INSERT INTO products_prices(`product_id`, `unit_price`) VALUES(?, ?)";

        return self::executeQuery($sql, $data);
    }


    function productType($data) {
        if ($_SESSION["type"] !== "ADMIN") return ["status" => 403, "message" => "You cannot have access to this resource!"];

        $data = json_decode($data, true);

        if (empty($data["name"]) || $data["name"] == "" || $data["name"] == null) return ["status" => 409, "message" => "Product type name is required."];

        $flatData = self::flattenAssocArray($data);

        $sql = "SELECT `name` FROM product_types WHERE `name`=?";
        $rows = self::executeQueryWithResult($sql, [$data["name"]]);
        $count = count($rows["rows"]);

        if ($count > 0) return ["status" => 409, "message" => "That product type already exists."];

        $sql = "INSERT INTO product_types(`name`, `description`) VALUES(?, ?)";

        return self::executeQuery($sql, $flatData);
    }


    function productStock($data) {
        if ($_SESSION["type"] !== "ADMIN") return ["status" => 403, "message" => "You cannot have access to this resource!"];

        $data = json_decode($data, true);
        $sql = "INSERT INTO products_stocks(`product_id`, `unit_price`) VALUES(?, ?)";

        return self::executeQuery($sql, $data);
    }


    function order($data) {
        if ($_SESSION["type"] !== "AGENT") return ["status" => 403, "message" => "You cannot have access to this resource!"];

        $data = json_decode($data, true);

        $userEmail = $data["user-email"];
        $productIds = $data["product-ids"];

        if (empty($userEmail) || $userEmail == "" || $userEmail == null) return ["status" => 409, "message" => "User email is required."];
        if (empty($productIds) || $productIds == "" || $productIds == null) return ["status" => 409, "message" => "Product ids and quantites are required."];
        if (gettype($productIds) !== "array") return ["status" => 409, "message" => "Product ids and qunatites should be in an array."];

        $sql = "SELECT `id` FROM users WHERE `email`=?";

        $userId = self::executeQueryWithResult($sql, [$userEmail]);
        $userId = $userId["rows"][0]["id"];

        if ($userId === NULL) return ["status" => 409, "message" => "That email does not exist!"];

        $sql = "INSERT INTO orders(`user_id`) VALUES (?);";

        $rows = self::executeQuery($sql, [$userId], true);
        $orderId = $rows["id"];

        $sql = "INSERT INTO orders_products(`order_id`, `product_id`, `item_count`) VALUES ";
        $items = [];

        $idsCount = count($productIds);
        $count = 0;

        foreach ($productIds as $key => $value) {
            if ($count + 1 == $idsCount) $sql .= "(?, ?, ?);";
            else $sql .= "(?, ?, ?), ";

            ++$count;

            $key = explode("prod-", $key)[1];

            $items[] = $orderId;
            $items[] = $key;
            $items[] = $value;
        }

        $result = self::executeQuery($sql, $items);

        $ids = array_keys($productIds);

        foreach ($ids as $id) {
            self::cookie($id);
        }

        return $result;
    }


    function clientOrder() {
        if ($_SESSION["type"] !== "CLIENT") return ["status" => 403, "message" => "You cannot have access to this resource!"];
    
        $clientId = $_SESSION["id"];

        $sql = "SELECT `product_id`, `product_quantity` FROM users_carts WHERE `user_id`=?";
        $productIdsQuantities = self::executeQueryWithResult($sql, [$clientId])["rows"];

        if (count($productIdsQuantities) < 1) return ["status" => "409", "message" => "User cart is empty!"];

        $sql = "INSERT INTO orders(`user_id`) VALUES (?);";

        $rows = self::executeQuery($sql, [$clientId], true);
        $orderId = $rows["id"];

        $sql = "INSERT INTO orders_products(`order_id`, `product_id`, `item_count`) VALUES ";
        $items = [];

        $idsCount = count($productIdsQuantities);
        $productIds = [];

        for ($index = 0; $index < $idsCount; $index++) {
            if ($index + 1 == $idsCount) $sql .= "(?, ?, ?);";
            else $sql .= "(?, ?, ?), ";

            $items[] = $orderId;
            $items[] = $productIdsQuantities[$index]["product_id"];
            $items[] = $productIdsQuantities[$index]["product_quantity"];

            $productIds[] = $productIdsQuantities[$index]["product_id"];
        }

        self::executeQuery($sql, $items);

        $ids = array_keys($productIds);

        foreach ($ids as $id) self::cookie($id);

        $sql = "DELETE FROM users_carts WHERE `user_id`=?";
        $result = self::executeQuery($sql, [$clientId]);

        $_SESSION["cart_count"] = 0;

        $MailController = new MailController();
        $response = $MailController->sendToRandomAgent($orderId, $clientId, $productIds, $items);
        
        if ($response["status"] !== 200) return $response;

        return $result;
    }


    function cartItem($data) {
        $product_id = $data["product_id"];
        $quantity = $data["quantity"];

        if (empty($data["product_id"]) || $data["product_id"] == "" || $data["product_id"] == null || $data["product_id"] == 0) return ["status" => 409, "message" => "Product id is required."];
        if (empty($data["quantity"]) || $data["quantity"] == "" || $data["quantity"] == null || $data["quantity"] == 0) return ["status" => 409, "message" => "Product quantity is required."];

        $sql = "SELECT COUNT(`product_id`) AS 'count' FROM users_carts WHERE `product_id`=? AND `user_id`=?";
        $rows = self::executeQueryWithResult($sql, [$product_id, $_SESSION["id"]]);

        $count = $rows["rows"][0]["count"];

        if ($count === 0) {
            $sql = "INSERT INTO users_carts(`user_id`, `product_id`, `product_quantity`) VALUES(?, ?, ?)";
            $data = [$_SESSION["id"], $product_id, $quantity];
            ++$_SESSION["cart_count"];
            $result = self::executeQuery($sql, $data);

            if ($result["status"] != 200) return $result;

            return ["status" => 200, "cart_count" => $_SESSION["cart_count"]];
        }

        $sql = "UPDATE users_carts SET `product_quantity`=`product_quantity`+? WHERE `product_id`=? AND `user_id`=?";
        $data = [$quantity, $product_id, $_SESSION["id"]];
        $result = self::executeQuery($sql, $data);

        if ($result["status"] != 200) return $result;

        return ["status" => 200, "cart_count" => $_SESSION["cart_count"]];
    }


    function cookie($plusExpiration = (60*60*24*30*12)) {
        if (isset($_SESSION["id"])) {
            $FetchModel = new FetchModel();
            $product = $FetchModel->productDetailsComplete($_GET["id"])["rows"][0];

            $cookieValues = json_encode([
                "product_id" => $_GET["id"],
                "type" => $product["type"],
                "material" => $product["material"],
                "brand" => $product["brand"],
                "connection_type" => $product["connection_type"],
            ]);

            $cookieId = uniqid($_SESSION["id"], true);

            setcookie(
                $cookieId,
                $cookieValues,
                time() + (int)$plusExpiration,
                "/"
            );

            $_SESSION["cookieId"] = $cookieId;

            return ["status" => 200];
        }
    }


    function adminNewUser($data) {
        if ($_SESSION["type"] !== "ADMIN") return ["status" => 403, "message" => "You cannot have access to this resource!"];

        $data = json_decode($data, true);

        $sql = "SELECT `email` FROM users WHERE `email`=? AND `date_removed` IS NULL LIMIT 1";

        $result = self::executeQueryWithResult($sql, [$data["email"]]);

        if (count($result["rows"]) > 0) return ["status" => 409, "message" => "That email already exists!"];

        if ($data["password"] !== $data["confirm_password"]) return ["status" => 409, "message" => "Passwords do not match!"];

        unset($data["confirm_password"]);
        $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);

        $data = self::flattenAssocArray($data);

        unset($data[0]);

        $sql = "INSERT INTO users(`first_name`, `last_name`, `company_name`,
                    `email`, `phone_number`, `password`, `type`, `company_nature`, `company_address`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";

        return self::executeQuery($sql, $data);
    }


    function token($email) {
        $token = bin2hex(random_bytes(64));
        $expiryDate = date_add(date_create(date("Y-m-d H:i:s")), date_interval_create_from_date_string("5 minutes"));
        $expiryDate = $expiryDate->format("Y-m-d H:i:s");

        $sql = "INSERT INTO tokens(`token`, `expiry_date`, `email`)
                VALUES (?, ?, ?);";

        $response = self::executeQuery($sql, [$token, $expiryDate, $email]);
        $response["token"] = $token;

        return $response;
    }

}