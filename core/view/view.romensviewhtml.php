<?
if (!defined('DIR')) {
    exit();
}
/**
 * Description of RomensView
 *
 * @author Romens
 * @version 1.1
 * @todo Доделать компоненты
 */
class RomensViewHTML {
    public $model; # Model
    public $css_link = array(); # Ссылки к CSS файлам
    public $css = array(); # CSS код
    public $js = array(); # Добавляющийся в шапку JavaScript код
    public $js_end = array(); # Добавляющийся в конец JavaScript код
    public $js_link = array();
    public $js_link_end = array(); # Добавляющийся в конец JavaScript код, как ссылка
    public $head = array(); #
    public $head_string;
    public $end_string;
    public function __construct($model) {
        $this->model = $model;
    }
    public function var_replace($array = array()) {
        preg_match_all(VIEW_TAG_PATTERN, $this->model->buffer, $all); // Получаем все доступные в странице ключей
        foreach($all[1] as $value) {
            $this->model->buffer = str_replace(VIEW_TAG_START . $value . VIEW_TAG_END, $array[strtolower($value)], $buffer);
        }
    }
    public function generateHead() {
        foreach($this->head as $key => $value) {
            if ($key == 'keywords' || $key == 'description' || $key == 'author' || $key == 'robots' || $key == 'url') {
                $this->head_string.= '<meta name="' . $key . '" content="' . $value . '">';
            }
            if ($key == 'favicon') {
                $this->head_string.= '<link rel="icon" type="image/' . substr($value, -3) . '" href="' . $value . '" />';
            }
            if ($key == 'content-language' || $key == 'Content-Type' || $key == 'Expires' || $key == 'refresh') {
                $this->head_string.= '<meta http-equiv="' . $key . '" content="' . $value . '" />';
            }
            if ($key == 'title') {
                $this->head_string.= '<title>' . $value . '</title>';
            }
        }
        if(defined('SUPPORT_DEVELOPERS') && SUPPORT_DEVELOPERS == TRUE ){
        $this->head_string.= '<meta name="generator" content="Romens Engine PHP">';}
        foreach($this->css_link as $value) {
            $this->head_string.= '<link href="' . $value . '" rel="stylesheet" type="text/css">';
        }
        foreach($this->js_link as $value) {
            $this->head_string.= '<script type="text/javascript" src="' . $value . '"></script>';
        }
        if (!empty($this->js)) {
            foreach($this->js as $value) {
                $this->head_string.= '<script type="text/javascript">' . $value . '</script>';
            }
        }
        if (!empty($this->css)) {
            foreach($this->css as $value) {
                $this->head_string.= '<style type="text/css">' . $value . '</style>';
            }
        }
        foreach($this->js_link_end as $value) {
            $this->end_string.= '<script type="text/javascript" src="' . $value . '"></script>';
        }
        foreach($this->js_end as $value) {
                $this->end_string.= '<script type="text/javascript">' . $value . '</script>';
        }
        return TRUE;
    }
    public function render() {
        $melinda = '<!doctype html><html><head>{[HEAD]}</head><body>' . file_get_contents($this->model->registr['layout']) . '</body>{[END_AREA]}</html>';
        return $melinda;
    }
}