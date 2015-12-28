<?php
if(!defined('DIR')){exit();}

class Index extends VarAppController {
    
    public function __construct($name) {
        Remus::View()->setLayout('index');
        
        $this->StartApp($name);
        
        $this->copyright = '2013 - '.pattern('this_year');
        
        if(TEST_MODE){
            $this->copyright .= ' <span class="label label-info">Запущено в безопасном режиме</span>';
        }
        
        /* I AM READY */
        
        $java = M()->getBlock('javascript');
        Remus::View()->addToEnd($java);
        Remus::Model()->render();
    }
    
    public function StartApp() {
        
        Remus::Model()->app_lang('ru-RU','main');
        
        Remus()->startApp(array(
            'title'         => app_lang('index_title'),
            'description'   => app_lang('index_description'),
            'keywords'      => app_lang('index_keywords')
        ));
        
        Remus::View()->addScript('style/jquery.min.js', true);
        Remus::View()->addToHead('<link rel="stylesheet" href="{[URL]}style/assets/css/normalize.css" media="screen">');
        Remus::View()->addToHead('<link rel="stylesheet" href="{[URL]}style/assets/css/grid.css" media="screen">');
        Remus::View()->addToHead('<link rel="stylesheet" href="{[URL]}style/assets/css/style.css" media="screen">');
        Remus::View()->addToHead('<link rel="stylesheet" href="{[URL]}style/assets/font-awesome/css/font-awesome.min.css">');
    }
    
    public function ajax() {
        echo 'современный';
    }
}

if(ROUTER == 'DYNAMIC'){
    echo 'Вы выбрали динамический вид роутинга!<br>';
    echo 'Отредактируйте файл: <b>'.__FILE__.'</b> для продолжения разработки.';
}