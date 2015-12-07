<?php
if(!defined('DIR')){exit();}

class Index extends VarAppController {
    
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
        
        $this->links = array(
            array( 
                'link' => 'http://romens.ru/', 
                'title' => 'Author Framework' 
            ),
            array( 
                'link' => 'https://github.com/RomensTeam/Remus', 
                'title' => 'GitHub Repository' 
            ),
        );
		
        if(REMUSPANEL){
            RemusPanel::log('Простое сообщение');
            RemusPanel::log('Ошибка','error');
            RemusPanel::log('Предупреждение','warning');
            RemusPanel::log('Удачно','success');
        }
		
        var_app($array);
        
        $ajax = M()->getBlock('ajax');
        M()->addToEnd($ajax);
        
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
        Remus::Model()->addScript('style/jquery.min.js', true);
        Remus::Model()->addToHead('<link href="style/style.css" media="screen" rel="stylesheet">');
    }
    
    public function ajax() {
        echo '<h3>Yes! This is AJAX!</h3>';
    }
}

if(ROUTER == 'DYNAMIC'){
    echo 'Вы выбрали динамический вид роутинга!<br>';
    echo 'Отредактируйте файл: <b>'.__FILE__.'</b> для продолжения разработки.';
}