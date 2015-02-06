<?php
# Защита
if (!defined('DIR')) {
    exit();
}
/**
 *  Класс Model - Базовый класс
 *
 * @author Romens <romantrutnev@gmail.com>
 * @version 1.2
 */
class Model {
    public $registr;
    public $app_lang = array();
    public $var_app = array();
    public $pfc_status;
    public $base_list;
    
    /* Настройки языка */
    public function app_lang($lang = FALSE,$library = FALSE){
	$lang = ($lang==FALSE)? 'LANG': $lang;
        $lang = str_replace('-', '_', $lang);
        $this->registr['lang'] = $lang;
        $this->var_app(array(
            'lang'=>$lang
        ));
        if (CheckFlag('APP_LANG_FORMAT') && CheckFlag('APP_LANG_METHOD')) {
            if (APP_LANG_FORMAT == 'JSON' && APP_LANG_METHOD == 'JSON_FILE') {
                include DIR_CORE_MODULE.'lang_format'._DS.'json.php';
            }
        }
        return $this->app_lang;
    }
    /* Управление приложением */
    public function start_html_app($meta = array()){
        if(!is_array($meta)){
            $meta = array();
        }
        if(defined('CHARSET')){
                header('Content-Type: text/html; charset=' . strtolower(CHARSET));
        }
        Controller::View()->meta = array_merge(Controller::View()->meta,$meta);
        return $this;
    }
    public function end_html_app($keyword = null,$time = null){
        if(isset($this->registr['end_html_app'])){
            return $this;
        }
        
        if(!empty($this->buffer)){
            echo $this->buffer;
        }
        
        $this->registr['end_html_app'] = TRUE;
    }
    /* Взаимодействие с View */
    
    public function render(){
        include _filter(DIR_DEFAULT.'var_app.php');
        $array = array_merge($default_settings,$this->app_lang,$this->var_app);
        $array = array_change_key_case($array, CASE_LOWER);
        
        Controller::View()->setData($array);
        
        $this->buffer = Controller::View()->render();
    }
    
    public function pattern($name=null, $block = false){
        if($block === TRUE){
            return VIEW_TAG_START.strtoupper(VIEW_BLOCK_TAG_NAME.$name).VIEW_TAG_END;
        }
        return VIEW_TAG_START.strtoupper($name).VIEW_TAG_END;
    }
    public function var_app($var = NULL, $value = NULL){
        if($var === NULL){
            return $this->var_app;
        }
        if(is_array($var)){$this->var_app = array_merge($this->var_app, $var);}
        else{ $this->var_app[$var] = $value; }
    }
    public function addScript($script, $link = FALSE){
        if(is_array($script)){
            if ($link == FALSE) {
                Controller::View()->js[] = array_merge(Controller::View()->js,$script);
            } else {
                Controller::View()->js_link[] = array_merge(Controller::View()->js_link,$script);
            }
        }
        if ($link == FALSE) {
            Controller::View()->js[] = $script;
        } else {
            Controller::View()->js_link[] = $script;
        }
        return $this;
    }
    public function addStyle($style, $link = FALSE){
        if(is_array($style)){
            if ($link == FALSE) {
                Controller::View()->css = array_merge(Controller::View()->css,$style);
            } else {
                Controller::View()->css_link = array_merge(Controller::View()->css,$style);
            }
        }
        if ($link == FALSE) {
            Controller::View()->css[] = $style;
        } else {
            Controller::View()->css_link[] = $style;
        }
        return $this;
    }
    public function addToHead($string){
        if(is_array($string)){
            $string = implode('', $string);
        }
        Controller::View()->head_string.= $string;
        return $this;
    }
    public function addToEnd($string){
        if(is_array($string)){
            $string = implode('', $string);
        }
        Controller::View()->end_string.= $string;
        return $this;
    }
    public function setTheme($theme_name){
        return Controller::View()->setTheme($theme_name);
    }
    public function getBlock($name){
        $block_path = _filter(RE_Theme::$dir_theme . 'block' . _DS . strtolower($name) . '.tpl');
        if(is_file($block_path)){
            return file_get_contents($block_path);
        }
        else{
            return FALSE;
        }
    }
    public function setLayout($layout_name,$theme = null){
        return Controller::View()->setLayout($layout_name,$theme);
    }
    
	private function open_json($path){
            if(is_file($path)){
                $lang_json_data = (string) file_get_contents($path);
                if(strlen($lang_json_data) > 0){
                    $lang_data = json_decode($lang_json_data, TRUE);
                    if(is_array($lang_data)){
                        return $lang_data;
                    }
                }
            }
        }
	
    /* Пасхалки */
    public function __toString(){
        return 'Remus.'.VERSION;
    }
}