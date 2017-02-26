<?php

/**
 * View - render engine for Remus
 * 
 * @version 2.0
 * @author RomanTrutnev <romantrutnev@gmail.com>
 */

class View {
    
    public $settings   = array(
        'module' => array(
            'block',
            'foreach',
            'fill'
        )
    );
    
    /**
     * @var array Ссылки к CSS файлам
     */
    public $css_link    = array();
    
    /**
     * @var array CSS код
     */
    public $css         = array();
    
    /**
     * @var array Добавляющийся в шапку JavaScript код
     */
    public $js          = array();
    
    /**
     * @var array Добавляющийся в конец JavaScript код
     */
    public $js_end      = array();
    
    /**
     * @var array Добавляющийся в шапку ссылки на JavaScript код
     */
    public $js_link     = array();  
    
    /**
     * @var array Добавляющийся в конец ссылки на JavaScript код
     */
    public $js_link_end = array();
    
    /**
     * @var array META-данные
     */
    public $meta        = array();  #
    
    /**
     * @var string Текст в шапке
     */
    public $head_string = '';
    
    /**
     * @var string Текст в конце
     */
    public $end_string  = '';
    
    /**
     * @var array Все доступные ключи
     */
    protected $all_key  = array();
    
    /**
     * @var array Буффер
     */
    public $buffer   = null;
    
    /**
     * @var array Данные
     */
    public $var_app  = null;
    
    /**
     * Генерирование данных в шапке и конце
     */
    public function generateHead(){
        
        foreach($this->meta as $key => $value) {
			if($key == 'desc'){$key = 'description';}
            if ($key == 'keywords' || $key == 'description' || $key == 'author' || $key == 'robots' || $key == 'url') {
                if(is_string($value))$this->head_string .= '<meta name="'.$key.'" content="'.$value.'">';
            }
            if ($key == 'description' || $key == 'image') {
                if(is_string($value))$this->head_string .= '<meta property="og:'.$key.'" content="'.$value.'" />';
            }
            if ($key == 'favicon'){
                if(is_string($value))$this->head_string .= '<link rel="icon" type="image/'.substr($value, -3).'" href="'.$value.'" />';
            }
            if ($key == 'content-language' || $key == 'Content-Type' || $key == 'Expires' || $key == 'refresh'){
                if(is_string($value))$this->head_string .= '<meta http-equiv="'.$key.'" content="'.$value.'" />';
            }
            if ($key == 'title'){
                if(is_string($value))$this->head_string .= '<title>'.$value.'</title><meta property="og:title" content="'.$value.'" />';
            }
        }
        if(CheckFlag('SUPPORT_DEVELOPERS') ){
            $this->head_string.='<meta name="generator" content="Remus">';
        }
        foreach($this->css_link as $value){
            if(is_string($value))$this->head_string .= '<link href="'.$value.'" rel="stylesheet" type="text/css">';
        }
        foreach($this->js_link as $value){
            if(is_string($value))$this->head_string .= '<script type="text/javascript" src="'.$value.'"></script>';
        }
        if (!empty($this->js)){
            foreach($this->js as $value){
                if(is_string($value))$this->head_string .= '<script type="text/javascript">'.$value.'</script>';
            }
        }
        if (!empty($this->css)){
            foreach($this->css as $value){
                if(is_string($value)) $this->head_string.='<style type="text/css">'.$value.'</style>';
            }
        }
        foreach($this->js_link_end as $value){
            if(is_string($value)) $this->end_string.='<script type="text/javascript" src="'.$value.'"></script>';
        }
        foreach($this->js_end as $value){
                if(is_string($value)) $this->end_string.='<script type="text/javascript">'.$value.'</script>';
        }
    }
    
    /**
     * Объединение МЕТА-данных
     */
    public function head($meta) {
        $this->meta = $this->meta + $meta;
    }
    
    /**
     * Установка данных для рендеринга
     */
    public function setData($data) {
        if(is_null($data)){
            throw new RemusException(lang('null_data_for_render'));
        } else {
            $this->var_app = $data;
        }
    }
    
