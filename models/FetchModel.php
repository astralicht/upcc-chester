<?php

namespace Main\Models;

use Main\Config;

class FetchModel
{

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


    function usersCount() {
        $sql = "SELECT COUNT(`id`) AS 'users_count' FROM users WHERE `date_removed` IS NULL";

        return self::getResult($sql);
    }


    function productsCount() {
        $sql = "SELECT COUNT(`id`) AS 'products_count' FROM products WHERE `date_removed` IS NULL";

        return self::getResult($sql);
    }


    function ordersCount() {
        $sql = "SELECT COUNT(`id`) AS 'orders_count' FROM orders WHERE `date_removed` IS NULL";

        return self::getResult($sql);
    }


    function users($data) {
        $filter = $data["filter"];
        $page = $data["page"];
        $limit = $data["limit"];
        $offset = $page * $limit;
        $range = [$offset, $limit];

        $sql = "SELECT `id`, `first_name`, `last_name`, `company_name`, `company_nature`, `company_address`, `phone_number`, `email`
                FROM users
                WHERE `date_removed` IS NULL
                LIMIT ?, ?";

        if ($filter !== "") {
            $sql = "SELECT `id`, `first_name`, `last_name`, `company_name`, `company_nature`, `company_address`, `phone_number`, `email`
                    FROM users
                    WHERE `date_removed` IS NULL
                    AND `first_name` LIKE '%$filter%'
                    OR  `last_name` LIKE '%$filter%'
                    OR  `company_name` LIKE '%$filter%'
                    OR  `company_nature` LIKE '%$filter%'
                    LIMIT ?, ?";
        }

        return self::getResult($sql, $range);
    }


    function products($data) {
        $filter = $data["filter"];
        $page = $data["page"];
        $limit = $data["limit"];
        $offset = $page * $limit;
        $range = [$offset, $limit];

        $sql = "SELECT `id`, `name`, `type`, `brand`, `unit_price`
                FROM products
                WHERE `date_removed` IS NULL
                LIMIT ?, ?";

        if ($filter !== "null") {
            $sql = "SELECT `id`, `name`, `type`, `brand`, `unit_price`
                    FROM products
                    WHERE `date_removed` IS NULL
                    AND `name` LIKE '%$filter%'
                    OR  `type` LIKE '%$filter%'
                    OR  `brand` LIKE '%$filter%'
                    LIMIT ?, ?";
        }

        return self::getResult($sql, $range);
    }


    function orders($data) {
        $filter = $data["filter"];
        $page = $data["page"];
        $limit = $data["limit"];
        $offset = $page * $limit;
        $range = [$offset, $limit];

        $sql = "SELECT o.`id`, o.`order_id`, u.`company_name`, u.`email`, COUNT()
                FROM orders AS o INNER JOIN users AS u INNER JOIN orders_products as op
                WHERE `date_removed` IS NULL
                LIMIT ?, ?";

        if ($filter !== "") {
            $sql = "";
        }

        return self::getResult($sql, $range);
    }


    function companyNatures() {
        $sql = "SELECT `nature` FROM company_natures WHERE `date_removed` IS NULL";

        return self::getResult($sql);
    }

    
    function product($data) {
        $id = [$data["id"]];
        $sql = "SELECT * FROM products WHERE `id`=? AND `date_removed` IS NULL";

        return self::getResult($sql, $id);
    }

}
