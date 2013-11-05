<?
if(!defined('DIR')){exit();}

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

function framework_directory($directory){
    foreach ($directory as $key => $value) {
        if(!defined($key)){
            define($key, _filter(DIR.$value._DS));
        }
    }
}