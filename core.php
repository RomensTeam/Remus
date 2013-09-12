<?
if (!defined('VERSION')) {
exit();
}
if (defined('TEST_MODE') && TEST_MODE == TRUE) {
    error_reporting(E_ALL);
} else {
    error_reporting(0);
}
/* Директории */
define('_DS', DIRECTORY_SEPARATOR);
define('DIR', str_replace('\'', '/', realpath(dirname(__FILE__))) . _DS);
define('DIR_CORE', DIR . 'core' . _DS);
define('DIR_APP', DIR . 'app' . _DS);
define('DIR_APP_LANG', DIR_APP . 'lang' . _DS);
define('DIR_THEMES', DIR . 'themes' . _DS);
define('DIR_MODEL', DIR_CORE . 'model' . _DS);
define('DIR_VIEW', DIR_CORE . 'view' . _DS);
define('DIR_LIB', DIR_CORE . 'lib' . _DS);
define('DIR_INTERFACE', DIR_LIB . 'interface' . _DS);
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' && !defined('URLS')&& defined('URL')) {
    define('URLS',  str_replace('http://', 'https://', URL));
}
/* Маленькие функции */
function _filter($path) {
    return str_replace('/', _DS, $path);
}
function __autoload($class) {
    $file = DIR_LIB . strtolower($class) . '.php';
    if (file_exists($file)) {
        return false;
    }
    include _filter($file);
}
function CheckFlag($const = null) {
    return defined($const) && constant($const);
}
function TestModeOn() {
    define('TEST_MODE_ON', TRUE);
}
include _filter(DIR_CORE . 'config_optimal.php');
include _filter(DIR_CORE . 'htaccess.php');
include _filter(DIR_CORE . 'regisrtry.php');
/* MODEL */
if (CheckFlag('APP_MODEL')) {
    include DIR_MODEL . 'model.' . strtolower(APP_MODEL) . '.php';
}
if (defined('LOAD_ROMENS') && LOAD_ROMENS == TRUE) {
    define('HTML', TRUE);
    define('NONE', FALSE);
    $romens = new RomensModel();
}
# print_var()
if (CheckFlag('TEST_MODE')){include _filter(DIR_CORE . 'devlib' . _DS . 'print_var.php');}else{function print_var($var){}}

/* VIEW */
if (CheckFlag('APP_VIEW_HTML')) {
    include DIR_VIEW . 'view.' . strtolower(APP_VIEW_HTML) . '.php';
}
if (CheckFlag('APP_VIEW_JSON')) {
    include DIR_VIEW . 'view.' . strtolower(APP_VIEW_JSON) . '.php';
}

# Start
ob_start();
$registr = array();
if (CheckFlag('APP_VIEW_HTML')) {
    $site_meta = array();
}
if(is_file(DIR_APP.'_start.php')){
    include DIR_APP.'_start.php';
}
if(is_file(DIR_APP.'config.php')){
    include DIR_APP.'config.php';
}
if(is_file(DIR_CORE . 'router.php')){
    include DIR_CORE . 'router.php';
}
if(!defined('NO_END_APP')){
    if(is_file(DIR_APP.'_end.php')){
        include DIR_APP.'_end.php';
    }
}