<?php

/**
 * View - render engine for Remus
 * 
 * @version 2.0
 * @author RomanTrutnev <romantrutnev@gmail.com>
 */

class View {
    
    private $settings   = array(
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
    protected $buffer   = null;
    
    /**
     * @var array Данные
     */
    protected $var_app  = null;
    
    /**
     * Генерирование данных в шапке и конце
     */
    public function generateHead(){
        foreach($this->meta as $key => $value) {
            if ($key == 'keywords' || $key == 'description' || $key == 'author' || $key == 'robots' || $key == 'url') {
                if(is_string($value))$this->head_string .= '<meta name="'.$key.'" content="'.$value.'">';
            }
            if ($key == 'favicon'){
                if(is_string($value))$this->head_string .= '<link rel="icon" type="image/'.substr($value, -3).'" href="'.$value.'" />';
            }
            if ($key == 'content-language' || $key == 'Content-Type' || $key == 'Expires' || $key == 'refresh'){
                if(is_string($value))$this->head_string .= '<meta http-equiv="'.$key.'" content="'.$value.'" />';
            }
            if ($key == 'title'){
                if(is_string($value))$this->head_string .= '<title>'.$value.'</title>';
            }
        }
        if(CheckFlag('SUPPORT_DEVELOPERS') ){
            $this->head_string.='<meta name="generator" content="Remus">';
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
        $this->meta = array_merge($this->meta, $meta);
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
            '<html>'.
            '<head>'.
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
            if(is_file(RE_Theme::$layout_file)){
                return file_get_contents(RE_Theme::$layout_file);
            } else{
                throw new RemusException(lang('error_no_layout').' - '.RE_Theme::$layout_file);
            }
        }
        return NULL;
    }
    public function block_replace($buffer = null) {
        
        if($buffer === null){
            $buffer = $this->buffer;
            $this->buffer = null;
            $w = true;
        } else { $w = false; }
        
        for($io = 0; $io < 3; $io++){
            
            $all = null;
            
            preg_match_all(VIEW_BLOCK_TAG_PATTERN, $buffer, $all);
            
            if(count($all[1]) > 0){
                foreach($all[1] as $value) {
                    $block_path = RE_Theme::$dir_theme. strtolower(VIEW_BLOCK_TAG_FOLDER . _DS .$value) . '.tpl';
                    if(file_exists($block_path)){
                        $block = file_get_contents($block_path);
                        $buffer = str_replace(VIEW_TAG_START . strtoupper(VIEW_BLOCK_TAG_NAME . $value ). VIEW_TAG_END , $block, $buffer);
                    }
                }
            }else{break;}
        }
        
        if($w){
            $this->buffer = $buffer;
        } else {
            return $buffer;
        }
    }
    
    /**
     * FILL_REPLACE - Вывод с форматированием
     * 
     * Example:   
     *          {[<p>NAME_FILL</p>]|[NAME_FILL]}
     *          {[<p>???</p>]|[NAME_FILL]}
     * 
     * RegExp:   /\{\[(.*)\](?:)?\|\[([A-Z0-9_]+)\]\}/
     */
    public function fill_replace() {
    
        preg_match_all(FILL_TAG_PATTERN, $this->buffer, $all); // Получаем все доступные в странице ключе
        
        for ($c = 0; $c < count($all[0]); $c++) {
            $matches = '';
            $name = strtolower($all[2][$c]);
            if(isset($this->var_app[$name]) and !empty($this->var_app[$name])){
                preg_match_all('/('.strtoupper($name).')/', $all[1][$c], $matches);
                if(count($matches[0]) > 0){
                    $value = strtoupper($name);
                }else{
                    $value = FILL_ALTER_TAG_PATTERN;
                }
                $value = str_replace($value, $this->var_app[$name], $all[1][$c]);
                $this->buffer = str_replace($all[0][$c], $value, $this->buffer);
            }
        }
    }
    
    /**
     * FOREACH_REPLACE - вывод списка с форматированием
     * 
     * Example:
     * 
     * $array['test'] = array(
     *  array('SECRET' => 'WHAT'),
     *  array('SECRET' => 'THE'),
     *  array('SECRET' => 'Remus?'),
     * );
     *    
     * {[FOREACH([TEST]):START}
     *      {[SECRET]}
     * {FOREACH:END]}
     * 
     * RegExp:   /\{\[FOREACH\(([A-Z_]+)\)\:START\]\}([^\:]+)\{\[FOREACH\:END\]\}/
     */
    public function foreach_replace() {
    
        $all = null;
        preg_match_all(FOREACH_TAG_PATTERN, $this->buffer, $all); // Получаем все доступные в странице ключе
        $number = count($all[1]);
        
        for ($c = 0; $c < $number; $c++) {
            $name = strtolower($all[1][$c]);
            if(isset($this->var_app[$name]) and is_array($this->var_app[$name]) and !empty($this->var_app[$name])){
                $text = '';
                
                foreach ($this->var_app[$name] as $value) {
                    $text .= $this->foreach_replace_function($value, $all[2][$c]);
                }
                
                $this->buffer = str_replace($all[0][$c], $text, $this->buffer);
            }
        }
    }
    
    protected function foreach_replace_function($value,$text) {
        $return = $text;
        
        for ($i = 0; $i < 3; $i++) {
            $return = $this->block_replace($return);
            
            foreach ($value as $key => $val) {
                $return = str_replace(pattern($key), $val, $return);
            }
        } 
        
        return $return;
    }
    
    /**
     * Рендеринг страницы
     */
    public function render(){
        $this->generateHead();
        $this->getBuffer();
        
        if($this->buffer == null){
            return NULL;
        }
        
        for($i = 0; $i <= 3; $i++){
            
            
            $this->foreach_replace();
            
            if(in_array('block', $this->settings['module'])){
                $this->block_replace();
            }
            foreach ($this->var_app as $key => $value) {
                if(is_string($value) or is_numeric($value)){
                    $search = VIEW_TAG_START.strtoupper($key).VIEW_TAG_END;
                    $this->buffer = str_replace($search,$value, $this->buffer);
                }
            }
            if(in_array('fill', $this->settings['module'])){
                $this->fill_replace();
            }
            
            
            preg_match_all(VIEW_TAG_PATTERN, $this->buffer, $all);
            foreach(array_unique($all[1]) as $value){
                if(isset($this->var_app[$value])){
                        $this->buffer = str_replace(VIEW_TAG_START.strtoupper($value).VIEW_TAG_END, $array[$value], $this->buffer);
                }
            }                
        }
        
        # Убираем мусор за собой
        if(!TEST_MODE){
            $this->delAllKey();
        }
        
        return $this->buffer;
    }
    
    /**
     * Выбор темы для приложения
     * 
     * @param string $theme_name Название темы
     * @return boolean Статус
     */
    public function setTheme($theme_name){
        
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
    public function setLayout($layout_name){
        
        $layout_path = RE_Theme::$dir_theme.LAYOUT_FOLDER._DS.$layout_name.'.tpl';
        
        if (is_file($layout_path)) {
            
            RE_Theme::$layout_file = $layout_path;
            RE_Theme::$layout_name = $layout_name;
            
        } else {
            throw new RemusException(lang('error_no_layout').' - '.$layout_path);
        }
    }
    
    /**
     * Очистка буферра от неиспользованных ключей
     * 
     * @return void 
     */
    public function delAllKey() {
        foreach ($this->settings['module'] as $value) {
            switch ($value) {
                case 'block':
                    preg_match_all(VIEW_TAG_PATTERN, $this->buffer, $all);
                break;
            
                case 'fill':
                    preg_match_all(FILL_TAG_PATTERN, $this->buffer, $all);
                break;
            
                case 'foreach':
                    preg_match_all(FOREACH_TAG_PATTERN, $this->buffer, $all);
                break;
            }
            
            foreach ($all[0] as $all1){$this->buffer = str_replace($all1, '', $this->buffer);}
        }
    }
        
}