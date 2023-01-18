<?php

namespace Main\Models;

date_default_timezone_set("Asia/Manila");

use Error;
use Main\Config;

class UpdateModel {

    static $configOverride = null;

    function __construct($configOverride = null) {
        if ($configOverride !== null) {
            self::$configOverride = $configOverride;
        }
    }

    private function executeQuery($sql, $params = null) {
        $conn = (new Config())->openDbConnection();

        try {
            $query = $conn->prepare($sql);
        } catch (\Exception $e) {
            return ["status" => 500, "message" => $e->getMessage(), "stack_trace" => $e->getTraceAsString()];
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
            return ["status" => 500, "message" => $e->getMessage(), "stack_trace" => $e->getTraceAsString()];
        }

        return ["status" => 200];
    }


    private function executeQueryWithResult($sql, $params = null) {
        $conn = (new Config())->openDbConnection();

        try {
            $query = $conn->prepare($sql);
        } catch (\Exception $e) {
            return ["status" => 500, "message" => $e->getMessage(), "stack_trace" => $e->getTraceAsString()];
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
            return ["status" => 500, "message" => $e->getMessage(), "stack_trace" => $e->getTraceAsString()];
        }

        $result = $query->get_result();

        $rows = [];
        while ($row = $result->fetch_assoc()) $rows[] = $row;

        $conn->close();

        return ["status" => 200, "rows" => $rows];
    }


    private function flattenAssocArray($array) {
        $flatArray = [];

        foreach ($array as $value) {
            $flatArray[] = $value;
        }

        return $flatArray;
    }



    function clientInfo($data) {
        $data = json_decode($data, true);

        $sql = "UPDATE users SET `first_name`=?, `last_name`=?, `company_name`=?, `company_address`=?, `phone_number`=?, `company_nature`=? WHERE `id`=?";

        return self::executeQuery($sql, $data);
    }


    function orderStatus($data) {
        if (gettype($data) == "string") $data = json_decode($data, true);
        if ($data["status"] == null) return;

        $redirectFlag = $data["redirect_flag"];

        unset($data["redirect_flag"]);

        $orderId = $data["order_id"];
        $status = $data["status"];

        $sql = "SELECT `user_id` FROM orders WHERE `id`=?";
        $response = self::executeQueryWithResult($sql, [$orderId]);

        $userId = $response["rows"][0]["user_id"];

        $params = [$status, $orderId];
        $sql = "UPDATE orders SET `status`=? WHERE `id`=?";

        $response = self::executeQuery($sql, $params);

        $data = [
            "message" => "Order #$orderId is now $status. View your order details <a href='../client/order?id=$orderId'>here.</a>.",
            "user_id" => $userId,
        ];

        $response = (new \Main\Models\CreateModel)->notification($data);

        if ($redirectFlag != true || $redirectFlag == null) return $response;

        header("Location: ../../admin/view-order?order_id=" . $orderId);
    }

    
    function updateImageData($fileDestination, $fileName, $imageType, $id) {
        if ($imageType === NULL) return;
        if ($imageType === "PRODUCT") {
            $sql = "UPDATE products SET `image_path`=?, `image_name`=? WHERE `id`=?";
            $data = [$fileDestination, $fileName, $id];
        }
        if ($imageType === "USER") {
            $sql = "UPDATE users SET `dp_path`=? WHERE `id`=?";
            $data = [$fileDestination, $id];
        }
        if ($imageType === "SHOP") {
            $sql = "UPDATE shops SET `image_path`=?, `image_name`=? WHERE `id`=?";
            $data = [$fileDestination, $fileName, $id];
        }

        return self::executeQuery($sql, $data);
    }


    function product($data) {
        $data = json_decode($data, true);

        unset($data["image-input"], $data["image-type"], $data["old-image-path"]);

        $productPricesArr = [$data["unit-price"], $data["product-id"]];

        unset($data["product-id"], $data["unit-price"]);

        $data = self::flattenAssocArray($data);
        $data[] = $productPricesArr[1];

        $sql = "UPDATE products
                SET `name`=?, `material`=?, `brand`=?, `connection_type`=?, `length`=?, `width`=?, `thickness`=?, 
                    `company_name`=?, `office_address`=?, `contact_number`=?, `type_id`=?, `shop_id`=?
                WHERE `id`=?";

        self::executeQuery($sql, $data);

        $sql = "UPDATE products_prices
                SET `unit_price`=?
                WHERE `product_id`=?";

        return self::executeQuery($sql, $productPricesArr);
    }


    function password($newPassword) {
        $sql = "UPDATE users
                SET `password`=?
                WHERE `email`=?";

        $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $response = self::executeQuery($sql, [$newPassword, $_SESSION["email-for-password-reset"]]);

        unset($_SESSION["email-for-password-reset"]);
        session_destroy();

        return $response;
    }


    function productClicks($id) {
        $sql = "UPDATE products
                SET `clicks`=`clicks`+1
                WHERE `id`=?";

        return self::executeQuery($sql, [$id]);
    }


    function adminInfo($data) {
        $data = json_decode($data, true);

        $sql = "UPDATE users SET `first_name`=?, `last_name`=?, `company_name`=?, `company_address`=?, `phone_number`=?, `company_nature`=? WHERE `id`=?";

        return self::executeQuery($sql, $data);
    }


    function notificationsMarkAllRead($data, $test = null) {
        $userId = $data["user_id"];
        $date_now = date("Y-m-d H:i:s");

        $sql = "UPDATE notifications SET `date_read`=? WHERE `user_id`=? AND `date_read` IS NULL";

        $response = self::executeQuery($sql, [$date_now, $userId]);

        if ($test !== null) return $response;
        
        return header("Location: ../../client/notifications?user_id=$userId&param=unread");
    }


    function adminEditShop($data) {
        $data = json_decode($data, true);

        $sql = "UPDATE shops SET `name`=? WHERE `id`=?";

        return self::executeQuery($sql, [$data["name"], $data["id"]]);
    }


    function userEmailStatus($email) {
        $sql = "UPDATE users SET `is_email_confirmed`='TRUE' WHERE `email`=?";

        return self::executeQuery($sql, [$email]);
    }

}