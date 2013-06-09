<?
/**
 * Класс для доступа к базе данных через MySQL
 *
 *
 * @author Romens
 */
class RomensMYSQL {
    protected   $link;                      // Подключение
    protected   $base           = FALSE;    // База данных
    protected   $base_last      = FALSE;
    public      $error          = FALSE;    // Описание ошибки
    public      $errno          = FALSE;    // Номер ошибки
    public      $insert_id      = FALSE;    // ID последней "вставки"
    public      $affected_rows  = FALSE;    // Затронутые строки
    public      $result;                    // 

    function __construct($base = NULL){
        /* Проверяем соединение и заполняем данные */
        $link = mysql_connect(BASE_HOST,BASE_LOGIN,BASE_PASS);
        if($base == NULL){
            $db = TRUE;
        }
        else{
            $db = mysql_select_db($base,$link);
            $this->base  =  $base;
        }
        if($link == FALSE || $db == FALSE){
            $this->error = mysql_error($link);
            $this->errno = mysql_errno($link);
            return FALSE;
        }
        $this->link = $link;
        return TRUE;
    }
    private function filter($str){
        return htmlspecialchars(trim($str));
    }
    public function query($query,$output='assoc',$val = FALSE){
        if($val!=FALSE){
            if(is_array($val)){
                $n = '$query = sprintf($query';
                foreach ($val as $value) {
                    $n .= ",".$this->type($value);
                }
                $n .= ');';
                eval($n);
            }
            if(is_string($val) || is_numeric($val)){
                $query = sprintf($query,$val);
            }
        }
        $result = mysql_query($this->filter($query), $this->link);
        $this->refresh_var();
        if($result == FALSE || mysql_num_rows($result) == 0){
            return FALSE;
        }
        $this->result = $result;
        switch (strtolower($output)) {
            case 'assoc' :  return mysql_fetch_assoc($result);  break;
            case 'object':  return mysql_fetch_object($result); break;
            case 'array' :  return mysql_fetch_array($result);  break;
            default:        return $result;                     break;
        }
    }
    private function refresh_var(){
        $this->errno                =    mysql_errno($this->link);
        $this->error                =    mysql_error($this->link);
        $this->affected_rows        =    mysql_affected_rows($this->link);
        $this->insert_id            =    mysql_insert_id($this->link);
    }
    public function type($var,$quotes=FALSE,$special_quotes=TRUE){
        if(is_string($var)){
            return "'".$var."'";
        }
        if(is_array($var)){
            $n = '';
            foreach ($var as $value) {
                if($quotes){
                    if($special_quotes){
                        $n .= ",'".$value."'";
                    }
                    else{
                        $n .= ',`'.$value.'`';
                    }
                }
                else{
                    $n = implode(',', $var);
                    break;
                }
                
            }
        }
        return $var;
    }
    public function change_base($base){
        $this->base_last = $this->base;
        $this->base = $base;
        return mysql_select_db($this->base, $this->link);
    }
}
define('ARRAY','ARRAY');
define('ASSOC','ASSOC');
define('OBJECT','OBJECT');
?>