<?
define('_DS', DIRECTORY_SEPARATOR);
define('DIR', str_replace('\'', '/', realpath(dirname(__FILE__)))._DS); // Z:\home\lol.ru\www\
define('DIR_CORE', DIR.'core'._DS); // Z:\home\lol.ru\www\core\
define('DIR_APP', DIR.'app'._DS); // Z:\home\lol.ru\www\app\

ob_start();

if(defined('CHARSET')){
	header('Content-Type: text/html; charset='.strtolower(CHARSET));
}

function _filter($path){return str_replace('/', _DS, $path);}
function __autoload($class_name){$filename=strtolower($class_name).'.php';$file='lib/class.'.$filename;if(file_exists($file)==false){return false;}include_once _filter($file);}
include _filter('core/lang.php');
include _filter('core/regisrtry.php');
include _filter('core/model.php');
include _filter('core/router.php');
?>
