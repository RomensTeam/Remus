<?php

/**
 * Core - основа фреймворка
 *
 * @author Roman
 */
class Core {
    
    public function __construct() 
    {
        ob_start();
        $this->test_on();
        self::load_modules();
        $this->test_off();
        $this->loadModules();
        $this->run_app();
    }
    
    private function run_app()
    {
       # Запускаем контроллер
        new Remus();
       
        if(REMUSPANEL)
            new RemusPanel();
        
        # Подключаем начальный файл приложения
        include_once DIR_APP.'_start.php';
        # Подключаем настройки приложения
        include_once DIR_APP.'config.php';
        # Определяем парметр вызова
        Core::router();
        # Подключаем конечный файл приложения при необходимости
        Core::end_app();
    }
    
    private function loadModules()
    {
        # Подключение библиотек с помощью Контроллера
        Remus::Remus()->library(LIBRARY);

        Core::test_lib();

        # MODEL
        Core::loadModel();

        # VIEW
        Core::loadView();
        
        $this->func_funny();
    }
    
    private function func_funny()
    {
        if(CheckFlag('FUNC_FUNNY')){
           include_once DIR_CORE_MODULE.'funcfunny.php';
        }
    }


    private function test_on() 
    {
        error_reporting(E_ALL);
    }
    
    private function test_off() 
    {
        if(defined('TEST_MODE') && !TEST_MODE) 
            {error_reporting(0);}
    }


    public static function load_modules() 
    {
        @require DIR_SETTINGS.'config.php';            		# Подключаем настройки
        self::composerOptimal();                            # Оптимизируем настройки Composer
        @include_once DIR_CORE_MODULE.'func.php';           # Функции ядра
        self::optimal_settings();                           # Оптимизируем настройки
        @include_once DIR_CORE_MODULE.'htaccess.php';       # HTACCESS-правки (см. докуоментацию)
        @include_once DIR_CORE_MODULE.'Regisrtry.php';      # Регистр
        @include_once DIR_CORE_MODULE.'Remus.php';          # Контроллер
        @include_once DIR_CORE_MODULE.'RemusErrorHandler.php'; # Исключения
        @include_once DIR_CORE_MODULE.'RE_Theme.php';       # Класс Тем
        @include_once DIR_CORE_MODULE.'Route.php';          # Роутер
    }
    
    public static function test_lib()
    {
        # print_var()
        if (CheckFlag('TEST_MODE')){
            include_once _filter(DIR_CORE.'devlib/print_var.php');
            
            if (CheckFlag('REMUSPANEL')){
                include_once _filter(DIR_CORE.'devlib/RemusPanel/RemusPanel.php');
            } 
			
        }   else{
            function print_var($data,$name = null){
                if(isset($name))
                    writeLog($name);
                writeLog($data);
            }
        }
    }
    
    public static function optimal_settings() 
    {
        if(!file_exists(DIR_DEFAULT.'config.php')){ return false;}
        
        $config = require DIR_DEFAULT.'config.php';

        foreach ($config as $key => $value) {
            $key = strtoupper($key);
            if(!defined($key)){
                def($key,$value);
            }
        }

        # Экономим память
        unset($flag);

        # Определяем защищённые
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' && !defined('URLS') && defined('URL')){
            def('URLS',  str_replace('http://', 'https://', URL));
            def('HTTPS', TRUE);
        }

        # Определение AJAX-запроса
        if ( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest' ){
               define('AJAX',TRUE);
        } else{
               define('AJAX',FALSE);
        }
}

        
    private static function composerOptimal()
    {
        if(!defined('COMPOSER'))
            {define('COMPOSER', file_exists(DIR.'vendor/autoload.php'));}
    }
    
    public static function loadModel($model = APP_MODEL)
    {
        Remus()->load_model($model);
    }
    
    public static function loadView($view = APP_VIEW)
    {
        Remus()->load_view($view);
    }
    
    public static function router()
    {
        if(isset($_SERVER['REQUEST_URI'])){
            $uri = $_SERVER['REQUEST_URI'];
		    $uri = str_replace('?'.$_SERVER['QUERY_STRING'], '', $uri);
        } else {
            $uri = $_SERVER['REDIRECT_URL'];
        }
        
        if(substr($uri, 0,1) == '/'){
            $uri = substr($uri,1);
        }
        
        def('URI', $uri);
        

        $router = DIR_CORE_MODULE.'router/'.ROUTER.'.php';

        if(file_exists($router)){
            include_once $router;

            if( defined('ROUTING_STATUS') != TRUE && defined('NOT_ROUTING_FILE') ) 
            {
                include_once _filter(DIR_APP_PAGE.NOT_ROUTING_FILE);
            }
        }
    }
    
    public static function end_app()
    {
        if(!defined('NO_END_APP')){
            include_once _filter(DIR_APP.'_end.php');
        }
    }
    
    public function __destruct() {
        if(defined('TEST_MODE_ON') || TEST_MODE){
            if(!defined('TEST_MODE_OFF')){

                $time 	= microtime(true)-TIME_START;
                $time   = sprintf(lang('test_time_script'), '<b>'.$time.'</b>');

                $memory = memory_get_usage();
                $memory = sprintf(lang('memory_time_script'), '<b>'.$memory.'</b>');
                $result = array($time,$memory);
                echo '<script>if(document.title == ""){document.title = "Remus PHP Framework.";}</script>';
                if(REMUSPANEL){
                    RemusPanel::renderPanel('RemusPanel',  implode(', ', $result));
                } else {
                    print_var($result, lang('test_time_name'));
                }
            }
        }
        
    }
}
