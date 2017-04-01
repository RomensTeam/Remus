<?php

/**
 * Controller - главный контроллер
 * 
 * @package RemusStandart
 * @version 0.3
 * @author Romens <romantrutnev@gmail.com>
 */
class Remus {
    
    /**
     * @var Model Модель
     */
    private static $model = NULL;
    
    /**
     * @var View Отоброжение
     */
    private static $view  = NULL;
    
    /**
     * @var string тип данных для отображения
     */
    private static $viewCore  = 'html';
    
    /**
     * @var Remus Контроллер
     */
    private static $controller  = NULL;
    
    /**
     * @var Route Контроллер
     */
    public static $route  = NULL;
    
    /**
     * @var array Совпадения с регулярным выражением
     */
    public $routing_matches = NULL;
    
    /**
     * @var array Маршрутизатор
     */
    public $routing = array();
    
    /**
     * @var array Языковой пакет фреймворка
     */
    public $lang = array();
    
    /**
     * 
     */
    private $registr;
    
    /**
     * 
     */
    public $settings = array();

    # Начало класса
    public function __construct() {
        
        self::$route = new Route();
        
        # Подключаем языковой пакет фреймворка 
        $lang = _filter(DIR_CORE.'lang'._DS.  substr(strtolower(LANG),0,2).'.php');
        if(!empty($lang)){
            include $lang;
            $this->lang = $_LANG;
        }
        
        return $this;
    }
    
    /**
     * @return View
     */
    public static function View() {
        if ( empty(self::$view) ) {
            self::$view = new View();
        }
        return self::$view;
    }
    
    /**
     * @return Model
     */
    public static function Model() {
        if ( empty(self::$model) ) {
            self::$model = new Model();
        }
        return self::$model;
    }
    
    /**
     * @return Remus
     */
    public static function Remus() {    // Возвращает единственный экземпляр класса. @return Singleton
        if ( empty(self::$controller) ) {
            self::$controller = new self();
        }
        return self::$controller;
    }
    
    # Управление приложением
    public function run_app($name_module){
        def('ROUTING_STATUS', TRUE);
        M()->registr['modules'][] = $name_module;
        if(REMUSPANEL){
            RemusPanel::log('Запущен модуль: '.$name_module,'warning');
        }
        if(ROUTER == 'DYNAMIC2'){
            $this->run_app_dynamic2($name_module);
        } elseif (ROUTER == 'DYNAMIC') {
            include_once $name_module;
        }
        return $this;
    }
    
    public static $app;

    public function run_app_dynamic2($name_module){
        $app = $this->get_app_info($name_module);
        $app['file'] = _filter(DIR_APP_PAGE.$app['file']);
        
        if(file_exists($app['file'])){
            include $app['file'];
        } elseif (file_exists($app['file'].'.php')) {
            include $app['file'].'.php';
        } else {
            throw new RemusException('Нет файла для запуска приложения');
        }
        
        self::$app = $app;
        $Controller = $app['module'];
        
        if(AJAX and isset($app['settings']['ajax'])){
            $app = $app['settings']['ajax'];
            ob_clean();
            $AppController  = new $Controller($name_module,'ajax');
            if(method_exists($AppController,$app['method'])){
                $method = $app['method'];
                $AppController->$method();
            }else
                throw new RemusException('NOT AJAX METHOD');

            def('TEST_MODE_OFF',FALSE);
            exit;
        } else {
            if (class_exists($Controller, true)) {
                $AppController  = new $Controller($name_module);
            } else {
                throw new RemusException(lang('not_user_controller'));
            }

            if(isset($app['method']) and  method_exists($AppController, $app['method'])){
                $AppController->$app['method']();
            }else {
                if(isset($this->registr['end_html_app'])){
                    throw new RemusException(lang('not_user_controller_method'));
                }
            }
        } 

        $AppController = null;
    }
    
    /* Управление приложением */
    
