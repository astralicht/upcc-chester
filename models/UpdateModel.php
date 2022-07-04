<?php

namespace Main\Models;

use Main\Config;

class UpdateModel {

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

    function clientInfo($data) {
        $data = json_decode($data, true);

        $sql = "UPDATE users SET `first_name`=?, `last_name`=?, `company_name`=?, `company_address`=?, `phone_number`=?, `company_nature`=? WHERE `id`=?";

        return self::getResult($sql, $data);
    }

}