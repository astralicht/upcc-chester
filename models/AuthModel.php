<?php
namespace Main\Models;

use Main\Config;

class AuthModel {

    function login($data) {
        $data = json_decode($data, true);
        $conn = (new Config())->openDbConnection();

        $sql = 'SELECT `id`,`first_name`, `last_name`, `type`, `dp_path`
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
        
        return ["status" => 200, "user" => $row];
    }
    
}