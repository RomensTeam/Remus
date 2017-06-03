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


    public function StartApp($name,$tagName = null){

        Remus::Model()->app_lang('ru-RU', $name.',main');

        V()->meta += array(
            'title'         => app_lang($name.'_title'),
            'description'   => app_lang($name.'_description'),
            'keywords'      => app_lang($name.'_keywords')
        );
        if(CheckFlag('CacheManager','dir_cache') and !empty($tagName)){
            include DIR_CORE_MODULE.'CacheManager.php';
            M()->cache = new CacheManager('data', 300);
        }
        Remus()->startApp();
    }
}