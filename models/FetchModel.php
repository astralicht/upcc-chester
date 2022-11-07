<?php
namespace Main\Models;

session_start();

use Main\Config;
use Main\Controllers\ViewsController;
use TypeError;

class FetchModel
{

    function getResult($sql, $params = null) {
        $conn = (new Config())->openDbConnection();

        try {
            $query = $conn->prepare($sql);
        } catch (\Exception $e) {
            return ["status" => 500, "message" => $e->getMessage(), "stack_trace" => $e->getTraceAsString(), "rows" => []];
        }
        
        if ($params != null) {
            $literals = "";
            foreach ($params as $param) {
                $literals .= "s";
            }
            $query->bind_param($literals, ...$params);
        }

        try {
            $query->execute();
        } catch (\Exception $e) {
            return ["status" => 500, "message" => $e->getMessage(), "stack_trace" => $e->getTraceAsString(), "rows" => []];
        }

        $result = $query->get_result();
        $rows = [];
        while ($row = $result->fetch_assoc()) $rows[] = $row;

        return ["status" => 200, "rows" => $rows];
    }


    private function flattenAssocArray($array) {
        $flatArray = [];

        foreach ($array as $value) {
            $flatArray[] = $value;
        }

        return $flatArray;
    }


    function usersCount() {
        $sql = "SELECT COUNT(`id`) AS 'users_count' FROM users WHERE `date_removed` IS NULL";

        return self::getResult($sql);
    }


    function productsCount() {
        $sql = "SELECT COUNT(p.`id`) AS products_count
                FROM products AS p
                INNER JOIN products_prices AS pr
                INNER JOIN product_types AS pt
                WHERE p.`date_removed` IS NULL
                AND p.`type_id`=pt.`id`
                AND pr.`product_id`=p.`id`";

        return self::getResult($sql);
    }


    function ordersCount() {
        $sql = "SELECT COUNT(`id`) AS 'orders_count' FROM orders WHERE `date_removed` IS NULL";

        return self::getResult($sql);
    }


    function cartItemsCount() {
        $sql = "SELECT COUNT(`id`) AS 'cart_items_count' FROM users_carts WHERE `user_id`=?";

        return self::getResult($sql, [$_SESSION["id"]]);
    }


