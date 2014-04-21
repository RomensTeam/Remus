<?
# Защита
if (!defined('DIR')) {
    exit();
}
/**
 *  Класс Romens - Базовый класс
 *
 * @author Romens <romantrutnev@gmail.com>
 * @version 1.2
 */


class Model {
    public $registr;
    public $lang; // Фразы фреймворка
    public $app_lang = array();
    public $var_app = array();
    public $base;
    public $buffer; // Буффер
    public $layout;
    public $pfc_status;
    public $base_list;
    public $view;
    public $site_meta;
    public $controller;
    /* Начало класса */
    public function __construct(){
        # Подключаем языковой пакет фреймворка 
        include_once DIR_CORE.'lang'._DS.strtolower(LANG).'.php';
        $this->lang = $_LANG;
    }
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
    public function start_html_app($meta,$pfc_keyword = null){
        
        if(defined('CHARSET')){
                header('Content-Type: text/html; charset=' . strtolower(CHARSET));
        }
        Controller::View()->head = array_merge(Controller::View()->head, $meta);
        if(CheckFlag('PRERENDER')){
            $this->registr['prerender_path'] = DIR_THEMES.'_'.$this->registr['theme_name']._DS;
            mkdir($this->registr['prerender_path']);
            $this->registr['cashe_file'] = $this->registr['prerender_path'].$this->registr['layout'].'.'.$this->registr['lang'].'.html';

            $cashe_time = filemtime($this->registr['cashe_file']);
            if(!empty($this->registr['app_lang_date'])){
                foreach ($this->registr['app_lang_date'] as $value) {
                    if($cashe_time<$value){
                        $this->prerender(); break;
                    }
                }
            }      
        }
        if(defined('PFC') && PFC && $pfc_keyword != null){
            $path = DIR_LIB.'phpfastcache'._DS.'phpfastcache.php';
            include_once _filter(DIR_LIB.'phpfastcache'._DS.'phpfastcache.php');
            $this->registr['pfc'] = new phpFastCache();
            # Настройка
            phpFastCache::setup('storage', PFC_STORAGE);
            phpFastCache::setup('path', PFC_PATH);
            phpFastCache::setup('key', PFC_KEY);
            phpFastCache::setup('server', explode(',', PFC_SERVER));
            
            $this->registr['var_app'] = $this->var_app;            
            $this->var_app = null;
            $this->var_app = $this->registr['pfc']->get($pfc_keyword);
            if($this->var_app != null){
                $this->var_app = array_merge($this->var_app,  $this->registr['var_app']);
                $this->pfc_status =  TRUE;
            }
            else{
                $this->var_app = $this->registr['var_app'];
                $this->registr['pfc_status'] = FALSE;
            }
            return $this->pfc_status;
        }
        return $this;
    }
    public function end_html_app($keyword = null,$time = null){
        if(isset($this->registr['end_html_app'])){
            return $this;
        }
        if(defined('PFC') && PFC && $keyword != NULL & $time != NULL){
            $this->registr['pfc']->set($keyword,$this->var_app,$time);
        }
        echo $this->buffer;
        $this->registr['end_html_app'] = TRUE;
        return $this;
    }
    /* Работа с базой данных */
    public function connect_base($base = NULL){
        switch (strtolower(BASE_DRIVER)) {
            case 'mysql':
                $this->base = new RomensMYSQL($base);
            break;
            default:
                exit($this->lang['error_base_driver']);
            break;
        }
    }
    public function change_base($base = NULL){
        if (defined('BASE_BASE')) {
            if (is_numeric($base)) {
                $base = intval($base);
                $n = explode(',', BASE_BASE);
                if ($base == NULL) {
                    if (count($n) == 1) {
                        $base = $n[0];
                        $this->base_list = $n[0];
                    }
                    if (count($n) > 1) {
                        $base = $n[0];
                        $this->base_list = $n;
                    }
                } else {
                    if (count($n) == 1) {
                        $base = $n[0];
                        $this->base_list = $n[0];
                    }
                    if (count($n) > 1) {
                        $base = $base - 1;
                        $base = $n[$base];
                        $this->base_list = $n;
                    }
                }
            }
        }
        return $this->base->change_base($base);
    }
    /* Взаимодействие с View */
    public function block_replace($buffer,$array) {
        for($io = 0; $io < 3; $io++){
            preg_match_all(VIEW_BLOCK_TAG_PATTERN, $buffer, $all); // Получаем все доступные в странице ключей
            if(count($all[1])>0){
                foreach($all[1] as $value) {
                    $block_path = _filter($this->registr['dir_theme'] . VIEW_BLOCK_TAG_FOLDER . _DS . strtolower($value) . '.tpl');
                    $block = file_get_contents($block_path);
                    $buffer = str_replace(VIEW_TAG_START . strtoupper(VIEW_BLOCK_TAG_NAME . $value ). VIEW_TAG_END , $block, $buffer);
                }
            }else{break;}
        }
        return $buffer;
    }
    public function render(){
        include _filter(DIR_DEFAULT.'var_app.php');
        $array = array_merge($default_settings,$this->app_lang,$this->var_app);
        $this->getBuffer();
        for($io = 0; $io < 3; $io++){
            $this->buffer = $this->block_replace($this->buffer,$array);
            foreach ($array as $key => $value) {
                $search = VIEW_TAG_START.strtoupper($key).VIEW_TAG_END;
                $this->buffer = str_replace($search,$value, $this->buffer);
            }
            preg_match_all(VIEW_TAG_PATTERN, $this->buffer, $all);
            $all = array_unique($all[1]);
            
            if(count($all)>0){
                foreach($all as $value){
                    if(isset($array[strtolower($value)])){
                        $this->buffer = str_replace(VIEW_TAG_START.strtoupper($value).VIEW_TAG_END, $array[strtolower($value)], $this->buffer);
                    }
                }                
            }else{break;}
        }
        
        if(!TEST_MODE){
            $this->delAllKey();
        }
    }
    
