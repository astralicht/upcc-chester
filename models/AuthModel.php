<?php
namespace Main\Models;

use Main\Config;

class AuthModel {

    static $configOverride = null;

    function __construct($configOverride = null) {
        if ($configOverride !== null) {
            self::$configOverride = $configOverride;
        }
    }

    function login($data) {
        $data = json_decode($data, true);

        $conn = (new Config(self::$configOverride))->openDbConnection();

        $sql = 'SELECT `id`, `first_name`, `last_name`, `email`, `type`, `dp_path`, `password`, `is_email_confirmed`
        FROM users
        WHERE `email`=?
        AND `date_removed` IS NULL
        LIMIT 1';
        $query = $conn->prepare($sql);
        $query->bind_param('s', $data['email']);
        $query->execute();

        if ($conn->error) return ["status" => 500];

        $result = $query->get_result();
        $row = $result->fetch_assoc();

        if ($row === NULL) return ["status" => 404];

        if (!password_verify($data["password"], $row["password"])) return ["status" => 401];
        
        return ["status" => 200, "user" => $row];
    }
    
}