        public function addScript($script, $link = FALSE){
        if(is_array($script)){
            if ($link == FALSE) {
                Remus::View()->js[] = array_merge(Remus::View()->js,$script);
            } else {
                Remus::View()->js_link[] = array_merge(Remus::View()->js_link,$script);
            }
        }
        if ($link == FALSE) {
            Remus::View()->js[] = $script;
        } else {
            Remus::View()->js_link[] = $script;
        }
        return $this;
    }
    public function addStyle($style, $link = FALSE){
        if(is_array($style)){
            if ($link == FALSE) {
                Remus::View()->css = array_merge(Remus::View()->css,$style);
            } else {
                Remus::View()->css_link = array_merge(Remus::View()->css,$style);
            }
        }
        if ($link == FALSE) {
            Remus::View()->css[] = $style;
        } else {
            Remus::View()->css_link[] = $style;
        }
        return $this;
    }
    public function addToHead($string){
        if(is_array($string)){
            $string = implode('', $string);
        }
        Remus::View()->head_string.= $string;
        return $this;
    }
    public function addToEnd($string){
        if(is_array($string)){
            $string = implode('', $string);
        }
        Remus::View()->end_string.= $string;
        return $this;
    }
    
    /**
     * Установка настроек
     */
    public function setSettings($data, $value = NULL) {
        if(is_array($data)){
            $this->settings = array_merge($data,  $this->settings);
        }
        if(is_string($data)){
            if(is_null($value)){
                # ERROR
                throw new RemusException(lang('wrong_settings_view'));
            }
            $this->settings[$data] = $value;
        }
        
        return $this;
    }
    
    /**
     * Получение первоначального буффера
     */
    protected function getBuffer() {
        
        $layout = $this->getLayout();
        
        if($layout == NULL){
            $this->buffer = null;
            return null;
        }
        
        $this->buffer = 
            '<!doctype html>'.
            '<html lang="ru">'.
            '<head>'.
            '<meta charset="utf-8">'.
            $this->head_string.
            '</head><body>'.
            $layout.
            '</body>'.
            $this->end_string.
            '</html>';
    }
    
    /**
     * Получение полотна для рендеринга
     */
    protected function getLayout() {
        if(!empty(RE_Theme::$layout_file)){
            if(file_exists(RE_Theme::$layout_file)){
                return file_get_contents(RE_Theme::$layout_file);
            } else{
                throw new RemusException(lang('error_no_layout').' - '.RE_Theme::$layout_file);
            }
        }
        return NULL;
    }
    
    
    /**
     * Рендеринг страницы
     */
    public function render($view_core = NULL){
        
        $this->generateHead();
        $this->getBuffer();
        
        if(empty($view_core)){
            if(CheckFlag('VIEW_CORE')){
                $view_core = VIEW_CORE;
            } else {
                return $this->buffer;
            }
        }    
            
        $view_file = DIR_CORE.'view_core'._DS.$view_core.'.php';

        if(file_exists($view_file)){
            include_once $view_file;
        }
        
        if(empty($this->buffer)){
            return NULL;
        }
        
        $render = new $view_core;
        
        if($render instanceof ViewCoreInterface){
            $render->setView($this);
            $render->render();
        } else {
            throw new RemusException(lang('not_support_viewcore'));
        }
        
        # Убираем мусор за собой
        if(!TEST_MODE){
            if($render instanceof ViewCoreInterface){
                $render->clear();
            } else {
                throw new RemusException(lang('not_support_viewcore'));
            }
        }
        
        return $this->buffer;
    }
    
    /**
     * Выбор темы для приложения
     * 
     * @param string $theme_name Название темы
     * @return boolean Статус
     */
    public function setTheme($theme_name = 'default'){
        if(REMUSPANEL){
            RemusPanel::log('Выбрана тема: <span class="badge badge-info">'.$theme_name.'</span>');
        }
        
        $dir_theme = DIR_THEMES . $theme_name . _DS;
        
        if (is_dir($dir_theme)) 
        {    
            if(!isset($this->theme))
            {
                $this->theme = new RE_Theme($dir_theme);
            }
            
            return TRUE;
        
        }
        else 
        {
            throw new RemusException(lang('error_no_theme').' - '.$dir_theme);
        }
    }
    
    /**
     * Выбор полотна для приложения
     * 
     * @param  string  $layout_name Название полотна
     * @return boolean Статус
     */
    public function setLayout($layout_name = 'index',$theme = null){
        if(REMUSPANEL){
            RemusPanel::log('Выбрано полотно: <span class="badge badge-info">'.$layout_name.'</span>');
        }
        
        $layout_path = RE_Theme::$dir_theme.LAYOUT_FOLDER._DS.$layout_name.'.tpl';
        
        if (file_exists($layout_path)) {
            
            RE_Theme::$layout_file = $layout_path;
            RE_Theme::$layout_name = $layout_name;
            
        } else {
            if(REMUSPANEL){
                RemusPanel::log(lang('error_no_layout').' - '.$layout_path, 'danger');
            } else {
                throw new RemusException(lang('error_no_layout').' - '.$layout_path);
            }
        }
    }
}