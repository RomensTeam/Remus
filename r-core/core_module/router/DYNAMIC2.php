<?php
/* Делаем роутинг */
if(defined('ROUTER') && ROUTER == 'DYNAMIC2'){
    
    define('NO_INDEX',  FALSE);
    define('INDEX',     TRUE);
    
    include _filter(DIR_SETTINGS.'routing.php');
        
        foreach (Controller::Controller()->routing as $AppController => $Settings) {
            if(isset($Settings[0])){
                # Получаем название файла контроллера
                $file = array_pop($Settings);
                foreach ($Settings as $num => $value) {
                    $result = preg_match($value, URI, Controller::Controller()->routing_matches);
                    if($result){
                        Controller::Controller()->run_app($AppController,NO_INDEX);break;
                    }
                }
            }
            else{
                # C обозначения индексов
                $regexp = (array) $Settings['regexp'];
                foreach ($regexp as $value) {
                    $result = preg_match($value, URI, Controller::Controller()->routing_matches);
                    if($result){
                        Controller::Controller()->run_app($AppController,INDEX);break;
                    }
                }

            }
        }
}
?>