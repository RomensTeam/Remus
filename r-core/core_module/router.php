<?
/* Делаем роутинг */
$redirect_uri = str_replace('?'.$_SERVER['QUERY_STRING'],'', $_SERVER['REQUEST_URI']);
if($redirect_uri == '/'){
    define('ROUTING_STATUS',TRUE);
    include _filter(DIR_APP_PAGE.'index.php');
}else{
    if(isset($redirect_uri)){
        define('REDIRECT_URL',substr($redirect_uri,1));
        foreach ($app as $key => $value){
            if(preg_match($key,REDIRECT_URL)){
                # Отправка по ссылке
                if(preg_match('/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i', $value)){
                    header('Location: '.$value);
                    exit();
                }
                # Запуск пользователя
                define('ROUTING_STATUS',TRUE);
                include _filter(DIR_APP_PAGE.$value);
                break;
            }
        }
    }
}
if(defined('ROUTING_STATUS') != TRUE){
    if(defined('NOT_ROUTING_FILE')){
        include _filter(DIR_APP_PAGE.NOT_ROUTING_FILE);
    }
}
?>