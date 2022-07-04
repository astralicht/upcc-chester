<?php

namespace Main\Models;

use Main\Config;

class DeleteModel {

    private function getResult($sql, $params = null) {
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


    function users($data) {
        $data = json_decode($data, true);
        $date_now = date("Y-m-d H:i:s");
        $clause = implode(',', array_fill(0, count($data), '?'));

        $sql = "UPDATE users SET `date_removed`='$date_now' WHERE `id` IN (" . $clause . ");";

        return self::getResult($sql, $data);
    }


    function products($data) {
        $data = json_decode($data, true);
        $date_now = date("Y-m-d H:i:s");
        $clause = implode(',', array_fill(0, count($data), '?'));

        $sql = "UPDATE products SET `date_removed`='$date_now' WHERE `id` IN (" . $clause . ");";

        return self::getResult($sql, $data);
    }


    function productTypes($data) {
        $data = json_decode($data, true);
        $date_now = date("Y-m-d H:i:s");
        $clause = implode(',', array_fill(0, count($data), '?'));

        $sql = "UPDATE product_types SET `date_removed`='$date_now' WHERE `id` IN (" . $clause . ");";

        return self::getResult($sql, $data);
    }


    function clientCartItem($data) {
        $data = [$data["id"]];

        $sql = "DELETE FROM users_carts WHERE `id`=?";

        return self::getResult($sql, $data);
    }

}
