<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Router {
    
    public $string;
    public $args = array();
    public $model;
            
    function __construct($model) {
        $this->model = $model;
        $router = $_GET['router'];
        
        if($router == ''){
            $this->string=FALSE;
            $this->args=FALSE;
        }
        if(){}
    }
      

}
?>
