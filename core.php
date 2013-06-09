<?
if(!defined('VERSION')){exit();} // Защита
if(defined('TEST_MODE') && TEST_MODE == TRUE ){
    error_reporting(E_ALL);
}
/* Прописываем константы-дирректории */
define('_DS', DIRECTORY_SEPARATOR);
define('DIR', str_replace('\'', '/', realpath(dirname(__FILE__)))._DS); // Z:\home\lol.com\www\
define('DIR_CORE', DIR.'core'._DS); // Z:\home\lol.com\www\core\
define('DIR_APP', DIR.'app'._DS); // Z:\home\lol.com\www\app\
define('DIR_APP_LANG',DIR_APP.'lang'._DS); // Z:\home\lol.com\www\app\lang\
define('DIR_THEMES',DIR.'themes'._DS); // Z:\home\lol.com\www\view\
define('DIR_MODEL', DIR_CORE.'model'._DS);
define('DIR_VIEW', DIR_CORE.'view'._DS);
define('DIR_LIB',DIR_CORE.'lib'._DS);
define('DIR_INTERFACE',DIR_LIB.'interface'._DS);
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on'){define('URLS','https://'.$_SERVER['HTTP_HOST'].'/');}
/* Работа движка */
    /* Маленькие функции */
    function _filter($path){return str_replace('/', _DS, $path);}
    function __autoload($class){$file=DIR_LIB.strtolower($class).'.php';if(file_exists($file)){return false;}include _filter($file);}
    
include _filter(DIR_CORE.'htaccess.php');  // Это замена htaccess
ob_start();
include DIR_LIB.'class.'.strtolower(BASE).'.php';
include _filter(DIR_CORE.'regisrtry.php');
/* VIEW */
if(defined('APP_VIEW_HTML')){include DIR_VIEW.'view.'.strtolower(APP_VIEW_HTML).'.php';}
if(defined('APP_VIEW_JSON')){include DIR_VIEW.'view.'.strtolower(APP_VIEW_JSON).'.php';}
/* MODEL */
if(defined('APP_MODEL')){include DIR_MODEL.'model.'.strtolower(APP_MODEL).'.php';}
// Start
$site_meta = array();
@include DIR_APP.'_start.php';
@include DIR_APP.'config.php';
$romens->view->head = $site_meta;
include _filter(DIR_CORE.'router.php');
@include DIR_APP.'_end.php';