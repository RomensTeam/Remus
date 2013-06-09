<?
if(!defined('DIR')){exit();} // Защита
define('HTML',TRUE);
define('NONE',FALSE);
/**
 *  Класс Romens - Базовый класс
 * 
 * @author Romens <romantrutnev@gmail.com>
 * @version 1.0
 */
class RomensModel {
    public  $lang;          // Фразы фреймворка
    public  $app_lang;      // Фразы приложения
    public  $view;          // Класс View
    public  $base;          // База, Базы
    public  $buffer;        // Буффер
    public  $layout;
    public  $base_list;


    /* Начало класса */
    public function __construct(){
        /* Подключаем языковой пакет фреймворка */
        $_LANG = '';
        include_once DIR_CORE.'lang'._DS.strtolower(LANG).'.php';
        $this->lang = $_LANG;unset($_LANG);
    }
    /* Настройки языка */
    public function app_lang($lang = FALSE){
            if(defined('APP_LANG_METHOD')){
                if(defined('APP_LANG_FORMAT') && APP_LANG_FORMAT == 'JSON' && APP_LANG_METHOD == 'JSON_FILE'){
                    $av_lang = array('status'=>FALSE);
                    if ($handle = opendir(DIR_APP_LANG)) {
			while (false !== ($file = readdir($handle))) { 
				if (preg_match('/\.(?:'.APP_LANG_EXT.')/',$file)){ 
					$av_lang[] = str_replace('.'.APP_LANG_EXT,'',$file);
				} 
			}
			closedir($handle); 
		}
                    foreach ($av_lang as $value) {
			if($lang == $value){
				$av_lang = array(
					'lang'=>$lang,
					'status'=>TRUE
				);
				break;
			}
			else{
				$av_lang['status'] = FALSE;
			}
		}
                    if($av_lang['status'] == FALSE || empty($lang)){
			$lang = LANG; 
                    }
                    $lang_file = file_get_contents(_filter(DIR_APP_LANG.$lang.'.json'));
                    if($lang_file != FALSE){unset($av_lang);$this->app_lang = json_decode($lang_file,TRUE);return $this->app_lang;}
                    else{exit($this->lang['not_app_lang']);}
                }
            }
	}
    /* Управление приложением */
    public function start_html_app($meta){
        $this->view = new RomensViewHTML($this);
        $this->view->head = array_merge($this->view->head,$meta);
    }
    public function end_html_app(){
        echo $this->buffer;
    }
    /* Работа с базой данных */
    public function connect_base($base = NULL) {
        switch (strtolower(BASE_DRIVER)) {
            case 'mysql':
                if(defined('ROMENSBASE') || ROMENSBASE){
                    $this->base = new RomensMYSQL($base);
                }
                else{
                    include APP_BASE_START;
                }
            break;
            default:exit($this->lang['error_base_driver']); break;
        }
    }
    public function change_base($base = NULL){
        if(defined('BASE_BASE')){
            if(is_numeric($base)){
                $base = intval($base);
                $n = explode(',', BASE_BASE);
                if($base == NULL){
                    if(count($n) == 1){
                        $base = $n[0];
                        $this->base_list = $n[0];
                    }
                    if(count($n) > 1){
                        $base = $n[0];
                        $this->base_list = $n;
                    }
                }
                else{
                    if(count($n) == 1){
                        $base = $n[0];
                        $this->base_list = $n[0];
                    }
                    if(count($n) > 1){
                        $base = $base-1;
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
        $this->view->render();
        /*
         * В этой функции мы доложны получить все фразы для вывода
         * И сделать подмену ШАБЛОНОВ ФРАЗ на фразы
         * и вывести это!
         */
         $array = array_merge($this->app_lang, array('head'=>$this->view->generateHead()));
         $buffer = ob_get_contents();
         preg_match_all('/{\[([A-Z_]+)\]\}/', $buffer, $all); // Получаем все доступные в странице ключей
         foreach ($all[1] as $value) {
            echo $value.'-'.$array[strtolower($value)].'<br>';
            $buffer = str_replace('{['.$value.']}', $array[strtolower($value)] , $buffer);
         }
         ob_get_clean();
         $this->buffer = $buffer;
    }
    public function type_output($type){
        if($type){
            if(defined('CHARSET')){header('Content-Type: text/html; charset='.strtolower(CHARSET));}
        }
    }
    public function var_app($var=array()){
        $this->app_lang = array_merge($this->app_lang,$var);
    }
    public function addScript($script,$link=FALSE){
        if($link==FALSE){
            $this->view->js[] = $script;
        }
        else{
            $this->view->js_link[] = $script;
        }
    }
    public function addStyle($style,$link=FALSE){
        if($link==FALSE){
            $this->view->css[] = $style;
        }
        else{
            $this->view->css_link[] = $style;
        }
    }
    public function addComponent($component){
        $component = file_get_contents(DIR.'component'._DS.strtolower($component).'.php');
        $component = json_decode($component, TRUE);
        foreach ($component as $key => $value) {
            if($key == 'addStyle'||$key == 'addSript'||$key == 'addToHead'){
                eval('$this->'.$key.'('.$value.');');
            }
        }
        $this->addScript($component, TRUE);
    }
    public function addToHead($string){$this->head_string .= $string;}
    public function setTheme($theme_name){
        $n = DIR_THEMES.$theme_name._DS;
        if(is_dir($n)){
            $this->view->theme = $theme_name;
            $this->view->dir_theme = $n;
            return TRUE;
        }
        else{return FALSE;}
    }
    public function setLayout($layout_name){
        $layout_path = $this->view->dir_theme.$layout_name.'.tpl';
        if(is_file($layout_path) || !empty($layout_path)){
            $this->layout = $layout_path;
            return TRUE;
        }
        else{return FALSE;}
    }
    /* Пасхалки */
    public function __invoke($var){
        if(is_int($var)){return 'Через '.$var.' минут я взорву твой компьютер! :-)';}
        if(is_string($var)){return ':-)';}
    }
    public function __toString(){
        return 'Привет, я Romens-Engine!';
    }
}
//$romens = new Romens($_LANG);
if(defined('LOAD_ROMENS') && LOAD_ROMENS == TRUE){
    $romens = new RomensModel();
}
?>