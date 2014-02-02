<?
if(!defined('DIR')){exit();} // Защита

class IndexController extends AppController {
    
    public function Start(){
        $this->model->app_lang('ru-RU');
        $this->model->setLayout('index2');
        $this->StartApp();
        $this->addStyles();
        $array = array(
            'version'=>VERSION,
            'copyright'=>'2013 - '.$this->model->pattern('this_year')
        );
        if(TEST_MODE){
            $array['copyright'] .= ' <span class="label label-info">Запущщено в безопасном режиме</span>';
        }
        $this->model->var_app($array);
        $this->model->render();
    }
    
    public function StartApp() {
        $site_meta['title']         = $this->model->app_lang['index_title'];
        $site_meta['description']   = $this->model->app_lang['index_description'];
        $site_meta['keywords']      = $this->model->app_lang['index_keywords'];
        $this->model->start_html_app($site_meta);
    }
    
    public function addStyles() {
        $this->model->addToHead('<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">');
        $this->model->addToHead('<link href="style/style.css" media="screen" rel="stylesheet">');
    }
}