<?php

namespace cavernos\bascode_api\Helpers;

use PHPUnit\Util\Json;

class Bases {    
    /**
     * toJSON Convert params in JSON
     *
     * @param  mixed $json
     * @return string
     */
    public static function toJSON($json) : string{
        return json_encode($json, JSON_PRETTY_PRINT);
    }
    
    /**
     * fromJSON Convert JSON in string
     *
     * @param  string $jsonString
     * @return string
     */
    public static function fromJSON(string $jsonString): string{
       return json_decode($jsonString, true);
    }
}