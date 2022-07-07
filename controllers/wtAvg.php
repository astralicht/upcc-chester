<?php

class wtAvg {

    private static $weights;


    function __construct($weights) {
        self::$weights = $weights;
    }


    /**
     * Takes in cookies and does weighted average on all.
     */
    function calculate($cookies): wtAvg {
        $total = 0;

        if (count($cookies) < 1) return $this;

        foreach ($cookies as $userIds) {
            foreach ($userIds as $input) {
                $input = json_decode($input, true);
                
                if ($input["type"] !== "" || $input["type"] !== null) self::$weights["type"][$input["type"]]++;
                if ($input["material"] !== "" || $input["material"] !== null) self::$weights["material"][$input["material"]]++;
                if ($input["brand"] !== "" || $input["brand"] !== null) self::$weights["brand"][$input["brand"]]++;
                if ($input["connection_type"] !== "" || $input["connection_type"] !== null) self::$weights["connection_type"][$input["connection_type"]]++;

                ++$total;
            }
        }

        foreach (self::$weights as $key => $values) {
            foreach ($values as $key2 => $value) {
                self::$weights[$key][$key2] = round($value / $total, 4);
            }
        }

        return $this;
    }


    /**
     * Sorts the weighted elements in descending value.
     */
    function sortWeights(): wtAvg {
        arsort(self::$weights);
        return $this;
    }


    function printWeights($OPTIONS): void {
        $weights = [];

        foreach (self::$weights as $key => $value) {
            echo nl2br(sprintf("%s = %f\r\n", $OPTIONS[$key], $value * 100));
        }

        self::$weights = $weights;

        $keys = array_keys($weights);
        $limit = 2;
        $recommended = [];

        for ($index = 0; $index < $limit; $index++) {
            array_push($recommended, array_shift($keys));
        }
        
        echo sprintf("The most recommended fruits are %s and %s.", $recommended[0], $recommended[1]);
    }


    /**
     * Returns weighted elements.
     */
    function getWeights(): array {
        return self::$weights;
    }


    /**
     * Replaces numeral keys to their respective names.
     */
    function bindNamesToWeights($OPTIONS): wtAvg {
        foreach (self::$weights as $key => $value) {
            $weights[$OPTIONS[$key]] = $value;
        }

        self::$weights = [];
        self::$weights = $weights;

        return $this;
    }

}