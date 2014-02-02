<?
class AppController extends Regisrtry {
    public $controller;
    public $model;
    public $view;

    public function __construct($controller,$model,$view) {
        $this->view = $view;
        $this->model = $model;
        $this->controller = $model;
    }
}
?>
