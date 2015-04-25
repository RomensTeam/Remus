<?php
if(!defined('DIR')){exit();}

class Index {
    
    public function __construct($name) {
        Remus::Model()->setLayout('index');
        
        $this->StartApp($name);
        
        $array = array(
            'version'	=>  VERSION,
            'copyright'	=>  '2013 - '.pattern('this_year'),
            'heading'   =>  'Hello, World!'
        );
        if(TEST_MODE){
            $array['copyright'] .= ' <span class="label label-info">Запущено в безопасном режиме</span>';
        }
        
        /* I AM READY */
        
        
        var_app($array);
        Remus::Model()->render();
    }
    
    public function StartApp() {
        
        Remus::Model()->app_lang('ru-RU','main');
        
        Remus::Model()->start_html_app(array(
            'title'         => app_lang('index_title'),
            'description'   => app_lang('index_description'),
            'keywords'      => app_lang('index_keywords')
        ));
        
        Remus::Model()->addToHead('<link href="style/bootstrap.min.css" media="screen" rel="stylesheet">');
        Remus::Model()->addToHead('<link href="style/style.css" media="screen" rel="stylesheet">');
    }
}

if(ROUTER == 'DYNAMIC'){
    echo 'Вы выбрали динамический вид роутинга!<br>';
    echo 'Отредактируйте файл: <b>'.__FILE__.'</b> для продолжения разработки.';
}