<?
// Время работы скрипта
$time_start = microtime(true);

// Определение версии
define('VERSION', '0.2');

// Определение версии PHP
if (version_compare(phpversion(),'5.3.0','<')){
    exit('PHP5.3 Only');
}
// Дерективы
define('_DS',DIRECTORY_SEPARATOR);
define('DIR',realpath(dirname(__FILE__))._DS);

# Определение дирректорий
include_once DIR.'directory.php';
foreach ($directory as $key => $value) {
    if(!defined($key)){
        $value = realpath(DIR.$value)._DS;
        if(is_dir($value)){
            define($key, $value);
        }
    }
}
include DIR_CORE.'core.php';

if(defined('TEST_MODE_ON') || TEST_MODE){
    if(defined('TEST_MODE_OFF')){exit();}
    $time_end = microtime(true);
    $time = $time_end-$time_start;
    printf($romens->lang['test_time_script'],$time);
    @include_once DIR_CORE.'devlib'._DS.'print_var.php';
    print_var($_SERVER);
}
