<?
/* Делаем роутинг */
if(defined('ROUTER') && ROUTER == 'DYNAMIC'){
    $uri = URI;
    # Когда URI равен '' то это значит что это index'ная страница
    if(isset($uri)){
        foreach ($app as $key => $value){
            if(preg_match($key,URI)){
                $router_file = DIR_APP_PAGE.$value;
                $regexp_url = '/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i';
                # Отправка по ссылке
                if(preg_match($regexp_url, $value,$remus->routing_matches)){
                    header('Location: '.$value);
                    exit;
                }
                # Запуск модуля приложения
                $router_file = DIR_APP_PAGE.$value;
                $controller->run_app($router_file);
                break;
            }
        }
    }
    else {
        $router_file = DIR_APP_PAGE.'index.php';
        $controller->run_app($router_file);
    }
    
}
?>