    public function pattern($name=null){
        return VIEW_TAG_START.strtoupper($name).VIEW_TAG_END;
    }
    public function var_app($var = array()){
        $this->var_app = array_merge($this->var_app, $var);
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
    public function addComponent($component){return 0;}
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
        $n = DIR_THEMES . $theme_name . _DS;
        if (is_dir($n)) {
            $this->registr['theme_name'] = $theme_name;
            $this->registr['dir_theme'] = $n;
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function getBlock($name){
        $block_path = _filter($this->registr['dir_theme'] . 'block' . _DS . strtolower($name) . '.tpl');
        if(is_file($block_path)){
            return file_get_contents($block_path);
        }
        else{
            return FALSE;
        }
    }
    public function setLayout($layout_name,$theme = null){
        $layout_path = $this->registr['dir_theme'] . $layout_name . '.tpl';
        if (is_file($layout_path) || !empty($layout_path)) {
            $this->registr['layout_file'] = $layout_path;
            $this->registr['app_lang_date'][] = filemtime($layout_path);
            $this->registr['layout'] = $layout_name;
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function prerender() {
        if(TEST_MODE){echo 'Выполнен Пререндер';}
            $buffer = Controller::View()->render();
            $array = $this->app_lang;
            foreach ($array as $key => $value) {
                    $buffer = str_replace(VIEW_TAG_START.strtoupper($key).VIEW_TAG_END,$value, $buffer);
            }
            $this->buffer = $buffer;
        //$this->render(TRUE);
        $file = fopen($this->registr['cashe_file'], 'c');
        fwrite($file, $this->buffer);fclose($file);
        $this->buffer = null;
    }
    
	/* Приватные функции */
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
        
        private function getBuffer() {
            if(CheckFlag('PRERENDER') && PRERENDER ){
                $path = $this->registr['cashe_file'];
                $this->buffer = @file_get_contents($path);
            }else{
                $this->buffer = Controller::View()->render();
            }
        }
        
        private function delAllKey() {
            preg_match_all(VIEW_TAG_PATTERN, $this->buffer, $all);
            foreach ($all[0] as $all){$this->buffer = str_replace($all, '', $this->buffer);}
        }
        
	
    /* Пасхалки */
    public function __toString(){
        return 'RomensEngine.'.VERSION;
    }
}