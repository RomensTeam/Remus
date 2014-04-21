<?
if(!defined('DIR')){exit();} // Защита

class IndexController {
    
    public function Start(){
        Controller::Model()->app_lang('ru-RU');
        Controller::Model()->setLayout('index2');
        $this->StartApp();
        $this->addStyles();
        $array = array(
            'version'=>VERSION,
            'copyright'=>'2013 - '.Controller::Model()->pattern('this_year')
        );
        if(TEST_MODE){
            $array['copyright'] .= ' <span class="label label-info">Запущщено в безопасном режиме</span>';
        }
        Controller::Model()->var_app($array);
        Controller::Model()->render();
    }
    
    public function StartApp() {
        $site_meta['title']         = Controller::Model()->app_lang['index_title'];
        $site_meta['description']   = Controller::Model()->app_lang['index_description'];
        $site_meta['keywords']      = Controller::Model()->app_lang['index_keywords'];
        Controller::Model()->start_html_app($site_meta);
    }
    
    public function addStyles() {
        Controller::Model()->addToHead('<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">');
        Controller::Model()->addToHead('<link href="style/style.css" media="screen" rel="stylesheet">');
    }
}