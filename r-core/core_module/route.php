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
     * @param string $file Подключаемый файл
     * @param array $settings Настройки
     * @return Route
     */
    public static function addRule( $name, $pattern = '/^$/', $adress = null, $file = null, $settings = null) {
        $router = array();
        
        $router['regexp'] = self::correctPattern($pattern);
        
        if(!empty($adress)){
            $app = explode('@', $adress);
            switch (count($app)) {
                case 2:
                    $router['module'] = $app[0];
                    $router['method'] = $app[1];
                    break;
                case 1:
                    $router['module'] = array_shift($app);
                    break;

                default:
                    throw new RemusException(lang('error_add_route_rule'));
                    break;
            }
            
        } else {
            $router['module'] = $name;
        }
        
        if(!empty($settings)){
            $settings = (array) $settings;
            $router['settings'] = $settings;
            
            if(!empty($file)){
                $router['file'] = $file;
            }
        }
        
        Remus()->routing[$name] = $router;
        return true;
    }
    
    public static function addFullRule($name, $array) {
        Remus()->routing[$name] = $array;
        return true;
    }
    
    /**
     * Исправляет поведение RegExp паттерна
     */
    private static function correctPattern($pattern) {
        $pattern_old = strtoarray($pattern);
        
        $pattern_true = array();
        
        foreach ($pattern_old as $value) {
            
            $first = substr($value, 0,1);
            
            if((explode('^', $value) == 1) and (1 == explode('^', $value))){
                $value = '^'.$value.'$';
            }
            
            if($first != '/'){
                $value = str_replace('/', '\/', $value);
                $value = '/'.$value.'/';
            }
            
            $value = str_replace('\\\/', '\/', $value);
            $pattern_true[] = $value;
        }
        
        return $pattern_true;
    }
    
    
    /* Verbale Patterns */
    
    /**
     * verbalePatternCheck - проверка на соответствии вербального патерна
     * 
     * @param string $pattern Проверяемый паттерн
     * @return boolean Вербален ли паттерн
     */
    public static function verbalePatternCheck($pattern) {
        return preg_match(self::$verbale_patterns['}{'], $pattern);
    }
    
    /**
     * verbalePatternCorrect - заменяет вербальный паттерн на реальный
     * 
     * @param string $pattern Вербальный паттерн
     * @return string Реальный паттерн
     */
    public static function verbalePatternCorrect($pattern) {
        $matches = null;
        $pattern_correct = $pattern; 
        self::$verbale_registr[$pattern] = array();
        preg_match_all(self::$verbale_patterns['}{'], $pattern, $matches);
        $matches = array_shift($matches);
        
        foreach ($matches as $match) {
            $ent = array();
            $flow = explode(':', $match);
            
            if(count($flow) == 2){
                $ent = array(
                    'name'  => str_replace(array('{','}'), '', $flow[0]),
                    'type'  => str_replace(array('{','}'), '', $flow[1]),
                    'match' => $match
                );
            } elseif(count($flow == 1)){
                if($flow[0] != str_replace(array('{','}'), '', $flow[0])){
                    $ent = array(
                        'name'  => str_replace(array('{','}'), '', $flow[0]),
                        'type'  => 'default',
                        'match' => $match
                    );
                }
            }
            
            if(!empty($ent)){
                $flow = array(
                    'name' => $ent['name'],
                    'match' => $ent['match'],
                );
                if(!isset(self::$verbale_patterns[$ent['type']])){
                    $ent['type'] = 'default';
                }
                $flow['pattern'] = self::$verbale_patterns[$ent['type']];
                
                $pattern_correct = str_replace($match, $flow['pattern'], $pattern_correct);
                
                self::$verbale_registr[$pattern][] = $flow;
            }
        }
        return $pattern_correct;
    }
    
    public static function generateRoutingMatches($verbalePattern,$matches) {
        if (!isset(self::$verbale_registr[$verbalePattern])){ return array();}
        $flow = self::$verbale_registr[$verbalePattern];
        array_shift($matches);
        for ($i = 0; $i < count($matches); $i++) {
            if(isset($flow[$i]['name'])){
                Remus()->routing_matches[$flow[$i]['name']] = $matches[$i];
            } else {
                Remus()->routing_matches[] = $matches[$i];
            }
        }
    }
    
    public static $verbale_patterns = array(
        '}{' => '/([\{\}a-zA-Z0-9_:]+)/',
        'default' => '([a-zA-Z0-9-_]+)',
        'string' => '([a-zA-Z0-9]+)',
        'number' => '([0-9]+)'
    );
    
    public static $verbale_registr = array();
}