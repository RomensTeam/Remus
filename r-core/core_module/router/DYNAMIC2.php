<?php
/* Делаем роутинг */
if(defined('ROUTER') && ROUTER == 'DYNAMIC2'){
    
    require  _filter(DIR_SETTINGS.'routing.php');
        
        foreach (Remus()->routing as $AppController => $Settings) {
            $regexp = strtoarray($Settings['regexp']);
            foreach ($regexp as $key => $value) {
                $check = Route::verbalePatternCheck($value);
                if($check){
                    $regexp = Route::verbalePatternCorrect($value);
                } else {
                    $regexp = $value;
                }
                
                $result = preg_match($regexp, URI, $matches);
                
                if($result){
                    if($check)
                        { Route::generateRoutingMatches($value,$matches); }
                    Remus()->run_app($AppController);
                    break;
                }
            }
        }
}
?>