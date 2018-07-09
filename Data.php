<?php

/**
 * Class for data manipulation.
 * 
 * @author Paul Albert <zone.buffer@gmail.com>
 */

namespace classes;

use classes\Config as Config;


class Data {
    
    /**
     * Data decoding (usually JSON).
     * 
     * @param string $param
     * @param boolean $asArray
     * 
     * @return array | mixed
     */
    public static function decode ($param, $asArray = true) {
        if (Config::IS_DEBUG) {
            echo '<<< input is:  ' . $param . PHP_EOL;
        }
        $return = json_decode($param, (boolean)$asArray);
        return $return;
    }
    
    /**
     * Data encoding (usually JSON).
     * 
     * @param array $param
     * 
     * @return string
     */
    public static function encode (array $param) {
        $return = json_encode($param);
        if (Config::IS_DEBUG) {
            echo '>>> output is: ' . $return . PHP_EOL;
        }
        return $return;
    }
    
    /**
     * Data validation.
     * 
     * @param array $param
     * 
     * @return boolean | array
     */
    public static function validate (array $param) {
        if (!(!empty($param) && is_array($param))) {
            return false;
        }
        
        if (!(isset($param[Config::FIELD_SUM]) && is_numeric($param[Config::FIELD_SUM]) && ($param[Config::FIELD_SUM] > 0))) {
            return false;
        }
        
        if (!(isset($param[Config::FIELD_DAYS]) && is_numeric($param[Config::FIELD_DAYS]) && ($param[Config::FIELD_DAYS] > 0))) {
            return false;
        }
        
        return $param;
    }
    
}
