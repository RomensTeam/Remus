<?
/**
 *  Класс Romens - Базовый класс
 * 
 * @author Romens <romantrutnev@gmail.com>
 * @version 1.0
 */
class Romens {
    private $regisrtry; // Реестр
    public $lang; // Фразы
    public $layout;
    public $layout_dir;
    public $page;
	public $site_meta;
    
    public function __construct(){
		$this->regisrtry = new Regisrtry;
                include_once DIR_CORE.'lang'._DS.strtolower(LANG).'.php';
		$this->lang = $_LANG;
		unset($_LANG);
    }
	
	public function app_lang($lang = FALSE){
            if(defined('APP_LANG_METHOD') and APP_LANG_METHOD == 'JSON_FILE'){
                if(defined('APP_LANG_FORMAT') and APP_LANG_FORMAT == 'JSON_FILE'){
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
                    if($lang_file != FALSE){
			unset($av_lang);
			return json_decode($lang_file,TRUE);
		}
                    else{exit($this->lang['not_app_lang']);}
                }
            }
	}
	
	public function __destruct(){}
	
	public function start_app($meta){
		echo '<!doctype html><html><head>';
		foreach($meta as $key => $val){
			if($key == 'title'){echo '<title>'.$val.'</title>';}
			if($key == 'description' || $key == 'keywords'){echo '<meta name="'.$key.'" content="'.$val.'">';}
		}
		echo'</head><body>';
	}
        
        public function set_layout($layout){
            $this->layout_dir = DIR_LAYOUT.$layout._DS;
        }
        public function set_page($page){
            $page = file_get_contents($this->layout_dir.$page.'.tpl');
            $this->page = $page;
        }

        public function end_app(){
		echo '</body></html>';
		}
		
		public function out_page(){
			echo $this->page;
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
$romens = new Romens();
?>