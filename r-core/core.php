<?
# Защита
if (!defined('VERSION')){exit();}
# Тестовый режим
if (defined('TEST_MODE') && TEST_MODE){error_reporting(E_ALL);}else{error_reporting(0);}
# Подключаем настройки
include DIR_SETTINGS.'config.php';
# Определяем 
if(isset($_SERVER['HTTPS'])&&$_SERVER['HTTPS']=='on'&&!defined('URLS')&&defined('URL')){
    define('URLS',  str_replace('http://', 'https://', URL));
}
# Подключении модулей
    # Функции ядра
    include DIR_CORE_MODULE.'func.php';
    # Директории фреймворка
    include _filter(DIR_SETTINGS.'core_directory.php');
    framework_directory($directory);
    # Оптимизируем настройки
    include _filter(DIR_CORE_MODULE.'config_optimal.php');
    # HTACCESS-правки (см. докуоментацию)
    include _filter(DIR_CORE_MODULE.'htaccess.php');
    # Регистр
    include _filter(DIR_CORE_MODULE.'regisrtry.php');
    
    
/* MODEL */
if (CheckFlag('APP_MODEL')) {
    include DIR_MODEL.'model.'.strtolower(APP_MODEL).'.php';
}
if (CheckFlag('LOAD_ROMENS')) {
    $romens = new RomensModel();
}
# print_var()
if (CheckFlag('TEST_MODE')){
    include _filter(DIR_CORE.'devlib'._DS.'print_var.php');
}   else{
    function print_var($var){
        create_function($args, $code);
    }
}

/* VIEW */
if (CheckFlag('APP_VIEW_HTML')) {
    include DIR_VIEW.'view.'.strtolower(APP_VIEW_HTML).'.php';
}
if (CheckFlag('APP_VIEW_JSON')) {
    include DIR_VIEW.'view.'.strtolower(APP_VIEW_JSON).'.php';
}

# Start
ob_start();
if (CheckFlag('APP_VIEW_HTML')) {
    $site_meta = array();
}
# Подключаем начальный файл приложения
if(is_file(DIR_APP.'_start.php')){
    include DIR_APP.'_start.php';
}
# Подключаем настройки приложения
if(is_file(DIR_APP.'config.php')){
    include DIR_APP.'config.php';
}
# Подключаем роутер
if(is_file(DIR_CORE_MODULE.'router.php')){
    include DIR_CORE_MODULE.'router.php';
}
# Подключаем конечный файл приложения
if(!defined('NO_END_APP')){
    if(is_file(DIR_APP.'_end.php')){
        include DIR_APP.'_end.php';
    }
}