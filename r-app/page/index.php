<?php
if(!defined('DIR')){exit();}

class Index extends VarAppController {
    
    public function __construct($name) {
        Remus::View()->setLayout($name);
        
        $this->StartApp($name,$name);

        if(CACHEMANAGER){
            if(!M()->cache->check($name)){
                $this->copyright = '2013 - '.pattern('this_year');

                if(TEST_MODE){
                    $this->copyright .= ' <span class="label label-info">Запущено в безопасном режиме</span>';
                }

                /* I AM READY */

                $java = M()->getBlock('javascript');
                Remus::View()->addToEnd($java);
            }
        }

        Remus::Model()->render('index');
    }
    
    public function ajax() {
        echo 'современный';
    }
}

if(ROUTER == 'DYNAMIC'){
    echo 'Вы выбрали динамический вид роутинга!<br>';
    echo 'Отредактируйте файл: <b>'.__FILE__.'</b> для продолжения разработки.';
}