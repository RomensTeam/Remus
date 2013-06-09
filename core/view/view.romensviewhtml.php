<?
if(!defined('DIR')){exit();} // Защита
/**
 * Description of RomensView
 *
 * @author Romens
 */
class RomensViewHTML {
    public $theme;
    public $model;
    public $layout;
    public $not_var;
    public $var;
    public $cashe;
    public $css_link = array();
    public $css;
    public $js;
    public $js_link = array();
    public $head = array();
    public $head_string;
    public $dir_theme;
    
    public function __construct($model) {
        $this->model = $model;
    }
    public function var_replace($array = array()){
            $buffer = ob_get_contents();
            ob_get_clean();
            preg_match_all(VIEW_TAG_PATTERN,$buffer, $all); // Получаем все доступные в странице ключей
            foreach ($all[1] as $value) {
                $buffer = str_replace('{['.$value.']}',$array[strtolower($value)] , $buffer);
            }
            echo $buffer;
    }
    public function generateHead(){
        foreach ($this->head as $key => $value) {
            if($key == 'keywords' || $key == 'description'||$key == 'author'||$key == 'robots'||$key == 'url' ){
                $this->head_string  .= '<meta name="'.$key.'" content="'.$value.'">'; 
            }
            if($key == 'favicon'){$this->head_string .='<link rel="icon" type="image/'.substr($value,-3).'" href="'.$value.'" />';}
            if($key == 'content-language'||$key == 'Content-Type'||$key == 'Expires'||$key == 'refresh'){
                $this->head_string .= '<meta http-equiv="'.$key.'" content="'.$value.'" />';
            }
            if($key == 'title'){$this->head_string .='<title>'.$value.'</title>';}
        }
        $this->head_string .= '<meta name="generator" content="Romens Engine PHP">';
        foreach ($this->css_link as $value){
            $this->head_string .= '<link href="'.$value.'" rel="stylesheet" type="text/css">';
        }
        foreach ($this->js_link as $value){
            $this->head_string .= '<script type="text/javascript" src="'.$value.'"></script>';
        }
        if(!empty($this->js)){
            foreach ($this->js as $value){$this->head_string .= '<script type="text/javascript">'.$value.'</script>';}
        }
        if(!empty($this->css)){foreach ($this->css as $value){$this->head_string .= '<style type="text/css">'.$value.'</style>';}}
        
        return $this->head_string;
        
    }
    public function loadLayout(){
        echo file_get_contents($this->model->layout);
    }

    public function render(){
        echo '<!doctype html><html><head>{[HEAD]}</head><body>';
        $this->loadLayout();
        echo '</body></html>';
    }
}

?>