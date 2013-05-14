<?
/**
 *  Класс Romens - Базовый класс
 * 
 * @author Romens <romantrutnev@gmail.com>
 * @version 1.0
 */
class Romens {
    private $regisrtry;
	private $lang;
    
    public function __construct($lang){
		$this->regisrtry = new Regisrtry;
		$this->lang = $lang;
    }
	
	public function app_lang($lang = FALSE){
		$av_lang = array('status'=>FALSE);
		if ($handle = opendir(DIR_APP.'lang'._DS)) {
			while (false !== ($file = readdir($handle))) { 
				if (preg_match('/\.(?:json)/',$file)){ 
					$av_lang[] = str_replace('.json','',$file);
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
		$lang_file = file_get_contents(_filter(DIR_APP.'lang/'.$lang.'.json'));
		if($lang_file != FALSE){
			return json_decode($lang_file,TRUE);
		}
		else{exit($this->lang['not_app_lang']);}
		
		
	}
	
	    public function __destruct(){
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
$romens = new Romens($_LANG);
?>