<?
if(!defined('DIR')){exit();}

function _filter($path) {
    $path = strtolower(str_replace('/', _DS, $path));
    if(is_file($path) || is_dir($path)){
        return (string) $path;
    }
}
function __autoload($class) {
    $file = DIR_LIB . strtolower($class) . '.php';
    if (!file_exists($file)) {
        return false;
    }
    include $file;
}
function CheckFlag($const = null) {
    return defined($const) && constant($const);
}
function TestModeOn() {
    define('TEST_MODE_ON', TRUE);
}