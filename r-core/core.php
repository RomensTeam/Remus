<?php
# Защита
if (!defined('VERSION')){exit();}

ob_start();

# Активируем отладку 
error_reporting(E_ALL);

if(defined('TEST_MODE') && !TEST_MODE) {error_reporting(0);}


# Подключение модулей
    @include DIR_CORE_MODULE.'func.php';        # Функции ядра
    @include DIR_SETTINGS.'config.php';         # Подключаем настройки
    @include DIR_DEFAULT.'config.php';          # Оптимизируем настройки
    @include DIR_CORE_MODULE.'htaccess.php';    # HTACCESS-правки (см. докуоментацию)
    @include DIR_CORE_MODULE.'regisrtry.php';   # Регистр
    @include DIR_CORE_MODULE.'identclient.php'; # Определение клиента
    @include DIR_CORE_MODULE.'remus.php';       # Контроллер
    @include DIR_CORE_MODULE.'Exception.php';   # Исключения
    @include DIR_CORE_MODULE.'theme.php';   	# Класс Тем
    @include DIR_CORE_MODULE.'route.php';   	# Роутер

/**
 * Включаем возможность краткого обращения
 * 
 * Example: ${R}
 */
define('R', 'remus', TRUE);   

# Запускаем контроллер
${R} = new Remus();

# Подключение библиотек с помощью Контроллера
${R}->library(LIBRARY);

# print_var()
if (CheckFlag('TEST_MODE')){
    include _filter(DIR_CORE.'devlib/print_var.php');
}   else{
    function print_var($var = null,$var2= null){}
}

# MODEL
if (CheckFlag('APP_MODEL')) {
    ${R}->load_model(APP_MODEL);
}

# VIEW
if (CheckFlag('APP_VIEW_HTML')) {
    ${R}->load_view(APP_VIEW_HTML);
}

if(CheckFlag('FUNC_FUNNY')){
    include DIR_CORE_MODULE.'funcfunny.php';
}

# Подключаем начальный файл приложения
include DIR_APP.'_start.php';

# Подключаем настройки приложения
include DIR_APP.'config.php';

# Определяем парметр вызова
if($_SERVER['REQUEST_URI']){
	$uri = str_replace('?'.$_SERVER['QUERY_STRING'],'', $_SERVER['REQUEST_URI']);
} else {
	$uri = $_SERVER['REDIRECT_URL'];
}

@define('URI', substr($uri,1));

$router = DIR_CORE_MODULE.'router/'.ROUTER.'.php';

if(is_file($router)){
    include $router;
    
    if( defined('ROUTING_STATUS') != TRUE && defined('NOT_ROUTING_FILE') ) 
    {
        include _filter(DIR_APP_PAGE.NOT_ROUTING_FILE);
    }
}

# Подключаем конечный файл приложения при необходимости
if(!defined('NO_END_APP')){
    include _filter(DIR_APP.'_end.php');
}

# Конец работы фреймворка
if(defined('TEST_MODE_ON') || TEST_MODE){
    if(!defined('TEST_MODE_OFF')){
        
        $time   = sprintf(lang('test_time_script'), microtime(true)-$time_start);
        $memory = sprintf(lang('memory_time_script'), memory_get_usage());
        
        print_var(array($time,$memory), lang('test_time_name'));
        
    }
}