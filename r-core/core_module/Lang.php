<?php

/**
 * Description of Lang
 *
 * @author Roman
 */
class Lang {
    
    /**
     * 
     * @var array Настройки языкового пакета
     */
    protected static $_settings;
    
    public static $_lang;
    
    public static $lang;

    public function __construct($lang = NULL,$lib = null) 
    {
        $this->readSettings();
        
        $lang = ($lang==FALSE)? self::$_settings['defaultLang']: $lang;
        $lang = str_replace('-', '_', $lang);
        
        $this->loadLang($lang, $lib);
        
    }
    
    public function get($name) {
        if(isset(self::$lang[$name])){
            return self::$lang[$name];
        }
        return NULL;
    }
    
    public function loadLang($lang, $library = NULL) {
        $dir = DIR_APP_LANG.$lang._DS;
        
        if(self::$_settings['basicLang'] == $lang){
            $data = open_json($dir.self::$_settings['primaryFiles'].'.json'); 
            if(empty($data)){
                return array();
            } else {                
                return $data;
                
            }
        } else {
            $langPrimary = $this->loadLang(self::$_settings['basicLang'], NULL);
        }
        self::$_lang = $lang;
        
        
        self::$lang = array_merge( $langPrimary, $this->loadLib($library));
    }
    
    public function loadLib($lib) {
        $libarray = strtoarray($lib);
        $array = array();
        $lang = self::$_lang;
        
        foreach ($libarray as $value) {
            $data = open_json(DIR_APP_LANG.$lang._DS.$value.'.json');
            if(!empty($data)){
                $array = array_merge($array,$data);
            } else {
                \RemusPanel::log('app_lang: Отсутствует библиотека фраз приложения - <b>'.$value.'</b>', 'info');
            }
        }
        return $array;
    }
    
    public static function availableLang($lang) {
        foreach (self::$_settings['availableLang'] as $value) {
            if($lang == $value){
                return TRUE;
            }
        }
        return FALSE;
    }
    
    private function readSettings() 
    {
        $settings =  load_settings(DIR_SETTINGS.'lang.json');
        self::$_settings = $settings['lang'];
    }
    
    
    public function __get($name) {
        if(isset(self::$lang[$name])){
            return self::$lang[$name];
        }
        return NULL;
    }
}
