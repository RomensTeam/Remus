<?
/* Делаем роутинг */
$request_uri = $_SERVER['REQUEST_URI'];
$request_uri = str_replace('?'.$_SERVER['QUERY_STRING'],'', $request_uri);
if($request_uri == '/'){
    define('ROUTING_STATUS',TRUE);
    include _filter('app/index.php');
}else{
    if(isset($_SERVER['REDIRECT_URL'])){
        echo $_SERVER['REDIRECT_URL'];
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