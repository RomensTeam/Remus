<?
/* Делаем роутинг */
if(defined('ROUTER') && (ROUTER === 'DYNAMIC' || ROUTER === 'STATIC')){
    define('URI', str_replace('?'.$_SERVER['QUERY_STRING'],'', $_SERVER['REQUEST_URI']));
    if(ROUTER == 'DYNAMIC'){
        # Когда URI равен '/' то это значит что это index'ная страница
        if(URI == '/'){
            define('ROUTING_STATUS',TRUE);
            $router_file = DIR_APP_PAGE.'index.php';
            include _filter($router_file);
        }
        else{
            if(URI){
                define('REDIRECT_URL',substr($uri,1));
                print_var($routing_rules,'Правила роутинга');
                foreach ($routing_rules as $key => $value){
                    if(preg_match($key,REDIRECT_URL,$romens->routing_matches)){
                        $router_file = DIR_APP_PAGE.$value;
                        $regexp_url = '/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i';
                        # Отправка по ссылке
                        if(preg_match($regexp_url, $value,$romens->routing_matches)){
                            header('Location: '.$value);
                            exit();
                        }
                        # Запуск модуля приложения
                        define('ROUTING_STATUS',TRUE);
                        include _filter(DIR_APP_PAGE.$value);
                        break;
                    }
                }
            }
        }
    }
    if(ROUTER == 'STATIC'){
        $path_to_module = _filter(DIR_APP_PAGE.substr($uri,1));
        if(is_file($path_to_module)){
            include _filter($path_to_module);
        }
    }
}
if(defined('ROUTING_STATUS') != TRUE){
    if(defined('NOT_ROUTING_FILE')){
        define('ROUTING_STATUS',TRUE);
        include _filter(DIR_APP_PAGE.NOT_ROUTING_FILE);
    }
}
?>