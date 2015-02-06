<?
class Regisrtry {
    protected static $_data = array();
    
    public static function setVar($name, $value) {
        return self::$_data[$name] = $value;
    }
    public static function getVar($value = null) {
        if(!is_null($value)){
            if(isset(self::$_data[$value])){
                return self::$_data[$value];
            }
        } else {
            return self::$_data;
        }
        
        return NULL;
    }
    public static function issetVar($name) {
        return isset(self::$_data[$name]);
    }
    public static function unsetVar($param) {
        unset(self::$_data[$param]);
    }
}
