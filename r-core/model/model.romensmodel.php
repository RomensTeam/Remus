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


class RomensModel {
    public $registr;
    public $lang; // Фразы фреймворка
    public $app_lang = array();
    public $view;
    public $base;
    public $buffer; // Буффер
    public $layout;
    public $base_list;
    /* Начало класса */
    public function __construct(){
        # Подключаем языковой пакет фреймворка 
        $_LANG = '';
        include_once DIR_CORE.'lang'._DS.strtolower(LANG).'.php';
        $this->lang = $_LANG;
    }
    /* Настройки языка */
    public function app_lang($lang = FALSE,$library = FALSE){
	$lang = ($lang==FALSE)? 'LANG': $lang;
        $this->var_app(array(
            'lang'=>$lang
        ));
        if (CheckFlag('APP_LANG_FORMAT') && CheckFlag('APP_LANG_METHOD')) {
            if (APP_LANG_FORMAT == 'JSON' && APP_LANG_METHOD == 'JSON_FILE') {
                $lang = str_replace('-', '_', $lang);
                if($library == FALSE){
                    $path = DIR_APP_LANG.APP_LANG_PREFIX.$lang.'.'.APP_LANG_EXT;
                    $this->app_lang = $this->open_json($path);
                }
                else{
                    if(is_string($library)){
                        $library = explode(',', $library);
                    }
                    foreach ($library as $lib) {
                        $path = DIR_APP_LANG.$lang._DS.APP_LANG_PREFIX.$lib.'.'.APP_LANG_EXT;
                        $app_lang = $this->open_json($path);
                        $this->app_lang = array_merge($this->app_lang,$app_lang);
                    }
            
                }
            }
        }
        return $this->app_lang;
    }
    /* Управление приложением */
    public function start_html_app($meta){
        if(defined('CHARSET')){
                header('Content-Type: text/html; charset=' . strtolower(CHARSET));
        }
        $this->view->head = array_merge($this->view->head, $meta);
    }
    public function end_html_app(){
        echo $this->buffer;
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
    public function render(){
        $buffer = $this->view->render();
        $array = $this->app_lang;
        # Блоки
        while (true){
            preg_match_all(VIEW_BLOCK_TAG_PATTERN, $buffer, $all); // Получаем все доступные в странице ключей
               if(count($all[1])>0){
                    foreach($all[1] as $value) {
                        $block_path = _filter($this->registr['dir_theme'] . VIEW_BLOCK_TAG_FOLDER . _DS . strtolower($value) . '.tpl');
                        $block = @file_get_contents($block_path);
                        $buffer = str_replace(VIEW_TAG_START . VIEW_BLOCK_TAG_NAME . $value . VIEW_TAG_END , $block, $buffer);
                    }
               }else{break;}
                }
            
        # Ключи
        while(true){
            preg_match_all(VIEW_TAG_PATTERN, $buffer, $all); // Получаем все доступные в странице ключей
            if(count($all[1])>0){
                foreach($all[1] as $value) {
                    $buffer = str_replace(VIEW_TAG_START . $value . VIEW_TAG_END, $array[strtolower($value)], $buffer);
                }
            }else{break;}
            }
        $this->buffer = $buffer;
    }
    public function pattern($name=null){
        return VIEW_TAG_START.strtoupper($name).VIEW_TAG_END;
    }
    public function var_app($var = array()){
        $this->app_lang = array_merge($this->app_lang, $var);
    }
    public function addScript($script, $link = FALSE){
        if(is_array($script)){
            if ($link == FALSE) {
                $this->view->js[] = array_merge($this->view->js,$script);
            } else {
                $this->view->js_link[] = array_merge($this->view->js_link,$script);
            }
        }
        if ($link == FALSE) {
            $this->view->js[] = $script;
        } else {
            $this->view->js_link[] = $script;
        }
        return $this;
    }
    public function addStyle($style, $link = FALSE){
        if(is_array($style)){
            if ($link == FALSE) {
                $this->view->css = array_merge($this->view->css,$style);
            } else {
                $this->view->css_link = array_merge($this->view->css,$style);
            }
        }
        if ($link == FALSE) {
            $this->view->css[] = $style;
        } else {
            $this->view->css_link[] = $style;
        }
        return $this;
    }
    public function addComponent($component){return 0;}
    public function addToHead($string){
        if(is_array($string)){
            $string = implode('', $string);
        }
        $this->view->head_string.= $string;
        return $this;
    }
    public function addToEnd($string){
        if(is_array($string)){
            $string = implode('', $string);
        }
        $this->view->end_string.= $string;
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
        return file_get_contents($block_path);
    }
    public function setLayout($layout_name){
        $layout_path = $this->registr['dir_theme'] . $layout_name . '.tpl';
        if (is_file($layout_path) || !empty($layout_path)) {
            $this->registr['layout'] = $layout_path;
            return TRUE;
        } else {
            return FALSE;
        }
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
	
    /* Пасхалки */
    public function __invoke($var){
        if (is_int($var)) {
            return 'Через ' . $var . ' минут я взорву твой компьютер! :-)';
        }
        if (is_string($var)) {
            return ':-)';
        }
    }
    public function __toString(){
        return 'Привет, я Romens-Engine!';
    }
}