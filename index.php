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
define('DIR',str_replace('\'','/',realpath(dirname(__FILE__)))._DS);
define('DIR_CORE',DIR.'r-core' . _DS);
define('DIR_SETTINGS',DIR_CORE.'settings'._DS);
define('DIR_CORE_MODULE',DIR_CORE.'core_module'._DS);

include DIR_CORE.'core.php';

if(defined('TEST_MODE_ON') || TEST_MODE){
    if(defined('TEST_MODE_OFF')){exit();}
    $time_end = microtime(true);
    $time = $time_end-$time_start;
    printf($romens->lang['test_time_script'],$time);
    @include_once DIR_CORE.'devlib'._DS.'print_var.php';
    print_var($_SERVER);
}
