<?
# Защита
if (!defined('VERSION')){exit();}
# Start
ob_start();
# Тестовый режим
error_reporting(E_ALL);

if(defined('TEST_MODE')){
    if(!TEST_MODE){
        error_reporting(0);
    }
}
# Подключение модулей
    include DIR_CORE_MODULE.'func.php';         # Функции ядра
    include DIR_SETTINGS.'config.php';          # Подключаем настройки
    include DIR_DEFAULT.'config.php';           # Оптимизируем настройки
    include DIR_CORE_MODULE.'htaccess.php';     # HTACCESS-правки (см. докуоментацию)
    include DIR_CORE_MODULE.'regisrtry.php';    # Регистр
    include DIR_CORE_MODULE.'identclient.php';  # Определение клиента
    include DIR_CORE_MODULE.'controller.php';   # Контроллёр

# Включаем возможность краткого обращения
define('R', 'romens', TRUE);   

# Запускаем контроллер
new Controller();


# Подключение библиотек с помощью Контроллера
include_once DIR_SETTINGS.'library.php';
Controller::Controller()->library($library_list);

# print_var()
if (CheckFlag('TEST_MODE')){
    include _filter(DIR_CORE.'devlib/print_var.php');
}   else{
    function print_var($var){}
}

# MODEL
if (CheckFlag('APP_MODEL')) {
    Controller::Controller()->load_model(APP_MODEL);
}

# VIEW
if (CheckFlag('APP_VIEW_JSON')) {
    Controller::Controller()->load_view(APP_VIEW_JSON);
}
if (CheckFlag('APP_VIEW_HTML')) {
    Controller::Controller()->load_view(APP_VIEW_HTML);
}

if(CheckFlag('FUNC_FUNNY')){
    include DIR_CORE_MODULE.'funkfunny.php';
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
    
    if(defined('ROUTING_STATUS') != TRUE){
        if(defined('NOT_ROUTING_FILE')){
            include _filter(DIR_APP_PAGE.NOT_ROUTING_FILE);
        }
    }
}

# Подключаем конечный файл приложения
if(!defined('NO_END_APP')){
    include _filter(DIR_APP.'_end.php');
}