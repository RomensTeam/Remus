<?
# Защита
if(!defined('DIR')){exit();}

/**
 *  Проверяет файл на существование
 */
function _filter($path) {
    $path = str_replace('/', _DS, $path);
    if(is_file($path) || is_dir($path)){
        return (string) $path;
    }
}

/**
 * Вереводит строку в URL
 */
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

/**
 *  Проверка флага (константа типа boolean)
 * 
 * @return boolean 
 */
function CheckFlag($const = null) {
    return defined($const) && constant($const);
}
/**
 * Включение Тестового режима
 */
function TestModeOn() {
    define('TEST_MODE_ON', TRUE);
}
/**
 * Подключает файл с проверкой
 * 
 * Аналог include _filter($path);
 */
function connect($path) {
    $path = _filter($path);
    include $path;
    return NULL;
}
/**
 * Осуществляет перенаправление на необходимую страницу 
 * и завершает работу скрипта
 * 
 * @param mixed $url URL или код 404
 */
function redirect($url = URL){
    if($url == 404){
        $url = URL.'404.php';
    }
    header('Location: '.$url); 
    exit();
}
/**
 * Полное удаление папки
 * 
 */
function removeDir($path) {
    if (is_file($path)) {
      @unlink($path);
    } else {
        array_map('removeDir',glob('/*')) == @rmdir($path);
    }
    @rmdir($path);
}

/**
 * Ставит магические кавычки для безопасного SQL кода (Название таблиц)
 */
function _quote($string = NULL) {
    if($string == NULL){return '`';}
    return ' `'.$string.'` ';
}

/**
 * Ставит магические кавычки для безопасного SQL кода (Значения полей)
 */
function _quoter($string) {
    if(is_numeric($string)){
        return (int) $string;
    }
    if($string == '?'){
        return $string;
    }
    return " '".$string."' ";
}

/**
 * Преобразовыввает строку в шаблон 
 */
function pattern($name){
    if(Controller::Model()){
	return Controller::Model()->pattern($name);
    }
    return NULL;
}

/**
 * Короткий доступ к фразам фреймворка
 */
function lang($name){
    if(isset(Controller::Controller()->lang[$name])){
        return Controller::Controller()->lang[$name];
    }
    return NULL;
}

/**
 * Короткий доступ к фразам приложения
 */
function app_lang($name){
    if(isset(Controller::Model()->app_lang[$name])){
        return Controller::Model()->app_lang[$name];
    }
    return NULL;
}