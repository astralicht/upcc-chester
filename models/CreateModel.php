<?php
namespace Main\Models;

use Main\Config;

class CreateModel {
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

        $result = $query->get_result();
        $rows = [];
        while ($row = $result->fetch_assoc()) $rows[] = $row;

        return ["status" => 200, "rows" => $rows];
    }


    function user($data) {
        $data = json_decode($data, true);

        if ($data["password"] === $data["confirm_password"]) {
            unset($data["confirm_password"]);
            $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);
        }

        $sql = 'INSERT INTO users(`first_name`, `last_name`, `company_name`, `company_address`, `company_nature`,
                    `phone_number`, `email`, `password`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?);';

        return self::getResult($sql, $data);
    }


    function product($data) {
        $data = json_decode($data, true);

        if ($data["password"] === $data["confirm_password"]) {
            unset($data["confirm_password"]);
            $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);
        }

        $sql = 'INSERT INTO users(`first_name`, `last_name`, `company_name`, `company_address`, `company_nature`,
                    `phone_number`, `email`, `password`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?);';

        return self::getResult($sql, $data);
    }

}