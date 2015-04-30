<?php
/* Делаем роутинг */
if(defined('ROUTER') && ROUTER == 'STATIC'){
    $path_to_module = _filter(DIR_APP_PAGE.substr($uri,1));
    if(is_file($path_to_module)){
        define('ROUTING_STATUS',TRUE);
        include _filter($path_to_module);
    }
}
if(!defined('ROUTING_STATUS')){
    if(defined('NOT_ROUTING_FILE')){
        define('ROUTING_STATUS',TRUE);
        include _filter(DIR_APP_PAGE.NOT_ROUTING_FILE);
    }
}
?>