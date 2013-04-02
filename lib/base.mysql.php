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
    private $access_table;
    
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
     * @param string|array  $colflt Description
     * @param string|array  $sings  Символы
     * @param array|string  $value  Значения
     * SELECT * FROM  `romens_user_profile` WHERE  `id` = 1 AND  `login` LIKE  'Romens'
     *        
     */
    function select($column, $table, $colflt, $signs, $value){
        $sql = 'SELECT ';
        if(empty($value) && empty($signs) && empty($colflt)){
            if(is_array($column)){
                $column = $this->filter(implode(',', $column));
            }
            $sql .= $column.' ';
            
        }
        if(is_array($column) && is_array($colflt) && is_array($signs) && is_array($value)){
            if(count($column)=count($colflt)=count($signs)=count($value)){
                
            }
            return FALSE;
        }
        
        if(is_string($column) && is_string($signs) && is_string($colflt) && is_string($value)){
            
        }
        return FALSE;
    }
    
    /**
     *  Разрушение класса
     */
    function __destruct(){
        
    }
    
    /**
     *  Фильтр ввода
     */
    function filter($str){
        return htmlspecialchars(strip_tags(trim($str)));
    }
    
    
}

?>
