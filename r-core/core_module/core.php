<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of core
 *
 * @author Roman
 */
class Core {
    public static function load_modules() 
    {
        @include_once DIR_CORE_MODULE.'func.php';           # Функции ядра
        @require DIR_SETTINGS.'config.php';            		# Подключаем настройки
        self::optimal_settings();                           # Оптимизируем настройки
        @include_once DIR_CORE_MODULE.'htaccess.php';       # HTACCESS-правки (см. докуоментацию)
        @include_once DIR_CORE_MODULE.'regisrtry.php';      # Регистр
        @include_once DIR_CORE_MODULE.'identclient.php';    # Определение клиента
        @include_once DIR_CORE_MODULE.'remus.php';          # Контроллер
        @include_once DIR_CORE_MODULE.'RemusException.php'; # Исключения
        @include_once DIR_CORE_MODULE.'theme.php';          # Класс Тем
        @include_once DIR_CORE_MODULE.'route.php';          # Роутер
    }
    
    public static function test_lib()
    {
        # print_var()
        if (CheckFlag('TEST_MODE')){
            include_once _filter(DIR_CORE.'devlib/print_var.php');
        }   else{
            function print_var(){}
        }
    }
    
    public static function optimal_settings() {
        if(file_exists(DIR_DEFAULT.'config.php')){
            $flag = require DIR_DEFAULT.'config.php';
            
            foreach ($flag as $key => $value) {
                $key = strtoupper($key);
                if(!defined($key)){
                    @define($key,$value);
                }
            }

            # Экономим память
            unset($flag);

            # Определяем защищённые
            if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' && !defined('URLS') && defined('URL')){
                @define('URLS',  str_replace('http://', 'https://', URL));
                @define('HTTPS', TRUE);
            }
            
        }
    }

    public static function loadModel()
    {
        if (CheckFlag('APP_MODEL')) {
            Remus()->load_model(APP_MODEL);
        }
    }
    
    public static function loadView()
    {
        if (CheckFlag('APP_VIEW_HTML')) {
            Remus()->load_view(APP_VIEW_HTML);
        }
    }
    
    public static function router()
    {
        if($_SERVER['REQUEST_URI']){
			$uri = substr($_SERVER['SCRIPT_NAME'], 0, strlen($_SERVER['SCRIPT_NAME'])-9);
			$uri = str_replace($uri,'',$_SERVER['REQUEST_URI']);
            $uri = str_replace('?'.$_SERVER['QUERY_STRING'],'', $uri);
        } else {
            $uri = $_SERVER['REDIRECT_URL'];
        }

        @define('URI', substr($uri,1));

        $router = DIR_CORE_MODULE.'router/'.ROUTER.'.php';

        if(is_file($router)){
            include_once $router;

            if( defined('ROUTING_STATUS') != TRUE && defined('NOT_ROUTING_FILE') ) 
            {
                include_once _filter(DIR_APP_PAGE.NOT_ROUTING_FILE);
            }
        }
    }
    
    public static function end()
    {
        if(!defined('NO_END_APP')){
            include_once _filter(DIR_APP.'_end.php');
        }
    }
}
