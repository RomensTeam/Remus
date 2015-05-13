<?php

/**
 * Request
 *
 * @author Romens
 */

class Request {
    public function __construct() {
        
    }
    
    public static function get($name,$return = FALSE) {
        
        if(isset($_GET[$name])){
            return self::getGet($name, $return);
        } elseif (isset($_POST[$name])) {
            return self::getPost($name, $return);
        }
        
        return $return;
    }
    
    public static function getPost($name,$return) {
        if(isset($_POST[$name])){
            return filter_input(INPUT_POST, $name, FILTER_DEFAULT);
        } 
        return $return;
    }
    
    public static function getGet($name,$return) {
        if (isset($_GET[$name])) {
            return filter_input(INPUT_GET, $name, FILTER_DEFAULT);
        }
        return $return;
    }
}
