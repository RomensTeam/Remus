<?

/**
 * Controller - главный контроллер
 * 
 * @package RemusStandart
 * @version 0.3
 * @author Romens <romantrutnev@gmail.com>
 */
class Controller {
    
    /**
     * @var array GET
     */
    public $input_data_get = array();
    
    /**
     * @var array POST
     */
    public $input_data_post = array();
    
    /**
     * @var Model Модель
     */
    private static $model = NULL;
    
    /**
     * @var View Отоброжение
     */
    private static $view  = NULL;
    
    /**
     * @var Controller Контроллер
     */
    private static $controller  = NULL;
    
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
    
    # Начало класса
    public function __construct() {
        # Определение POST и GET
        $this->input_data_get  = $_GET;
        $this->input_data_post = $_POST;
        
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
     * @return Controller
     */
    public static function Controller() {    // Возвращает единственный экземпляр класса. @return Singleton
        if ( empty(self::$controller) ) {
            self::$controller = new self();
        }
        return self::$controller;
    }
    # Управление приложением
    public function run_app($name_module){
        @define('ROUTING_STATUS', TRUE);
        if(ROUTER == 'DYNAMIC2'){
            $app = $this->get_app_info($name_module);
            
            include  _filter(DIR_APP_PAGE.$app['file']);
            
            $Controller = $app['module'];
            
            if (class_exists($Controller, true)) {
                $AppController  = new $Controller($name_module);
            } else {
                throw new RemusException('Not Controller app');
            }
            
            $AppController  = new $Controller($name_module);
            
            if(isset($app['method']) and  method_exists($AppController, $app['method'])){
                $AppController->$app['method']();
            }
            
            $AppController = null;
        }
        return $this;
    }

    public function get_app_info($name_module){
        $app = Controller::Controller()->routing[$name_module];
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
        $this->connect_file('model.'.strtolower($model_name), DIR_MODEL);
        self::$model = new $model_name();
    }
    public function load_view($view_name) {
        $this->connect_file('view.'.strtolower($view_name), DIR_VIEW);
            self::$view = new $view_name();
    }
    # Подключение библиотек
    public function library($library_list) {
        if($library_list === LIBRARY){include_once DIR_SETTINGS.'library.php';}
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
        include_once _filter($connect_file);
        return $this;
    }
    protected function connect_list_file($list,$dir) {
        $list = (array) $list;
        foreach ($list as $name) {
            $this->connect_file($name, $dir);
        }
        return $this;
    }
    public static function __callStatic($name, $arguments = NULL){
        if ( empty(self::$registr[$name]) ) {
            self::$registr[$name] = new $name();
        }
        self::$registr[$name];
    }
}