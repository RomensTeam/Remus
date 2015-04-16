<?php
# Защита
if (!defined('VERSION')){exit();}

ob_start();

include_once DIR_CORE_MODULE.'core.php';

# Активируем отладку 
error_reporting(E_ALL);


# Подключение модулей
Core::load_modules();


if(defined('TEST_MODE') && !TEST_MODE) {error_reporting(0);}

/**
 * Включаем возможность краткого обращения
 * 
 * Example: ${R}
 */
@define('R', 'remus', TRUE);   

# Запускаем контроллер
${R} = new Remus();

# Подключение библиотек с помощью Контроллера
${R}->library(LIBRARY);

Core::test_lib();

# MODEL
Core::loadModel();

# VIEW
    Core::loadView();

if(CheckFlag('FUNC_FUNNY')){
    include_once DIR_CORE_MODULE.'funcfunny.php';
}

# Подключаем начальный файл приложения
include_once DIR_APP.'_start.php';

# Подключаем настройки приложения
include_once DIR_APP.'config.php';

# Определяем парметр вызова
Core::router();
# Подключаем конечный файл приложения при необходимости

Core::end();


if(defined('TEST_MODE_ON') || TEST_MODE){
            if(!defined('TEST_MODE_OFF')){

                $time   = sprintf(lang('test_time_script'), microtime(true)-$time_start);
                $memory = sprintf(lang('memory_time_script'), memory_get_usage());

                print_var(array($time,$memory), lang('test_time_name'));

            }
        }