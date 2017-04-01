<?php
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
    return $path;
}

/**
 * Вереводит строку в URL
 */
function _urlen($url) {
    $path = str_replace('\\', '/', $url);
    return (string) $path;
}

/***/
function getURL() {
    if(defined('URL')){
        return URL;
    } else {
        $url = str_replace($_SERVER['DOCUMENT_ROOT'], '', $_SERVER['SCRIPT_FILENAME']);
        $url = substr($url, 0, strlen($url)-9);
        $url = 'http://'.$_SERVER['HTTP_HOST'].$url;
        return $url;
    }
}

function getLib($className)
{
        $className = ltrim($className, '\\');
        $fileName  = '';
        $namespace = '';
        if ($lastNsPos = strrpos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
        $fileName = DIR_LIB.$fileName;
        
        if(!file_exists($fileName)){
            throw new RemusException('Not this library: '.$className);
        }
        require $fileName;
}
if(COMPOSER and file_exists(DIR.'vendor'._DS.'autoload.php')){
    require DIR.'vendor'._DS.'autoload.php';
} else {  
    function __autoload($className){
        getLib($className);    
    }
}

function get_user_constants() {
    $constants = get_defined_constants(TRUE);
    return $constants['user'];
}

function input_test($test = 'session') {
    if(is_string($test)){ $test = explode(',', $test);}
    
    foreach ($test as $value) {
        switch (strtolower($value)) {
            case 'session':
                print_var($_SESSION,'SESSION');
                break;
            case 'get':
                print_var($_GET,'GET');
                break;
            case 'post':
                print_var($_POST,'POST');
                break;
            case 'constants':
                print_var(get_user_constants(), 'User Constants');;
                break;
            case 'classes':
                print_var(get_declared_classes(), 'Classes');
                break;
        }
    }
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
    return require $path;
}

function open_json($path){
    if(file_exists($path)){
        $lang_json_data = (string) file_get_contents($path);
        if(strlen($lang_json_data) > 0){
            $lang_data = json_decode($lang_json_data, TRUE);
            if(is_array($lang_data)){
                return $lang_data;
            }
        }
    }
    return NULL;
}

function load_settings($path) {
    if(file_exists($path)){

        $ext = explode('.', $path);
        $ext = strtolower(array_pop($ext));

        if($ext == 'json'){
            return open_json($path);
        } else {
            return connect($path);
        }
    }
}

/**
 * Осуществляет перенаправление на необходимую страницу 
 * и завершает работу скрипта
 * 
 * @param mixed $url URL или код 404
 */
function redirect($url = URL){
    if($url == 404){
        $url = URL.NOT_ROUTING_FILE;
    }
    header('Location: '.$url); 
    exit();
}
/**
 * Полное удаление папки
 * 
 */
function removeDir($path) {
    if (file_exists($path)) {
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
function pattern($name=null, $block = false){
    return Remus::Model()->pattern($name, $block);
}

/**
 * Короткий доступ к фразам фреймворка
 */
function lang($name){
    if(isset(Remus()->lang[$name])){
        return Remus()->lang[$name];
    }
    return NULL;
}

/**
 * Короткий доступ к фразам приложения
 */
/**
 * Короткий доступ к фразам приложения
 */
function app_lang($name){
    $name = strtolower($name);
    if(isset(Lang::$lang[$name])){
        return Lang::$lang[$name];
    }
    return NULL;
}

/**
 * Короткий доступ к переменным приложения
 */
function var_app($var = NULL, $value = NULL){
    return Remus::Model()->var_app($var, $value);
}

/**
 *  Возвращает последний символ строки
 */
function lastSymbol($str) {
    return substr($str, -1);
}

function strtoarray($str) {
    if(is_string($str)){
        return explode(',', $str);
    }
    if(is_array($str)){return $str;}
    return array($str);
}

function def($const, $value ) {
    if(!defined($const)){
        define($const, $value);
    }
}
function delTree($dir) { 
   $files = array_diff(scandir($dir), array('.','..')); 
    foreach ($files as $file) { 
      (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file"); 
    } 
    return rmdir($dir); 
  } 