    public function startApp($viewCore = 'html') {
        
        switch ($viewCore) {
            case 'json':
                if(defined('CHARSET')){
                    header('Content-Type: application/json; charset=' . strtolower(CHARSET));
                }
            break;
            
            case 'xml':
                if(defined('CHARSET')){
                    header('Content-Type: application/xml; charset=' . strtolower(CHARSET));
                }
            break;

            default:
                if(!is_array($viewCore)){
                    $viewCore = array();
                }
                if(defined('CHARSET')){
                    header('Content-Type: text/html; charset=' . strtolower(CHARSET));
                }
                Remus::View()->meta = array_merge(Remus::View()->meta,$viewCore);
                $viewCore = 'html';
            break;
        }
        Remus::$viewCore = $viewCore;
        return $this;
    }
    
    public function endApp() {
        if(isset(M()->registr['end_app'])){return $this;}
        
        switch (self::$viewCore) {
            case 'json':
                ob_clean();
                echo json_encode(M()->var_app,JSON_PRETTY_PRINT);
                define('TEST_MODE_OFF',TRUE);
                exit();
            break;
            
            case 'xml':
                if(defined('CHARSET')){
                    header('Content-Type: application/xml; charset=' . strtolower(CHARSET));
                }
            break;

            default:
                if(!empty(M()->buffer)){
                    echo M()->buffer;
                }

            break;
        }
        M()->registr['end_app'] = TRUE;
        return $this;
    }
    
    protected $_allowTypes = array();
    
    /**
     * getTypes - Подключает типы для их использования
     * 
     * @param string|array $typeName Название типов для подключения
     * @return void
     */
    public function getTypes($typeName) 
    {
        if(is_string($typeName))
            {$typeName = array($typeName);}
        
        foreach ($typeName as $type) {
            if(file_exists(DIR_TYPES.$type.'.php')){
                include_once DIR_TYPES.$type.'.php';
            }
        }
    }

    public function get_app_info($name_module = NULL){
        if(empty($name_module)){
            return self::$app;
        }
        $app = Remus()->routing[$name_module];
        if(!isset($app['module'])){
            $app['module'] = $name_module;
        }
        if(!isset($app['file'])){
            if(file_exists(DIR_APP_PAGE.$name_module.'.php')){
                $app['file'] = $name_module.'.php';
            } else {
                $app['file'] = strtolower($name_module).'.php';
            }
        }
        return $app;
    }
    # Управление MODEL и VIEW
    public function load_model($model_name){
        include DIR_CORE_INTERFACE.'ModelInterface.php';
        $this->connect_file($model_name, DIR_MODEL);
        self::$model = new $model_name();
    }
    public function load_view($view_name) {
        include_once DIR_CORE_INTERFACE.'ViewCoreInterface.php';
        $this->connect_file($view_name, DIR_VIEW);
        self::$view = new $view_name();
    }
    # Подключение библиотек
    public function library($library_list) {
        if($library_list === LIBRARY){
            if(!file_exists(DIR_SETTINGS.'library.php')){ return false;}
            include_once DIR_SETTINGS.'library.php';
        }
        return $this->connect_list_file($library_list, DIR_LIB);
    }
    public function devlib($devlibrary_list) {
        return $this->connect_list_file($devlibrary_list, DIR_CORE.'devlib'._DS);
    }
    # Управление ошибками и исключениями
    public function message() {
        return array_shift($this->message);
    }
    # Мини функции
    public function connect_file($value,$dir = DIR){
        $connect_file = $dir.$value;
		if(substr($connect_file, -4) != '.php'){
			$connect_file .= '.php';
		}
        connect($connect_file);
        return $this;
    }
    
    public function env() {
        $args = func_get_args();
        if(!empty($args)){
            foreach ($args as $value) {
                if(is_string($value)){
                    $value = explode(',', $value);
                }
                if(is_array($value)){
                    foreach ($value as $val) {
                        if(strtolower(ENV)==strtolower($val)) return true;
                    }
                }
            }
        }
        return FALSE;
    }
    
    protected function connect_list_file($list,$dir) {
        $list = (array) $list;
        foreach ($list as $name) {
            $this->connect_file($name, $dir);
        }
        return $this;
    }
}

function Remus() {
    return Remus::Remus();
}