<?
/**
 * Класс для доступа к базе данных через MySQL
 *
 * Реализован метод SELECT
 *
 * @author Romens
 * @todo INSERT   - вставку в базу данных; 
 * @todo DELETE   - удаление из базы данных;
 * @todo VALID    - проверка занчений из базы данных;
 * @todo NUM_ROWS - подсчёт строк
 * @todo ColToCol - подмена значения
 * @todo GetID    - вернуть ID
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
    public      $query_info     = FALSE;    // Информация о запросе
    public      $host_info      = FALSE;    // Информация о хосте
    
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
     *  SELECT - выборка из базы данных
     * 
     * @param array|string  $column Какие столбцы нужны
     * @param string        $table  Имя таблицы
     * @param mixed         $output Тип вывода
     * @param string|array  $colflt Название столбцов для фильтра
     * @param string|array  $signs  Символы для фильтра
     * @param array|string  $value  Значения для фильтра
     *        
     */
    function select( $column, $table, $output='array_assoc', $colflt=false, $signs=false, $value=false){
	if( $column != '*') {
		if(is_string($column)){$column = explode(',',$column);}
		if(is_array($column)){$column = $this->_type($column,TRUE,FALSE);}
	}
	$sql = 'SELECT '.$column.' FROM '.$this->_type($table);
	$result = ' WHERE ';
        if(is_array( $colflt) && is_array( $signs) && is_array( $value) && ((count($signs)==count($value))==(count($colflt)==count($value)))){
		for ($x=0; $x<count($colflt); $x++) {
                    if($x>0){$result .= ' AND';}
                    $result .= ' `'.$colflt[$x].'` '.$signs[$x].' '.$this->_type($value[$x],TRUE,TRUE);
		}
        }
        
        if(is_string($signs) && is_string($colflt) && is_string($value)){
            $result .= ' `'.$colflt.'` '.$signs.' '.$this->_type($value,TRUE,TRUE);
        }
        
        if((empty($value) && empty($signs) && empty($colflt)) || ($value==FALSE&&$signs==FALSE&&$colflt==FALSE) ){$result = '';}
        
        $sql .= $result;
        return $this->query($sql,$output);
    }
    
    /**
     *  INSERT - вставка в базу данных
     * 
     * @param array|string  $column Какие столбцы нужны
     * @param string        $table  Имя таблицы
     * @param string|array  $colflt Название столбцов для фильтра
     * @param string|array  $signs  Символы для фильтра
     * @param array|string  $value  Значения для фильтра
     * @param mixed         $output Тип вывода
     * 
     * INSERT INTO `table` (`id`, `datareg`, `brithbay`, `activation`, `real`) 
     * VALUES (6, 'RomanTrutnev', 'ghh', 'fghgfh', 'FALSE', '1');

     *        
     */
    function insert($table, $column, $values, $output){
        $sql  = 'INSERT INTO ';
        $sql .= '`'.$table.'` (';
        if(is_array($column) && is_array($values) && (count($values)==count($column))){ 
            $column_s = $this->_type($column,TRUE,TRUE);
            $values_s = $this->_type($values,TRUE,FALSE);
        }
        if(is_string($column)&&  is_string($values)){
            $column_s = '`'.$column.'`';
            $values_s = '`'.$values.'`';
        }
        $sql .= $column_s.') VALUES ('.$values_s.')';
        echo $sql;
    }
    
    /**
     *  UPDATE - обновление записи в базе данных
     * 
     * @param array|string  $column Какие столбцы нужны
     * @param string        $table  Имя таблицы
     * @param string|array  $colflt Название столбцов для фильтра
     * @param string|array  $signs  Символы для фильтра
     * @param array|string  $value  Значения для фильтра
     * @param mixed         $output Тип вывода
     * 
     * UPDATE `phpmyadmin`.`pma__column_info` SET `id` = '358', `db_name` = 'addressbook324', `table_name` = 'tb_address_book32', `column_name` = 'Surname34', `comment` = '4', `mimetype` = '23', `transformation` = '_21', `transformation_options` = '3' WHERE `pma__column_info`.`id` = 3;

     *        
     */
    function update($table, $column, $values, $output){
        $sql  = 'INSERT INTO ';
        $sql .= '`'.$table.'` (';
        if(is_array($column) && is_array($values) && (count($values)==count($column))){}
        if(is_string($column)&&  is_string($values)){
            $column_s = '`'.$column.'`';
            $values_s = '`'.$values.'`';
        }
        
        $sql .= ') VALUES (';
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
    }
    
    /**
     *  Определяем тип переменой для запроса
     */
    private function _type($var, $quote = TRUE,$special_quotes=FALSE){
		if(is_numeric($var)){return $var;}
		if(is_string($var)){
			if($special_quotes){return "'".trim($var)."'";}
			return "`".trim($var)."`";
		}
        if(is_array($var)){
			if($quote){
				$array = array();
				if(!$special_quotes){
					foreach( $var as $key => $val){$array[$key] = ' `'.trim($val).'` ';}
				}
				else{
					foreach( $var as $key => $val){$array[$key] = " '".trim($val)."' ";}
				}
				return implode(',' ,$array);
			}
			else{
				return implode(',', $var);
			}
		}
        return NULL;
    } 
    /**
     *  Разрушение класса
     */
    function __destruct(){
        mysql_close($this->link); // Закрываем соединение
    }
}
/* Константы Вывода */
    const       OUT_ARRAY       = 'array';
    const       OUT_ASSOC       = 'array_assoc';
    const       OUT_OBJECT      = 'object';
?>