    function users($data) {
        $filter = $data["filter"];
        $page = $data["page"];
        $limit = $data["limit"];
        $offset = $page * $limit;
        $range = [$offset, $limit];

        $sql = "SELECT `id`, `first_name`, `last_name`, `company_name`, `company_nature`, `company_address`, `phone_number`, `email`, `date_created`
                FROM users
                WHERE `date_removed` IS NULL
                LIMIT ?, ?";

        if ($filter !== "") {
            $sql = "SELECT `id`, `first_name`, `last_name`, `company_name`, `company_nature`, `company_address`, `phone_number`, `email`, `date_created`
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
        $brand = $data["brand"];
        $typeId = $data["typeid"];
        $page = $data["page"];
        $limit = $data["limit"];
        $offset = $page * $limit;
        $range = [$offset, $limit];

        if ($typeId === null) $typeId = "null";

        $filterString = "";
        $brandAndType = "";

        if ($filter !== "null") $filterString = "AND p.`name` LIKE '%$filter%'";

        if ($brand !== "null" && $typeId === "null") $brandAndType = "AND (p.`brand`='$brand')";

        if ($brand === "null" && $typeId !== "null") $brandAndType = "AND (p.`type_id`='$typeId')";

        if ($brand !== "null" && $typeId !== "null") $brandAndType = "AND (p.`brand`='$brand' AND p.`type_id`='$typeId')";

        // $sql = "SELECT p.`id`, p.`name`, pt.`name` AS 'type', p.`brand`, pr.`unit_price`, p.`image_path`, p.`image_name`, p.`date_added`
        //         FROM products AS p INNER JOIN products_prices AS pr INNER JOIN product_types as pt
        //         WHERE p.`date_removed` IS NULL
        //         AND p.`id`=pr.`product_id`
        //         AND p.`type_id`=pt.`id`
        //         $filterString
        //         $brandAndType
        //         GROUP BY p.`id`
        //         ORDER BY FIELD(p.`id`, $productKeys)
        //         LIMIT ?, ?";

        $sql = "SELECT p.`id`,
                    p.`name`,
                    pt.`name` AS 'type',
                    p.`brand`,
                    p.`image_path`,
                    p.`image_name`,
                    pr.`unit_price`,
                    p.`clicks`,
                    p.`date_added`
                FROM products AS p
                INNER JOIN products_prices AS pr
                INNER JOIN product_types AS pt
                WHERE p.`date_removed` IS NULL
                AND p.`type_id`=pt.`id`
                AND pr.`product_id`=p.`id`
                GROUP BY p.`id`
                ORDER BY
                    pr.`unit_price` ASC,
                    p.`clicks` DESC
                LIMIT ?, ?";
                
        return self::getResult($sql, $range);
    }


    function productsFilterOnly($data) {
        $filter = $data["filter"];

        $sql = "SELECT `id`, `name`, `image_path`
                FROM products
                WHERE `date_removed` IS NULL
                AND (`name` LIKE '%$filter%'
                OR  `id`='$filter')";

        return self::getResult($sql);
    }


    function allProductIds() {
        $sql = "SELECT `id` FROM products WHERE `date_removed` IS NULL;";

        return self::getResult($sql);
    }


    function allProductsComplete() {
        $sql = "SELECT p.`id`, pt.`name` AS 'type', p.`brand`, p.`material`, p.`connection_type`
                FROM products AS p INNER JOIN product_types as pt
                WHERE p.`date_removed` IS NULL
                AND p.`type_id`=pt.`id`";

        return self::getResult($sql);
    }


    function productDetailsComplete($id) {
        $sql = "SELECT p.`id`, pt.`name` AS 'type', p.`brand`, p.`material`, p.`connection_type`
                FROM products AS p INNER JOIN product_types as pt
                WHERE p.`date_removed` IS NULL
                AND p.`type_id`=pt.`id`
                AND p.`id`='$id'";

        return self::getResult($sql);
    }


    function allOrders($data) {
        $filter = $data["filter"];
        $page = $data["page"];
        $limit = $data["limit"];
        $offset = $page * $limit;
        $range = [$offset, $limit];

        $sql = "SELECT o.`id`, o.`id` AS 'order_id', CONCAT(u.`first_name`, ' ', u.`last_name`), SUM(op.`item_count`), SUM(pr.`unit_price`*op.`item_count`), o.`id` AS 'order_id_redr', o.`status`, o.`date_added`
                FROM orders AS o INNER JOIN products AS p INNER JOIN products_prices AS pr INNER JOIN orders_products AS op INNER JOIN users AS u
                WHERE op.`product_id`=p.`id`
                AND op.`order_id`=o.`id`
                AND pr.`product_id`=p.`id`
                AND o.`user_id`=u.`id`
                AND o.`date_removed` IS NULL
                GROUP BY o.`id`
                ORDER BY o.`date_added` DESC
                LIMIT ?, ?";

        // if ($filter !== "") {
        //     $sql = "SELECT `id`, `name`, `description`
        //             FROM orders
        //             WHERE `date_removed` IS NULL
        //             AND (`id` LIKE '%$filter%'
        //             OR `user_id` LIKE '%$filter%'
        //             OR `date_added` LIKE '$filter'
        //             OR `status` LIKE '$filter')
        //             LIMIT ?, ?";
        // }

        return self::getResult($sql, $range);
    }


    function clientOrders() {
        $clientId = [$_SESSION["id"]];
        
        $sql = "SELECT o.`id`, o.`id` AS order_id, SUM(pr.`unit_price` * op.`item_count`) AS total_price, o.`date_added`, o.`status`
        FROM orders AS o INNER JOIN orders_products AS op INNER JOIN products AS p INNER JOIN products_prices AS pr
        WHERE o.`user_id`=?
        AND op.`order_id`=o.`id`
        AND op.`product_id`=p.`id`
        AND pr.`product_id`=p.`id`
        GROUP BY o.`id`
        ORDER BY o.`date_added` DESC";

        return self::getResult($sql, $clientId);
    }


    function ordersWithProducts($data) {
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


    function order($data) {
        $orderId = [$data["id"]];

        $sql = "SELECT p.`id`, p.`name`, p.`id` AS 'product_id', op.`item_count`, pr.`unit_price`, pr.`unit_price`*op.`item_count`, o.`status`
                FROM orders AS o INNER JOIN products AS p INNER JOIN products_prices AS pr INNER JOIN orders_products AS op
                WHERE op.`product_id`=p.`id`
                AND op.`order_id`=o.`id`
                AND pr.`product_id`=p.`id`
                AND o.`id`=?
                ORDER BY op.`date_added` DESC;";

        return self::getResult($sql, $orderId);
    }


    function companyNatures() {
        $sql = "SELECT `nature` FROM company_natures WHERE `date_removed` IS NULL";

        return self::getResult($sql);
    }

    
    function product($data) {
        $id = $data["id"];
        $sql = "SELECT p.`name`, pt.`id` AS 'type_id', pt.`name` AS 'type', p.`material`, p.`brand`, p.`connection_type`, p.`length`, p.`width`, p.`thickness`,
                    p.`image_name` AS image_name, p.`image_path`, pr.`unit_price`, p.`company_name`, p.`office_address`, p.`contact_number`, s.`name` AS 'shop_name'
                FROM products AS p
                INNER JOIN products_prices AS pr
                INNER JOIN product_types AS pt
                INNER JOIN shops AS s
                WHERE p.`id`=?
                AND p.`id`=pr.`product_id`
                AND p.`type_id`=pt.`id`
                AND p.`shop_id`=s.`id`
                AND p.`date_removed` IS NULL";

        return self::getResult($sql, [$id]);
    }


    function user($data) {
        $id = [$data["id"]];
        $sql = "SELECT * FROM users WHERE `id`=? AND `date_removed` IS NULL";

        return self::getResult($sql, $id);
    }


    function productTypes($data) {
        $filter = null;
        $offset = null;
        $range = null;

        $data["filter"] !== "" ? $filter = $data["filter"] : $filter = null;
        $data["page"] !== "" ? $page = $data["page"] : $page = null;
        $data["limit"] !== "" ? $limit = $data["limit"] : $limit = null;

        $sql = "SELECT `id`, `name`, `description`
                FROM product_types
                WHERE `date_removed` IS NULL
                LIMIT ?, ?";

        if ($filter !== "null") {
            $sql = "SELECT `id`, `name`, `description`
                    FROM product_types
                    WHERE `date_removed` IS NULL
                    AND `name` LIKE '%$filter%'
                    LIMIT ?, ?";
        }

        if ($page !== null || $limit !== null) {
            $offset = $page * $limit;
            $range = [$offset, $limit];
            return self::getResult($sql, $range);
        }

        return self::getResult($sql);
    }


    function productTypesAll() {
        $sql = "SELECT `id`, `name`
                FROM product_types
                WHERE `date_removed` IS NULL";

        return self::getResult($sql);
    }


    function clientCart($data) {
        $clientId = [$data["client_id"]];
        $sql = "SELECT uc.`id`, p.`image_path`, p.`name`, uc.`product_quantity`, pr.`unit_price`
                FROM users_carts AS uc INNER JOIN products AS p INNER JOIN products_prices AS pr
                WHERE uc.`user_id`=?
                AND uc.`product_id`=p.`id`
                AND pr.`product_id`=p.`id`;";

        return self::getResult($sql, $clientId);
    }


    function typesAndBrands() {
        $sql = "SELECT `brand` FROM products WHERE `date_removed` IS NULL GROUP BY `brand`";
        $result = self::getResult($sql);
        $arr["brands"] = $result["rows"];
        $arr["status"] = $result["status"];

        $sql = "SELECT `id`, `name` FROM product_types WHERE `date_removed` IS NULL";
        $result = self::getResult($sql);
        $arr["types"] = $result["rows"];
        $arr["status"] = $result["status"];

        return $arr;
    }


    function isAccountEmail($email) {
        $sql = "SELECT `email`
                FROM users
                WHERE `email`=?";

        return self::getResult($sql, [$email]);
    }


    function isTokenValid($token) {
        $sql = "SELECT `expiry_date`, `email`
                FROM tokens
                WHERE `token`=?
                LIMIT 1";

        return self::getResult($sql, [$token]);
    }


    function getProductNamesFromIds($ids) {
        if (gettype($ids) == "string" || $ids == null) $ids = [];

        $idsString = implode(", ", $ids);
        $sql = "SELECT `id`, `name`
                FROM products
                WHERE `id` IN ($idsString)";

        if (empty($ids)) $sql = "SELECT `id`, `name`
                                FROM products
                                WHERE `id`=''";

        return self::getResult($sql);
    }


    function agentEmails() {
        $sql = "SELECT `email`
                FROM users
                WHERE `type`='AGENT'
                AND `date_removed` IS NULL";

        return self::getResult($sql);
    }


    function previousOrderedProducts($limit) {
        $sql = "SELECT p.`name`, p.`id`, pr.`unit_price`, p.`image_path`, SUM(op.`item_count`) AS items_sold
                FROM products AS p
                INNER JOIN products_prices AS pr
                INNER JOIN orders AS o
                INNER JOIN orders_products AS op
                WHERE p.`date_removed` IS NULL
                AND p.`id`
                AND o.`date_removed` IS NULL
                AND op.`date_removed` IS NULL
                AND o.`status`='APPROVED'
                AND o.`id`=op.`order_id`
                AND pr.`product_id`=p.`id`
                AND op.`product_id`=p.`id`
                GROUP BY p.`id`
                ORDER BY o.`date_added`
                LIMIT ?";

        return self::getResult($sql, [$limit]);
    }


    function search() {
        $param = $_GET["param"];
        $sort = $_GET["sort"];

        // $sql = "SELECT s.`id`, s.`name`
        //         FROM shops AS s INNER JOIN products AS p
        //         WHERE s.`date_removed` IS NULL
        //         AND p.`date_removed` IS NULL
        //         AND p.`shop_id`=s.`id`
        //         AND s.`name` LIKE '%$param%'
        //         AND p.`name` LIKE '%$param%';
        //     ";

        $sql = "SELECT `id`, `name`, `image_path`
                FROM shops
                WHERE `date_removed` IS NULL
                AND `name` LIKE '%$param%'";

        $rows = [];
        $rows["shops"] = self::getResult($sql)["rows"];

        if ($sort === "topsales") {
            $sql = "SELECT p.`id` AS product_id,
                            p.`name` AS product_name,
                            pt.`id` AS type_id, 
                            pt.`name` AS type_name,
                            p.`image_path` AS product_img_path,
                            pr.`unit_price` AS product_price,
                            SUM(op.`item_count`) AS items_sold
                    FROM products AS p
                    INNER JOIN product_types AS pt
                    INNER JOIN products_prices AS pr
                    INNER JOIN orders_products AS op
                    INNER JOIN orders AS o
                    WHERE p.`date_removed` IS NULL
                    AND p.`type_id`=pt.`id`
                    AND p.`id`=pr.`product_id`
                    AND p.`id`=op.`product_id`
                    AND op.`order_id`=o.`id`
                    AND o.`status`='APPROVED'
                    AND (p.`name` LIKE '%$param%'
                    OR p.`brand` LIKE '%$param%'
                    OR p.`material` LIKE '%$param%'
                    OR p.`connection_type` LIKE '%$param%')
                    GROUP BY p.`id`
                    ORDER BY items_sold DESC;
                ";
        } else if ($sort === "latest") {
            $sql = "SELECT p.`id` AS product_id,
                        p.`name` AS product_name,
                        pt.`id` AS type_id, 
                        pt.`name` AS type_name,
                        p.`image_path` AS product_img_path,
                        pr.`unit_price` AS product_price,
                        p.`clicks`
                FROM products AS p
                INNER JOIN product_types AS pt
                INNER JOIN products_prices AS pr
                INNER JOIN orders_products AS op
                INNER JOIN orders AS o
                WHERE p.`date_removed` IS NULL
                AND p.`type_id`=pt.`id`
                AND p.`id`=pr.`product_id`
                AND p.`id`=op.`product_id`
                AND (p.`name` LIKE '%$param%'
                OR p.`brand` LIKE '%$param%'
                OR p.`material` LIKE '%$param%'
                OR p.`connection_type` LIKE '%$param%')
                GROUP BY p.`id`
                ORDER BY
                    p.`clicks` DESC,
                    p.`date_added`DESC;
            ";
        } else if ($sort === "price-dsc") {
            $sql = "SELECT p.`id` AS product_id,
                    p.`name` AS product_name,
                    p.`image_path` AS product_img_path,
                    pr.`unit_price` AS product_price,
                    COUNT(p.`shop_id`) AS shop_count,
                    p.`clicks`
                FROM products AS p
                INNER JOIN orders_products AS op
                INNER JOIN products_prices AS pr
                WHERE p.`date_removed` IS NULL
                AND op.`product_id`=p.`id`
                AND pr.`product_id`=p.`id`
                AND (p.`name` LIKE '%$param%'
                OR p.`brand` LIKE '%$param%'
                OR p.`material` LIKE '%$param%'
                OR p.`connection_type` LIKE '%$param%')
                GROUP BY p.`id`, p.`shop_id`
                ORDER BY
                    pr.`unit_price` DESC,
                    shop_count DESC";
        } else if ($sort === "price-asc") {
            $sql = "SELECT p.`id` AS product_id,
                    p.`name` AS product_name,
                    p.`image_path` AS product_img_path,
                    pr.`unit_price` AS product_price,
                    COUNT(p.`shop_id`) AS shop_count,
                    p.`clicks` AS clicks
                FROM products AS p
                INNER JOIN orders_products AS op
                INNER JOIN products_prices AS pr
                WHERE p.`date_removed` IS NULL
                AND op.`product_id`=p.`id`
                AND pr.`product_id`=p.`id`
                AND (p.`name` LIKE '%$param%'
                OR p.`brand` LIKE '%$param%'
                OR p.`material` LIKE '%$param%'
                OR p.`connection_type` LIKE '%$param%')
                GROUP BY p.`id`, p.`shop_id`
                ORDER BY
                    clicks DESC,
                    shop_count DESC,
                    pr.`unit_price` ASC";
        } else {
            $sql = "SELECT p.`id` AS product_id,
                    p.`name` AS product_name,
                    p.`image_path` AS product_img_path,
                    pr.`unit_price` AS product_price,
                    COUNT(p.`shop_id`) AS shop_count,
                    p.`clicks` AS clicks
                FROM products AS p
                INNER JOIN orders_products AS op
                INNER JOIN products_prices AS pr
                WHERE p.`date_removed` IS NULL
                AND op.`product_id`=p.`id`
                AND pr.`product_id`=p.`id`
                AND (p.`name` LIKE '%$param%'
                OR p.`brand` LIKE '%$param%'
                OR p.`material` LIKE '%$param%'
                OR p.`connection_type` LIKE '%$param%')
                GROUP BY p.`id`
                ORDER BY
                    clicks DESC,
                    shop_count DESC,
                    pr.`unit_price` ASC";
        }

        $rows["products"] = self::getResult($sql)["rows"];
        $rows["status"] = 200;

        return $rows;
    }


    function featuredProducts($limit) {
        $sql = "SELECT p.`id` AS product_id,
                    p.`name` AS product_name,
                    p.`image_path` AS product_img_path,
                    p.`image_name` AS product_img_name,
                    pr.`unit_price` AS product_price,
                    p.`clicks`,
                    COUNT(p.`shop_id`) AS shop_count
                FROM products AS p
                INNER JOIN orders_products AS op
                INNER JOIN products_prices AS pr
                WHERE p.`date_removed` IS NULL
                AND op.`product_id`=p.`id`
                AND pr.`product_id`=p.`id`
                GROUP BY p.`id`, p.`shop_id`
                ORDER BY
                    p.`clicks` DESC,
                    pr.`unit_price` ASC,
                    shop_count DESC
                LIMIT ?";

        return self::getResult($sql, [$limit]);
    }


    function featuredShops($limit) {
        $sql = "SELECT s.`name` AS shop_name,
                    s.`image_path` AS shop_image_path,
                    s.`id` AS shop_id,
                    s.`rating` AS rating,
                    COUNT(op.`product_id`) AS product_count
                FROM shops AS s
                INNER JOIN orders_products AS op
                INNER JOIN products AS p
                WHERE s.`date_removed` IS NULL
                AND op.`date_removed` IS NULL
                AND p.`shop_id`=s.`id`
                AND op.`product_id`=p.`id`
                GROUP BY s.`id`
                LIMIT ?;";

        return self::getResult($sql, [$limit]);
    }


    function shops() {
        $sql = "SELECT * 
                FROM shops
                WHERE `date_removed` IS NULL";

        return self::getResult($sql);
    }


    function shop($id) {
        $sql = "SELECT * 
                FROM shops
                WHERE `id`=?
                AND `date_removed` IS NULL";

        return self::getResult($sql, [$id]);
    }


    function shopProducts($shopId) {
        $sql = "SELECT p.`id` AS product_id,
                    p.`name` AS product_name,
                    p.`image_path` AS product_img_path,
                    p.`image_name` AS product_img_name,
                    pr.`unit_price` AS product_price,
                    p.`clicks`
                FROM products AS p
                INNER JOIN orders_products AS op
                INNER JOIN products_prices AS pr
                WHERE p.`date_removed` IS NULL
                AND op.`product_id`=p.`id`
                AND pr.`product_id`=p.`id`
                AND p.`shop_id`=?
                GROUP BY p.`id`
                ORDER BY
                    p.`clicks` DESC,
                    pr.`unit_price` ASC";

        return self::getResult($sql, [$shopId]);
    }


    function shopRating($shopId) {
        $sql = "SELECT `rating`
                FROM shops
                WHERE `id`=?
                AND `date_removed` IS NULL";

        return self::getResult($sql, [$shopId]);
    }


    function itemsSold($id) {
        $sql = "SELECT op.`product_id`, op.`item_count`
                FROM orders_products AS op INNER JOIN orders AS o
                WHERE op.`product_id`=?
                AND o.`id`=op.`order_id`
                AND o.`status`='APPROVED'";

        return self::getResult($sql, [$id]);
    }


    function userShopId($userId) {
        $sql = "SELECT `shop_id` FROM shops_users WHERE `user_id`=?";
        
        return self::getResult($sql, [$userId]);
    }


    function shopProductsCount($shopId) {
        $sql = "SELECT `id` FROM products WHERE `shop_id`=?";

        return self::getResult($sql, [$shopId]);
    }

}