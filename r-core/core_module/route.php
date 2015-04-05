<?php
/**
 * Route - маршрутизатор
 */

class Route {
    
    /**
     * 
     * @param string $name Название приложения
     * @param string|array $pattern Регулярные выражения
     * @param string $adress Название класса @ Метод для запуска; Example: IndexController@Start
     * @param array $settings Настройки
     * @return Route
     */
    public static function addRule( $name, $pattern = '/^$/', $adress = null, $settings = null) {
        $router = array();
        
        $router['regexp'] = $pattern;
        
        if(!empty($adress)){
            $app = explode('@', $adress);
            
            if(count($app) != 2){
                throw new RemusException('ERROR ADD RULE');
            }
            
            $router['module'] = $app[0];
            $router['method'] = $app[1];
            
        } else {
            $router['module'] = $name;
        }
        
        if(!is_null($settings)){
            $settings = (array) $settings;
            $router['settings'] = $settings;
            
            if(isset($settings['file'])){
                $router['file'] = $settings['file'];
            }
        }
        
        Remus()->routing[$name] = $router;
        return true;
    }
    
    public static function addFullRule($name, $array) {
        Remus()->routing[$name] = $array;
        return true;
    }
}