<?
# Защита
if (!defined('VERSION')){exit();}
error_reporting(E_ALL);
# Тестовый режим
if(defined('TEST_MODE')){
    if(!TEST_MODE){
        error_reporting(0);
    }
}
# Подключении модулей
    # Функции ядра
    include DIR_CORE_MODULE.'func.php';
    # Подключаем настройки
    include DIR_SETTINGS.'config.php';
    # Оптимизируем настройки
    include DIR_DEFAULT.'config.php';
    # HTACCESS-правки (см. докуоментацию)
    include DIR_CORE_MODULE.'htaccess.php';
    # Регистр
    include DIR_CORE_MODULE.'regisrtry.php';
    # Контроллёр
    include DIR_CORE_MODULE.'controller.php';

# Включаем возможность краткого обращения
define('R', 'romens',TRUE);   

# Запускаем контроллер
$controller = new Controller();

# Подключение библиотек с помощью Контроллера
include_once DIR_SETTINGS.'library.php';
$controller->library($library_list);

# Определяем защищённые
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' && !defined('URLS') && defined('URL')){
    define('URLS',  str_replace('http://', 'https://', URL));
    define('HTTPS', TRUE);
}

# print_var()
if (CheckFlag('TEST_MODE')){
    include _filter(DIR_CORE.'devlib/print_var.php');
}   else{
    function print_var($var){}
}

# MODEL
if (CheckFlag('APP_MODEL')) {
    $controller->load_model(APP_MODEL);
    if(CheckFlag('LOAD_MODEL')) {
        $romens = $controller->model;
    }
}

# VIEW
if (CheckFlag('APP_VIEW_JSON')) {
    $controller->load_view(APP_VIEW_JSON);
}
if (CheckFlag('APP_VIEW_HTML')) {
    $controller->load_view(APP_VIEW_HTML);
    $view = APP_VIEW_HTML;
    $romens->view = new $view($romens);
    $site_meta = array();
}

# Start
ob_start();

# Подключаем начальный файл приложения
include DIR_APP.'_start.php';

# Подключаем настройки приложения
include DIR_APP.'config.php';

# Определяем парметр вызова
$uri = (string) str_replace('?'.filter_input(INPUT_SERVER, 'QUERY_STRING'),'', filter_input(INPUT_SERVER, 'REQUEST_URI'));
@define('URI', substr($uri,1));

# Определяем роутер
$router = DIR_CORE_MODULE.'router/'.ROUTER.'.php';

if(is_file($router)){
    # Вызов Роутера
    include _filter($router);
    
    # Файл подключаемый в случае если не одно из приложений не подходит под правила роутинга
    if(defined('ROUTING_STATUS') != TRUE){
        if(defined('NOT_ROUTING_FILE')){
            include _filter(DIR_APP_PAGE.NOT_ROUTING_FILE);
        }
    }
}

# Подключаем конечный файл приложения
if(!defined('NO_END_APP')){
    include DIR_APP.'_end.php';
}
