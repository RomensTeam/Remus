<?
if(!defined('DIR')){exit();}

/**
 *  Проверяет файл на существование, и подключает если он существует
 */
function _filter($path) {
    $path = str_replace('/', _DS, $path);
    if(is_file($path) || is_dir($path)){
        return (string) $path;
    }
}
function _urlen($url) {
    $path = str_replace('\\', '/', $url);
    return (string) $path;
}
function __autoload($class) {

    $file = _urlen(DIR_LIB.$class.'.php');
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
function connect($path) {
    $path = _filter($path);
    include $path;
    return NULL;
}
function redirect($url = URL){
    if($url == 404){
        $url = URL.'404.php';
    }
    header('Location: '.$url); 
    exit();
}
function removeDir($path) {
    if (is_file($path)) {
      @unlink($path);
    } else {
        array_map('removeDir',glob('/*')) == @rmdir($path);
    }
    @rmdir($path);
}
function _quote($string = NULL) {
    if($string == NULL){return '`';}
    return ' `'.$string.'` ';
}
function _quoter($string) {
    if(is_numeric($string)){
        return (int) $string;
    }
    if($string == '?'){
        return $string;
    }
    return " '".$string."' ";
}
function pattern($name){
	return Controller::Model()->pattern($name);
}