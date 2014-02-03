<?
/**
 * Controller - ������� ����������
 */

class Controller extends Regisrtry {
    # POST � GET ������
    public $input_data_get = array();
    public $input_data_post = array();
    # MODEL � VIEW
    public $model = NULL;
    public $view  = NULL;
    # ERROR � Exception
    public $message = array();
    
    # ������ ������
    public function __construct() {
        # ����������� POST � GET
        $this->input_data_get  = $_GET;
        $this->input_data_post = $_POST;
        
        return $this;
    }
    # ���������� �����������
    public function run_app($name_module){
        define('ROUTING_STATUS',TRUE);
        $this->connect_file($name_module, DIR_APP_PAGE);
        return $this;
    }
    # ���������� MODEL � VIEW
    public function load_model($model_name) {
        $this->connect_file('model.'.strtolower($model_name).'.php', DIR_MODEL);
        return $this;
    }
    public function load_view($view_name) {
        $this->connect_file('view.'.strtolower($view_name).'.php', DIR_VIEW);
        return $this;
    }
    # ����������� ���������
    public function library($library_list) {
        return $this->connect_list_file($library_list, DIR_LIB);
    }
    public function devlib($devlibrary_list) {
        return $this->connect_list_file($devlibrary_list, DIR_CORE.'devlib'._DS);
    }
    # ���������� �������� � ������������
    public function message() {
        return array_shift($this->message);
    }
    # ���� �������
    public function connect_file($value,$dir){
        $connect_file = $dir.$value;
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
}