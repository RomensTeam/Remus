<?
/**
 * Controller - главный контроллер
 */

class Controller {
    # POST и GET данные
    public $input_data_get = array();
    public $input_data_post = array();
    # MODEL и VIEW
    private static $model = NULL;
    private static $view  = NULL;
    private static $controller  = NULL;
    private static $registr  = NULL;
    #
    public $routing_matches = NULL;
    # ERROR и Exception
    public $message = array();
    
    # Начало класса
    public function __construct() {
        # Определение POST и GET
        $this->input_data_get  = $_GET;
        $this->input_data_post = $_POST;
        
        self::$registr = new Regisrtry;
        
        return $this;
    }
    # Реализация одиночки
    public static function View() {
        if ( empty(self::$view) ) {
            self::$view = new View();
        }
        return self::$view;
    }
    public static function Model() {
        if ( empty(self::$model) ) {
            self::$model = new Model();
        }
        return self::$model;
    }
    
    public static function Controller() {    // Возвращает единственный экземпляр класса. @return Singleton
        if ( empty(self::$controller) ) {
            self::$controller = new self();
        }
        return self::$controller;
    }
    # Управление приложением
    public function run_app($name_module){
        define('ROUTING_STATUS',TRUE);
        if(ROUTER == 'DYNAMIC2'){
            $app = $this->get_app_info($name_module);
            include  _filter(DIR_APP_PAGE.$app['file']);
            try {
                $Controller = $app['module'];
                $AppController = new $Controller();
                $AppController->$app['method']();
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        }
        return $this;
    }
    public function get_app_info($name_module){
        include DIR_SETTINGS.'routing.php';
        include DIR_DEFAULT.'ParentController.php';
        $app = $routing_rules[$name_module];
        if(!isset($app['module'])){
            $app['module'] = $name_module;
        }
        return array_merge($ParrentController,$app);
    }
    # Управление MODEL и VIEW
    public function load_model($model_name){
        $model = 'model.'.strtolower($model_name);
        $this->connect_file($model, DIR_MODEL);
            self::$model = new $model_name();
    }
    public function load_view($view_name) {
        $this->connect_file('view.'.strtolower($view_name), DIR_VIEW);
            self::$view = new $view_name();
    }
    # Подключение библиотек
    public function library($library_list) {
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
    public function connect_file($value,$dir){
        $connect_file = $dir.$value;
		if(substr($connect_file, -4) != '.php'){
			$connect_file .= '.php';
		}
        include_once $connect_file;
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