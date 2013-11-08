<?
/* Делаем роутинг */
if(defined('ROUTER') && (ROUTER === 'DYNAMIC' || ROUTER === 'STATIC')){
    if(ROUTER == 'DYNAMIC'){
        $uri = str_replace('?'.$_SERVER['QUERY_STRING'],'', $_SERVER['REQUEST_URI']);
        # Когда URI равен '/' то это значит что это index'ная страница
        if($uri == '/'){
            define('ROUTING_STATUS',TRUE);
            $router_file = DIR_APP_PAGE.'index.php';
            include _filter($router_file);
        }
        else{
            if(isset($uri)){
                define('REDIRECT_URL',substr($uri,1));echo REDIRECT_URL;
                foreach ($app as $key => $value){
                    if(preg_match($key,REDIRECT_URL)){
                        $router_file = DIR_APP_PAGE.$value;
                        $regexp_url = '/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i';
                        # Отправка по ссылке
                        if(preg_match($regexp_url, $value)){
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
        
    }
}
if(defined('ROUTING_STATUS') != TRUE){
    if(defined('NOT_ROUTING_FILE')){
        include _filter(DIR_APP_PAGE.NOT_ROUTING_FILE);
    }
}
?>