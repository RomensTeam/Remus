<?php

/**
 * VarAppController
 *
 * @author Roman
 */
class VarAppController {

    public function __set($name,$value) {
        Remus::Model()->var_app[$name] = $value;
    }
    
    public function __get($name) {
        return Remus::Model()->var_app[$name];
    }
    
    public function __unset($name) {
        unset(Remus::Model()->var_app[$name]);
    }
}
