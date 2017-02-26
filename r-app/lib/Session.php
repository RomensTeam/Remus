<?php

/**
 * Session - класс для управления сессиями
 *
 * @author Romens
 */

class Session implements ArrayAccess {
    
    /**
     * 
     * @var string Название сессии
     */
    public $name;
    
    /**
     * Включаем управление сессиями
     * 
     * @param string $name Название сессии
     */
    public function __construct($name = null) 
    {
        if(!empty($name)){
            $this->name($name);
        }
        if(session_status() !== PHP_SESSION_ACTIVE){
            session_start();
        }
    }
    
    /**
     * Назначаем название сессии
     * 
     * @param string $name Название сессии
     */
    public static function name($name) 
    {
        return $this->name = session_name($name);
    }
    
    /**
     * Получаем время истечения сессии
     */
    public static function cache_expire() 
    {
        return session_cache_expire();
    }
    
    public static function destroy() 
    {
        session_unset();
        $result = session_destroy();
        if($result){
            return $result;
        } else {
            unset($_COOKIE[$this->name()]);
            return session_destroy();
        }
    }
    
    public static function id($id = null) 
    {
        return session_id($id);
    }
    
    public static function get($name,$return = FALSE) 
    {
        if(isset($_SESSION[$name])){
            return $_SESSION[$name];
        }
        if(!$return) {return FALSE;}
    }
    
    public static function set($name,$value = null) 
    {
        if(is_null($value)){
            unset($_SESSION[$name]);
            return true;
        } else {
            $_SESSION[$name] = $value;
        }
    }
    
    public function offsetExists($name) 
    {
        return isset($_SESSION[$name]);
    }
    
    public function offsetGet($name) 
    {
        return $this->get($name);
    }
    
    public function offsetSet($name,$value) 
    {
        $this->set($name, $value);
    }
    
    public function offsetUnset($name) 
    {
        $this->set($name);
    }
    
}
