<?php
namespace Main\Controllers;

class ApiController {

    public function error403() {
        return json_encode([
            "type" => "error",
            "code" => "403",
            "body" => "You are not authorized to access the data.",
        ]);
    }

    public function error404() {
        return json_encode([
            "type" => "error",
            "code" => "404",
            "body" => "Route does not exist.",
        ]);
    }

    public function fetch($data) {
        return $data;
    }

}