<?php

/**
 * Message class.
 * 
 * @author Paul Albert <zone.buffer@gmail.com>
 */

namespace classes;


class Message {

    private $_data = [];
    
    /**
     * Class constructor.
     * 
     * @param array $param
     */
    public function __construct (array $param) {
        $this->_data = (array)$param;
    }
    
    /**
     * Getter ("magic" method).
     * 
     * @param string $propertyName
     * 
     * @return mixed | boolean
     */
    public function __get ($propertyName) {
        if (isset($this->_data[$propertyName])) {
            return $this->_data[$propertyName];
        } else {
            return false;
        }
    }
    
    /**
     * Setter ("magic" method).
     * 
     * @param string $propertyName
     * @param mixed $value
     */
    public function __set ($propertyName, $value) {
        $this->_data[$propertyName] = $value;
    }
    
}
