<?

/* Проверяем готовность движка */
if(!SITE_ENGINE || !defined('SITE_ENGINE')){exit();}

/* Создаём фильтр include */
function _filter($path){return str_replace('/', DIRECTORY_SEPARATOR, $path);}

/* Создаём автолоадер */
function __autoload($class_name){$filename=strtolower($class_name).'.php';$file='lib/class.'.$filename;if(file_exists($file)==false){return false;}include _filter($file);}

/* Подключаем языковой пакет и класс Registry(объект как массив) */
include _filter('core/lang.php');
include _filter('core/regisrtry.php');

$_LANG = $_LANG[LANG];

/* Подключаем модель */
include _filter('core/model.php');

include _filter('core/router.php');
exit();
?>
