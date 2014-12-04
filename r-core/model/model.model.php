<?
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
    public $lang; // Фразы фреймворка
    public $app_lang = array();
    public $var_app = array();
    public $base;
    public $buffer; // Буффер
    public $layout;
    public $pfc_status;
    public $base_list;
    public $view;
    public $site_meta = array();
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
    public function start_html_app($meta = array(),$pfc_keyword = null){
        if(!is_array($meta)){
            $meta = array();
        }
        if(defined('CHARSET')){
                header('Content-Type: text/html; charset=' . strtolower(CHARSET));
        }
        Controller::View()->head = array_merge(Controller::View()->head,Controller::Model()->site_meta,$meta);
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
            $this->config_prerender($pfc_keyword);
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
    /* Взаимодействие с View */
    public function block_replace($buffer,$array) {
        for($io = 0; $io < 3; $io++){
            preg_match_all(VIEW_BLOCK_TAG_PATTERN, $buffer, $all);
            if(count($all[1])>0){
                foreach($all[1] as $value) {
                    $block_path = $this->registr['dir_theme']. strtolower(VIEW_BLOCK_TAG_FOLDER . _DS .$value) . '.tpl';
                    if(!is_file($block_path)){
                        if (TEST_MODE) echo 'Ошибка <code>'.$block_path.'</code><br>';
                    }else{
                    $block = file_get_contents($block_path);
                    $buffer = str_replace(VIEW_TAG_START . strtoupper(VIEW_BLOCK_TAG_NAME . $value ). VIEW_TAG_END , $block, $buffer);
                }
                }
            }else{break;}
        }
        return $buffer;
    }
    public function fill_replace($buffer,$array) {
        /**
         * 
         * Example:   {[<p>NAME_FILL</p>]|[NAME_FILL]}
         * 
         * RegExp:   /\{\[(.*)\](?:)?\|\[([A-Z0-9_]+)\]\}/
         */
        preg_match_all(FILL_TAG_PATTERN, $buffer, $all); // Получаем все доступные в странице ключе
        $number = count($all[0]);
        //$buffer = str_replace($all[0], $array[$all[1]], $buffer);
        for ($c = 0; $c < $number; $c++) {
            $name = strtolower($all[2][$c]);
            if(isset($array[$name]) and $array[$name] != '' and !is_bool($array[$name])){
                preg_match_all('/('.strtoupper($name).')/', $all[1][$c], $matches);
                if(count($matches[0]) > 0){
                    $value = str_replace(strtoupper($name), $array[$name], $all[1][$c]);
                }else{
                    $value = str_replace(FILL_ALTER_TAG_PATTERN, $array[$name], $all[1][$c]);
                }
                $buffer = str_replace($all[0][$c], $value, $buffer);
            }
        }
        return $buffer;
    }
    public function render(){
        include _filter(DIR_DEFAULT.'var_app.php');
        $array = array_merge($default_settings,$this->app_lang,$this->var_app);
        $array = array_change_key_case($array, CASE_LOWER);
        $this->getBuffer();
        
        for($io = 0; $io <= 3; $io++){
            $this->buffer = $this->block_replace($this->buffer,$array);
			foreach ($array as $key => $value) {
				$search = VIEW_TAG_START.strtoupper($key).VIEW_TAG_END;
				$this->buffer = str_replace($search,$value, $this->buffer);
			}
			$this->buffer = $this->fill_replace($this->buffer,$array);
			preg_match_all(VIEW_TAG_PATTERN, $this->buffer, $all);
			foreach(array_unique($all[1]) as $value){
				if(isset($array[strtolower($value)])){
					$this->buffer = str_replace(VIEW_TAG_START.strtoupper($value).VIEW_TAG_END, $array[strtolower($value)], $this->buffer);
				}
			}                
		}
        # Убираем мусор за собой
        if(!TEST_MODE){
            $this->delAllKey();
        }
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
        $dir_theme = DIR_THEMES . $theme_name . _DS;
        if (is_dir($dir_theme)) {
            $this->registr['theme_name'] = $theme_name;
            $this->registr['dir_theme'] = $dir_theme;
            
            if(!isset($this->theme)){
                include DIR_CORE_MODULE.'theme.php';
                $this->theme = new RE_Theme($dir_theme);
            }
            
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
        
        $layout_path = $this->registr['dir_theme'].LAYOUT_FOLDER._DS.$layout_name.'.tpl';
        
        if (is_file($layout_path) && !empty($layout_path)) {
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
        $file = fopen($this->registr['cashe_file'], 'c');
        fwrite($file, $this->buffer);fclose($file);
        $this->buffer = null;
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
            preg_match_all(FILL_TAG_PATTERN, $this->buffer, $all);
            foreach ($all[0] as $all){$this->buffer = str_replace($all, '', $this->buffer);}
        }
        
        private function config_prerender($pfc_keyword){
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
        
	
    /* Пасхалки */
    public function __toString(){
        return 'RomensEngine.'.VERSION;
    }
}