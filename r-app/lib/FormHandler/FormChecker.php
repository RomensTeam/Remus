<?php

/**
 * Form
 *
 * @author Romens
 */
namespace FormHandler;
class FormChecker {
    
    private $check = false;
    private $method = false;

    public $Settings = array();
    
    public function __construct($method = 'GET') {
        $this->method = strtolower($method);
    }
    
    public function addPrimary( $name, $type = 'text', $settings = null) {
        $this->Settings[$name] = $settings;
        $this->Settings[$name]['type'] = $type;
        return new Input($this,$name);
    } 
    
    public function get($name,$primary = false) {
        if($primary){
            if($this->method == 'get'){
                if(isset($_GET[$name])){
                    return $_GET[$name];
                } else {
                    return NULL;
                }
            } else {
                if(isset($_POST[$name])){
                    return $_POST[$name];
                } else {
                    return NULL;
                }
            }
        } else {
            if($this->check){
                if(REMUSPANEL){
                    \RemusPanel::log(new \RemusException('Your not start Form checking'), 'danger');
                } else {
                    throw new \RemusException('Your not start Form checking');
                }
            } else {
                return $this->get($name, true);
            }
        }
    }


    public function check() {
        if(empty($this->Settings)){
            \RemusPanel::log('Form check: Not settings', 'error');
            return FALSE;
        }
        foreach ($this->Settings as $name => $input) {
            try {
                $this->check = $this->checkInput($name, $input);
            } catch (\RemusException $exc) {
                \RemusPanel::log($exc, 'error');
                return false;
            }
        }
        \RemusPanel::log('Form check: OK', 'success');
        return true;
    }
    
    /**
     * checkInput() - Проверка элемента
     * 
     * @param string $name Название элемента
     * @param array $input Массив с информацией для проверки
     */
    private function checkInput($name,$input) {
        $source = $this->get($name);
        $check = true;
                
        foreach ($input as $method => $value) {
            if(!isset($input[$method])){
                continue; 
            }
            switch ($method) {
                case 'min':
                    if(strlen($source) < $value){
                        throw new \RemusException('MIN');
                        $check = FALSE;
                    }
                    break;
                
                case 'max':
                    if(strlen($source) > $value){
                        throw new \RemusException(strtoupper($this->method).'["'.$name.'"] не прошел проверку из-за завышеной длины.');
                        $check = FALSE;
                    }
                    break;
                    
                case 'regexp':
                    if(preg_match($value, $source)){
                        throw new \RemusException(strtoupper($this->method).'["'.$name.'"] не прошел проверку по регулярному выражению');
                        $check = FALSE;
                    }
                    break;
                
                case 'set':
                    if(array_search($source, $value) === FALSE){
                        throw new \RemusException(strtoupper($this->method).'["'.$name.'"] не прошел проверку по списку');
                        $check = FALSE;
                    }
                    break;
                
                case 'function':
                    if(!$value($source)){
                        throw new \RemusException(strtoupper($this->method).'["'.$name.'"] не прошел проверку из-за функции');
                        $check = FALSE;
                    }
                    break;
                case 'value':
                    if($source != $value){
                        throw new \RemusException(strtoupper($this->method).'["'.$name.'"] не равен назначеному значению');
                        $check = FALSE;
                    }
                    break;
            }
            if($check == false){
                return FALSE;
            }
        }
        return true;
    }
}

class Input {
    
    private $FormChecker;
    private $Name;

    public function __construct(FormChecker $FormChecker,$name) {
        $this->FormChecker = $FormChecker;
        $this->Name = $name;
        return $this;
    }
    
    public function minimum($min) {
        $this->FormChecker->Settings[$this->Name]['min'] = $min;
    }
    
    public function maximum($max) {
        $this->FormChecker->Settings[$this->Name]['max'] = $max;
    }
    
    public function handler($Handler) {
        $this->FormChecker->Settings[$this->Name]['function'] = $Handler;
    }
    
    public function value($value) {
        $this->FormChecker->Settings[$this->Name]['value'] = $value;
    }
    
    public function regexp($regexp) {
        $this->FormChecker->Settings[$this->Name]['regexp'] = $regexp;
    }
    
    public function set($set) {
        $this->FormChecker->Settings[$this->Name]['set'] = $set;
    }
}