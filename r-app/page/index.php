<?
if(!defined('DIR')){exit();} // Защита

class Index {
    
    public function __construct($name) {
        $this->Start();
    }
    
    public function Start(){
        M()->setLayout('index');
        $this->StartApp();
        $this->addStyles();
        
        $array = array(
            'version'	=>  VERSION,
            'copyright'	=>  '2013 - '.pattern('this_year')
        );
        if(TEST_MODE){
            $array['copyright'] .= ' <span class="label label-info">Запущено в безопасном режиме</span>';
            
            $array['test'] = array(
                array('SECRET' => 'WHAT'),
                array('SECRET' => 'THE'),
                array('SECRET' => 'Remus?')
            );
        }
        
        M()->var_app($array);
        M()->render();
    }
    
    public function StartApp() {
        
        M()->app_lang('ru-RU');
        
        M()->start_html_app(array(
            'title'         => app_lang('index_title'),
            'description'   => app_lang('index_description'),
            'keywords'      => app_lang('index_keywords')
        ));
        
    }
    
    public function addStyles() {
        M()->addToHead('<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">');
        M()->addToHead('<link href="style/style.css" media="screen" rel="stylesheet">');
    }
}