<?php

/**
 * Description of RE_Theme
 *
 * @author Romens
 */
class RE_Theme {
    
    public static $settings     = array();
    public static $dir_theme    = '';
    public static $layout_name  = '';
    public static $layout_file  = '';
    
    public function __construct($dir) {
        self::$dir_theme = $dir;
        $this->readSettings($dir);
        $this->addStyle();
    }
    
    private function readSettings($dir) {
        
        $settings_data = file_get_contents($dir.THEME_FILE);
        $settings = json_decode($settings_data,TRUE);
        
        if($settings == NULL){
            throw new RemusException(lang('not_theme_settings'),301);
        }
        
        self::$settings = $settings;
        return TRUE;
    }
    
    /**
     * addStyle() - Считывает настройки для шаблона и добавляет необходимые 
     * записи в нужные места
     * 
     */
    private function addStyle() {
        foreach (self::$settings  as $key => $value) {
            switch ($key) {
                case 'addStyleLocal':
                    foreach ($value as $values) {
                        $url = URL.'style/'.$values;
                        Remus::View()->addStyle($url,true);
                    }
                    break;
                case 'addStyleLink':
                    foreach ($value as $values) {
                        Remus::View()->addStyle($values,true);
                    }
                    break;    

                case 'addToEndScriptLink':
                    foreach ($value as $values) {
                        Remus::View()->addToEnd('<script src="'.$values.'" type="text/javascript"></script>');
                    }
                    break;
            }
        }
    }
}
