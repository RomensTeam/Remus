<?
/* Делаем роутинг */

if($_SERVER['REDIRECT_URL']=='' && $_SERVER['REQUEST_URI'] != '/index.php'){include _filter('app/index.php');}
if($_SERVER['REQUEST_URI'] == '/index.php'){echo 'Типа делать нада чё та';}
foreach ($app as $key => $value){
    if(preg_match($key,$_SERVER['REDIRECT_URL'])){
        include _filter('app/'.$value);
    }
}
?>