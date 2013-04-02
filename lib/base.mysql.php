<?php
/**
 * Класс для доступа к базе данных через MySQL
 *
 * @author Romens
 * @todo SELECT - выборку из базы данных; 
 * @todo INSERT - вставку в базу данных; 
 * @todo DELETE - удаление из базы данных;
 * @todo CHECK  - проверка занчений из базы данных;
 */

class MySQL {
    private $link;
    private $host;
    private $login;
    private $pass;
    private $base;
    public  $error = FALSE;
    public  $errno = FALSE;
    public  $insert_id;
    public  $affected_rows;
    
    /**
     *  Инициализация класса
     * 
     * @param string $host Хост баз данных
     * @param string $login Логин пользователя базы данных
     * @param string $pass Пароль пользователя базы данных
     * @param string $base База данных
     * @param string $prefix Префикс таблиц
     */
    function __construct(  $host = 'localhost', $login = 'root', $pass = '', $base = 'base_number_1', $prefix = ''){
        $link = mysql_connect($host,$login,$pass); // Создаём подключение
        if($link == FALSE){ // Если подключение не работает то...
            $this->error = mysql_error($link); // ... запоминаем ошибку
            $this->errno = mysql_errno($link); // ... запоминаем ошибку
            return FALSE;
        }
        /* Сохраняем в классе все полученные данные */
        $this->link  =  $link;
        $this->host  =  $host;
        $this->login =  $login;
        $this->pass  =  $pass;
        $this->base  =  $base;
        return $this;
    }
    
    /**
     *  SELECT - выборка из базы данных
     * 
     * @param array|string  $column Какие столбцы нужны
     * @param string        $table  Имя таблицы
     * @param string|array  $colflt Название столбцов для фильтра
     * @param string|array  $signs  Символы для фильтра
     * @param array|string  $value  Значения для фильтра
     * @param mixed         $output Тип вывода
     * 
     * SELECT * FROM  `table` WHERE  `id` = 1 AND  `login` LIKE  'Romens'
     *        
     */
    function select($column, $table, $colflt, $signs, $value, $output){
        $sql = 'SELECT ';
        $sql.= $this->_type($column);
        
        if(is_array($colflt) && is_array($signs) && is_array($value)){
            if(count($colflt)=count($signs)=count($value)){
                $result = '';
                for ($x=0; $x<255; $x++) {
                    if($x>0){
                        $result .= 'AND';
                    }
                    $result .= '`'.$colflt[$x].'`'.$signs[$x].''.$this->_type($value[$x]);
                }
            }
           return FALSE;
        }
        
        if(is_string($signs) && is_string($colflt) && is_string($value)){
            $result .= '`'.$colflt.'`'.$signs.''.$this->_type($value);
        }
        
        if((empty($value) && empty($signs) && empty($colflt)) || ($value==FALSE&&$signs==FALSE&&$colflt==FALSE) ){
            $result = null;
        }
        
        $sql .= $result;
        return $this->query($sql,$output);
    }
    
    /**
     *  Разрушение класса
     */
    function __destruct(){
        
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
        if($result == FALSE && mysql_num_rows($result) == 0){
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
    }
    
    /**
     *  Определяем тип переменой для запроса
     */
    private function _type($var){
        if(is_string($var) || is_bool($var))     return "'".$var."'";
        if(is_numeric($var))                     return $var;
        if(is_array($var))                       return implode(',', $var);
        return NULL;
    } 
}

?>
