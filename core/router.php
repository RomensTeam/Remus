<?
/* Делаем роутинг */
if($_SERVER['REQUEST_URI'] == '/'){
    define('ROUTING_STATUS',TRUE);
    include _filter('app/index.php');
}else{
    if(isset($_SERVER['REDIRECT_URL'])){
        foreach ($app as $key => $value){
            if(preg_match($key,$_SERVER['REDIRECT_URL'])){
                define('ROUTING_STATUS',TRUE);
                include _filter('app/'.$value);
            }
        }
    }
}
if(defined('ROUTING_STATUS') != TRUE){
    if(defined('NOT_ROUTING_FILE')){
        include _filter('app/'.NOT_ROUTING_FILE);
    }
}
?>