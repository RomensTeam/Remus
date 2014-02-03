<?
/* Делаем роутинг */
if(defined('ROUTER') && ROUTER == 'DYNAMIC2'){
    
    define('NO_INDEX',  FALSE);
    define('INDEX',     TRUE);
    
    // Подключаем AppController и правила роутинга
    require_once DIR_LIB.'appcontroller.php';
    include _filter(DIR_SETTINGS.'routing.php');
    
    foreach ($routing_rules as $AppController => $Settings) {
        if(isset($Settings[0])){
            # Получаем название файла контроллера
            $file = array_pop($Settings);
            foreach ($Settings as $num => $value) {
                if(preg_match($value, URI,$controller->routing_matches)){
                    $controller->run_app($AppController,NO_INDEX);
					break;
                }
            }
        }
        else{ 
            # C обозначения индексов
            $regexp = (array) $Settings['regexp'];
            
            foreach ($regexp as $value) {
                if(preg_match($value, URI, $controller->routing_matches)){
                    $controller->run_app($AppController,INDEX);
                }
            }
            
        }
    }
}
?>