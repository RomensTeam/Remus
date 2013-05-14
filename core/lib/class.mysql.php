<?
/**
 * Класс для доступа к базе данных через MySQL
 *
 * Реализован метод SELECT
 *
 * @author Romens
 */

class MySQL {
    protected   $link;                      // Подключение
    protected   $host;                      // Адрес хоста
    protected   $port;                      // Порт хоста
    protected   $login;                     // Логин пользователя
    protected   $pass;                      // Пароль пользователя
    protected   $base;                      // База данных
    public      $error          = FALSE;    // Описание ошибки
    public      $errno          = FALSE;    // Номер ошибки
    public      $insert_id      = FALSE;    // ID последней "вставки"
    public      $affected_rows  = FALSE;    // Затронутые строки
    
    /**
     * Инициализация класса
     * 
     * @param string $host Хост баз данных
     * @param string $login Логин пользователя базы данных
     * @param string $pass Пароль пользователя базы данных
     * @param string $base База данных
     * @param string $prefix Префикс таблиц
     */
    function __construct( $host = 'localhost', $login = 'root', $pass = '', $base = 'base_number_1', $prefix = ''){
        /* Проверяем соединение и заполняем данные */
        $link = mysql_connect($host,$login,$pass);
	$db = mysql_select_db($base,$link);
        if($link == FALSE && $db == FALSE){
            $this->error = mysql_error($link);
            $this->errno = mysql_errno($link);
            return FALSE;
        }
        $this->link  =  $link;
        $this->host  =  $host;
        $this->login =  $login;
        $this->pass  =  $pass;
        $this->base  =  $base;
        return TRUE;
    }
    
    
    /**
     *  Фильтр ввода
     */
    private function filter($str){
        return htmlspecialchars(trim($str));
    }
    
    /**
     *  Отправка запроса
     */
    private function query($query, $output='array_assoc'){
        $result = mysql_query($query, $this->link);
        $this->refresh_var();
        if($result == FALSE || mysql_num_rows($result) == 0){
            return FALSE;
        }
        switch($output){
            case 'array_assoc': return mysql_fetch_assoc($result);  break;
            case 'array':       return mysql_fetch_array($result);  break;
            case 'object':      return mysql_fetch_object($result); break;
            default:            return FALSE;                       break;
        }
    }
    
    /**
     *  Обновляем перемнные
     */
    private function refresh_var(){
        $this->errno                =    mysql_errno($this->link);
        $this->error                =    mysql_error($this->link);
        $this->affected_rows        =    mysql_affected_rows($this->link);
        $this->affected_rows        = mysql_insert_id($this->link);
    }  
    /**
     *  Разрушение класса
     */
    function __destruct(){
        mysql_close($this->link); // Закрываем соединение
    }
}
?>