<?
/* Делаем роутинг */
if($_SERVER['REQUEST_URI'] == '/'){include _filter('app/index.php');}else{
    if(isset($_SERVER['REDIRECT_URL'])){
        foreach ($app as $key => $value){
            if(preg_match($key,$_SERVER['REDIRECT_URL'])){
                include _filter('app/'.$value);
            }
        }
    }
}
?>