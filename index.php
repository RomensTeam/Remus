<?
# Время работы скрипта
    $time_start = microtime(true);

# Определение версии
    define('VERSION', '0.2');

# Определение версии PHP
    if (version_compare(phpversion(),'5.3.0','<')){
        exit('PHP5.3 Only');
    }
# Дерективы
    define('_DS',DIRECTORY_SEPARATOR);
    define('DIR',realpath(dirname(__FILE__))._DS);

# Определение дирректорий
    include_once DIR.'directory.php';

    foreach ($directory as $key => $value) {
        if(!defined($key)){
            $value = realpath(DIR.$value)._DS;
            if(is_dir($value)){
                @define($key, $value);
            }
        }
    }

# Подключаем основу
include DIR_CORE.'core.php';

# Конец работы фреймворка
if(defined('TEST_MODE_ON') || TEST_MODE){
    if(!defined('TEST_MODE_OFF')){
        print_var(sprintf($romens->lang['test_time_script'],microtime(true)-$time_start),$romens->lang['test_time_name']);
    }
}
