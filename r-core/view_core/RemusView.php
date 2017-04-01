<?php

/**
 * Description of RemusView
 *
 * @author Roman
 */
class RemusView implements ViewCoreInterface {
    
    public $view;

    public function setView(View $view) {
        $this->view = $view;
        return $this;
    }
    
    /**
     * BLOCK_REPLACE - Вывод блоков
     * 
     * Example:   
     *          {[BLOCK NAME]}
     * 
     * RegExp:   /\{\[BLOCK ([A-Z0-9_]+)\]\}/
     */
    public function block_replace($buffer = null) {
        
        if($buffer === null){
            $buffer = $this->view->buffer;
            $this->view->buffer = null;
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
            $this->view->buffer = $buffer;
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
    public function fill_replace($buffer = NULL, $data = null) {
        $all = null;
        if($buffer === null){
            $buffer = $this->view->buffer;
            $data   = $this->view->var_app;
            $this->view->var_app = null;
            $this->view->buffer  = null;
            $w = true;
        } else { $w = false; }
        preg_match_all(FILL_TAG_PATTERN, $buffer, $all); // Получаем все доступные в странице ключе
        
        for ($c = 0; $c < count($all[0]); $c++) {
            $matches = '';
            $name = strtolower($all[2][$c]);
            if(isset($data[$name]) and !empty($data[$name])){
                preg_match_all('/('.strtoupper($name).')/', $all[1][$c], $matches);
                if(count($matches[0]) > 0){
                    $value = strtoupper($name);
                }else{
                    $value = FILL_ALTER_TAG_PATTERN;
                }
                $value = str_replace($value, $data[$name], $all[1][$c]);
                $buffer = str_replace($all[0][$c], $value, $buffer);
            }
        }
        if($w){
            $this->view->var_app = $data;
            $this->view->buffer = $buffer;
        } else {
            return $buffer;
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
     * {[FOREACH([TEST]):START]}
     *      {[SECRET]}
     * {[FOREACH:END]}
     * 
     * RegExp:   /\{\[FOREACH\(\[([A-Z0-9_]+)\]\)\:START\]\}([^\:]+)\{\[FOREACH\:END\]\}/
     */
    public function foreach_replace() {
        $all = null;
        preg_match_all(FOREACH_TAG_PATTERN, $this->view->buffer, $all); // Получаем все доступные в странице ключе
        $number = count($all[1]);
        
        for ($c = 0; $c < $number; $c++) {
            $name = strtolower($all[1][$c]);
            if(isset($this->view->var_app[$name]) and is_array($this->view->var_app[$name]) and !empty($this->view->var_app[$name])){
                $text = '';
                        
                foreach ($this->view->var_app[$name] as $key => $value) {
                    
                    if(is_array($value)){ 
                        $text .= $this->foreach_replace_function($value, $all[2][$c]);
                    } else {
                        if(REMUSPANEL){
                            RemusPanel::log('FOREACH_REPLACE: Value is not array', 'danger');
                        }
                    }
                }
                
                $this->view->buffer = str_replace($all[0][$c], $text, $this->view->buffer);
            }
        }
    }
    
    protected function foreach_replace_function($value,$text) {
        for ($i = 0; $i < 3; $i++) {
            $text = $this->block_replace($text);
            $text = $this->fill_replace($text, $value);
            
            foreach ($value as $key => $val) {
                $text = str_replace(pattern($key), $val, $text);
            }
        } 
        
        return $text;
    }
    
    public function render() {
        for($i = 0; $i <= 3; $i++){
            if(in_array('foreach', $this->view->settings['module'])){
                $this->foreach_replace();
            }
            
            if(in_array('block', $this->view->settings['module'])){
                $this->block_replace();
            }
            foreach ($this->view->var_app as $key => $value) {
                if(is_string($value) or is_numeric($value)){
                    $search = VIEW_TAG_START.strtoupper($key).VIEW_TAG_END;
                    $this->view->buffer = str_replace($search,$value, $this->view->buffer);
                }
            }
            if(in_array('fill', $this->view->settings['module'])){
                $this->fill_replace();
            }
            preg_match_all(VIEW_TAG_PATTERN, $this->view->buffer, $all);
            foreach(array_unique($all[1]) as $value){
                if(isset($this->view->var_app[$value])){
                    $search = VIEW_TAG_START.strtoupper($value).VIEW_TAG_END;
                    $this->view->buffer = str_replace($search, $this->view->var_app[$value], $this->view->buffer);
                }
            }                
        }
    }
    
    /**
     * Очистка буферра от неиспользованных ключей
     * 
     * @return void 
     */
    public function clear() {
        foreach ($this->view->settings['module'] as $value) {
            switch ($value) {
                case 'block':
                    preg_match_all(VIEW_TAG_PATTERN, $this->view->buffer, $all);
                break;
            
                case 'fill':
                    preg_match_all(FILL_TAG_PATTERN, $this->view->buffer, $all);
                break;
            
                case 'foreach':
                    preg_match_all(FOREACH_TAG_PATTERN, $this->view->buffer, $all);
                break;
            }
            
            foreach ($all[0] as $all1){$this->view->buffer = str_replace($all1, '', $this->view->buffer);}
        }
    }
}
