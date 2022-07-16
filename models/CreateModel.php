<?php
namespace Main\Models;

session_start();

use Main\Config;

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

        if ($data["password"] === $data["confirm_password"]) {
            unset($data["confirm_password"]);
            $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);
        }

        $data = self::flattenAssocArray($data);

        $sql = "INSERT INTO users(`first_name`, `last_name`, `company_name`,
                    `email`, `phone_number`, `password`, `company_nature`, `company_address`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?);";

        return self::executeQuery($sql, $data);
    }


    function product($data) {
        $data = json_decode($data, true);
        $unitPrice = $data["unit-price"];
        unset($data["unit-price"]);

        $flatData = self::flattenAssocArray($data);

        $sql = "SELECT `name` FROM products WHERE `name`=? AND `date_removed` IS NULL";

        $result = self::executeQueryWithResult($sql, [$data["name"]]);

        if ($result["status"] == 500) return $result;

        $count = count($result["rows"]);

        if ($count > 0) return ["status" => 400, "message" => "That product already exists."];

        $sql = "INSERT INTO products(`name`, `material`, `brand`, `connection_type`, `length`, `width`, `thickness`, `type_id`) VALUES(?, ?, ?, ?, ?, ?, ?, ?);";
        $result = self::executeQuery($sql, $flatData, true);
        $productId = $result["id"];

        $sql = "INSERT INTO products_prices(`product_id`, `unit_price`) VALUES (?, ?)";
        $data = [$productId, $unitPrice];

        return self::executeQuery($sql, $data);
    }


    function productPrice($data) {
        $data = json_decode($data, true);
        $sql = "INSERT INTO products_prices(`product_id`, `unit_price`) VALUES(?, ?)";

        return self::executeQuery($sql, $data);
    }


    function productType($data) {
        $data = json_decode($data, true);
        $flatData = self::flattenAssocArray($data);

        $sql = "SELECT `name` FROM product_types WHERE `name`=?";
        $rows = self::executeQueryWithResult($sql, [$data["name"]]);
        $count = count($rows["rows"]);

        if ($count > 0) return ["status" => 400, "message" => "That product type already exists."];

        $sql = "INSERT INTO product_types(`name`, `description`) VALUES(?, ?)";

        return self::executeQuery($sql, $flatData);
    }


    function productStock($data) {
        $data = json_decode($data, true);
        $sql = "INSERT INTO products_stocks(`products_id`, `unit_price`) VALUES(?, ?)";

        return self::executeQuery($sql, $data);
    }


    function order($data) {
        $data = json_decode($data, true);

        var_dump($data["product-ids"]);

        $productIdsArr = explode(" ", $data["product-ids"]);
        array_pop($productIdsArr[count($productIdsArr)]);

        $productIds = $productIdsArr;

        var_dump($productIds);

        $userId = $data["user-id"];

        $sql = "INSERT INTO orders(`user_id`) VALUES (?);";

        $rows = self::executeQuery($sql, [$userId], true);
        $orderId = $rows["id"];

        $sql = "INSERT INTO orders_products(`order_id`, `product_id`, `item_count`) VALUES;";
        $items = [];

        for ($index = 0; $index < count($productIds); $index++) {
            if ($index + 1 == count($productIds)) $sql .= "(?, ?, 1);";
            else $sql .= "(?, ?, 1), ";

            $items = [$order_id, ...$productIds[$index]];
        }

        return self::executeQuery($sql, $items);
    }


    function cartItem($data) {
        $product_id = $data["product_id"];
        $quantity = $data["quantity"];

        $sql = "SELECT COUNT(`product_id`) AS 'count' FROM users_carts WHERE `product_id`=?";
        $rows = self::executeQueryWithResult($sql, [$product_id]);

        $count = $rows["rows"][0]["count"];

        if ($count === 0) {
            $sql = "INSERT INTO users_carts(`user_id`, `product_id`, `product_quantity`) VALUES(?, ?, ?)";
            $data = [$_SESSION["id"], $product_id, $quantity];
            ++$_SESSION["cart_count"];

            $result = self::executeQuery($sql, $data);
            if ($result["status"] != 200) return $result;

            return ["status" => 200, "cart_count" => $_SESSION["cart_count"]];
        }

        $sql = "UPDATE users_carts SET `product_quantity`=`product_quantity`+? WHERE `product_id`=?";
        $data = [$quantity, $product_id];

        $result = self::executeQuery($sql, $data);
        if ($result["status"] != 200) return $result;

        return ["status" => 200, "cart_count" => $_SESSION["cart_count"]];
    }

}