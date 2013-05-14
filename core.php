<?
define('_DS', DIRECTORY_SEPARATOR);
define('DIR', str_replace('\'', '/', realpath(dirname(__FILE__)))._DS); // Z:\home\lol.ru\www\
define('DIR_CORE', DIR.'core'._DS); // Z:\home\lol.ru\www\core\
define('DIR_APP', DIR.'app'._DS); // Z:\home\lol.ru\www\app\
define('DIR_APP_LANG',DIR_APP.'lang'._DS); // Z:\home\lol.ru\www\app\lang\
define('DIR_LAYOUT',DIR.'view'._DS); // Z:\home\lol.ru\www\view\

$host = $_SERVER['HTTP_HOST'];
if(substr($host,-1) == '.'){
    header('Status: 404 Not Found');
    exit();
}
ob_start();

if(defined('CHARSET')){header('Content-Type: text/html; charset='.strtolower(CHARSET));}

function _filter($path){return str_replace('/', _DS, $path);}
function __autoload($class){$file=DIR_CORE.'lib/'.strtolower($class).'.php';if(file_exists($file)){return false;}include_once _filter($file);}
include _filter('core/regisrtry.php');
include _filter('core/model.php');
$romens->site_meta = $site_meta; unset($site_meta);
include _filter('core/router.php');
?>