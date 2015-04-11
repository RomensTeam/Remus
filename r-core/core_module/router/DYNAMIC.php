<?
/* Делаем роутинг */
if(defined('ROUTER') && ROUTER == 'DYNAMIC'){
    $uri = URI;
    # Когда URI равен '' то это значит что это index'ная страница
    
    if(!empty($uri)){
        
    include _filter(DIR_SETTINGS.'routing.php');
        
        foreach ($app as $key => $value){
            if(preg_match($key,URI)){
                $router_file = DIR_APP_PAGE.$value;
                $regexp_url = '/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i';
                # Отправка по ссылке
                if(preg_match($regexp_url, $value,${R}->routing_matches)){
                    header('Location: '.$value);
                    exit;
                }
                # Запуск модуля приложения
                $router_file = DIR_APP_PAGE.$value;
                Remus()->run_app($router_file);
                break;
            }
        }
    }
    else {
        $router_file = DIR_APP_PAGE.'index.php';
        Remus()->run_app($router_file);
    }
    
}
?>