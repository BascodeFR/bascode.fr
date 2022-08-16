<?php

namespace cavernos\bascode_api\Helpers;

use PHPUnit\Util\Json;
/**
 * Bases est un mélanges de fonction static qui permetent quelques conversions
 * 
 * @package cavernos\bascode_api\Helpers
 * @author Cavernos <louisdescavernes@gmail.com>
 * @version 1.0
 * @access private
 * 
 */
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