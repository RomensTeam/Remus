<?
/**
 *  Класс Romens - Базовый класс
 * 
 * @author Romens <romantrutnev@gmail.com>
 * @version 1.0
 */
class Romens {
    private $registry;
    
    public function __construct(){
        $this->registry = new Regisrtry;
    }
    
    /* Подключаем базу данных */
    public function base($number = FALSE){
        if(defined('BASE_NUMBER')){
            if(BASE_NUMBER == 1){
                $base = $cfg['base']['base'];
                if(is_array($cfg['base']['base'])){
                    $base = array_shift($cfg['base']['base']);
                }
            }
            if(BASE_NUMBER > 1){
                $base = BASE_NUMBER-1;
                $base = $cfg['base']['base'][$base];
            }
            include _filter('core/lib/class.'.strtolower(BASE).'.php');
            
            $host = $cfg['base']['host'];
            $login = $cfg['base']['login'];
            $pass = $cfg['base']['pass'];
            $prefix = $cfg['base']['prefix'];
            
            switch (strtolower(BASE)){
                case 'mysql':
                    $link = new MySQL($host, $login, $pass, $base, $prefix) or die($_LANG['not_conected_base']);
                    break;
                case 'mysqli':
                    $link = new MySQLi($host, $login, $pass, $base, $prefix) or die($_LANG['not_conected_base']);
                break;
                case 'pdo':
                    $link = new pdo($host, $login, $pass, $base, $prefix) or die($_LANG['not_conected_base']);
                break;
            }
            $this->registry['base'] = $link;
            return TRUE;
        }
        else{exit($_LANG['user_work_in_core']);}
    }

    /* Пасхалки */
    public function __invoke($var){
        if(is_int($var)){return 'Через '.$var.' минут я взорву твой компьютер! :-)';}
        if(is_string($var)){return ':-)';}
    }
    
    public function __toString(){
        return 'Привет, я Romens-Engine!';
    }
     
    public function __destruct(){
        
    }
}

?>