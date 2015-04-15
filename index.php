<?
// Время работы скрипта
$time_start = microtime(true);
// Определение версии
define('VERSION', '0.11');

if (version_compare(phpversion(), '5.3.0', '<')){
    exit('PHP5.3 Only');
}

include 'config.php';

include 'core.php';

if(TEST_MODE || defined(TEST_MODE_ON)){
    
    if(defined('TEST_MODE_OFF')){
        exit();
    }
    $time_end = microtime(true);
    $time = $time_end - $time_start;
    printf($romens->lang['test_time_script'],$time);
    print_var($_SERVER);
}
