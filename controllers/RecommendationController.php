<?php

namespace Main\Controllers;

include "wtAvg.php";

// build a matrix of values from cookies for comparison
// use formula for euclidean distance to get relevance in terms of distance from product details

class RecommendationController {

    function getCookies(): array {
        $cookies = [];

        foreach ($_COOKIE as $key => $value) {
            if ($key === "PHPSESSID") continue;

            $userId = explode("_", $key)[0];

            if (!isset($cookies[$userId])) {
                $cookies[$userId] = [$value];
                continue;
            }

            array_push($cookies[$userId], $value);
        }

        return $cookies;
    }

    function computeRelevance(): array {
        $weights = [
            "type" => [],
            "material" => [],
            "brand" => [],
            "connection_type" => [],
        ];

        $products = (new \Main\Models\FetchModel())->allProductsComplete()["rows"];

        $cookies = self::getCookies();

        $wtAvg = new \wtAvg($weights);
        $weightedCookies = $wtAvg->calculate($cookies)->getWeights();

        $wtTypeArray = $weightedCookies["type"];
        $wtMaterialArray = $weightedCookies["material"];
        $wtBrandArray = $weightedCookies["brand"];
        $wtConnTypeArray = $weightedCookies["connection_type"];

        $parameterCount = count($weightedCookies);
        $weightedProducts = [];

        foreach ($products as $product) {
            $weightedProducts[$product["id"]] = ($wtTypeArray[$product["type"]] + $wtMaterialArray[$product["material"]] + $wtBrandArray[$product["brand"]] + $wtConnTypeArray[$product["connection_type"]]) / $parameterCount;
        }

        return $weightedProducts;
    }

}