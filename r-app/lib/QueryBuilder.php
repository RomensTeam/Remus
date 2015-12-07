<?php

/**
 * QueryBuilder - Постройка запроса
 * 
 * @author Romens
 */
class QueryBuilder {
    
    /**
     * @var PDO
     */
    public $PDO;
    
    /**
     * @var string
     */
    public $SQL;
    
    private $registr = array(
        'column' => array(),
        'set' => array(),
        'param'  => array()
    );
    
    private $table;
    private $column;
    private $where;
    private $limit;
    private $order;
    private $count;
    private $bind;
    public $result;
    private $operation   = array(null);
    public static $show = false;
    public static $affected_rows;
    public static $lastInsertID;
	
	/**
	 * @param PDO $PDO
	 * @return PDO
	 */
    public function __construct(PDO $PDO = null) {
        if(empty($PDO)){
            $this->PDO = Model::$PDO;
        } else {
            if($PDO instanceof PDO) {
                $this->PDO = $PDO;
            } else {
                throw new RemusException('Пиздец');
            }
        }
        return $this->PDO;
    }
    
	/**
     * SELECT - осуществляет выборкуиз БД
     * 
     * @param string|array $column Необходимые столбцы
     * @return QueryBuilder
     */
    public function select($column = '*') {
        $this->reset();
        $this->operation[0] = 'select';
        $this->column($column);
        $this->SQL = 'SELECT ';
        
        return $this;
    }
    
    /**
     * UPDATE - Изменение записи в БД
     * 
     * @param type $set_array Данные которые требуется заменить
     * @return QueryBuilder
     */
    public function update($set_array) {
        $this->reset('update');
        $this->SQL = 'UPDATE ';
        $this->registr['set'] = $set_array;
        return $this;
    }
    
    /**
     * DELETE - удаление записи из БД
     * 
     * @return QueryBuilder
     */
    public function delete() {
        $this->reset('delete');
        $this->SQL = 'DELETE ';
        return $this;
    }
    
    /**
     * INSERT - добавление новой записи в БД
     * 
     * @param array $record Запись
     * @return QueryBuilder
     */
    public function insert($record) {
        $this->reset('insert');
        $this->SQL = 'INSERT INTO ';
        foreach ($record as $key => $value) {
            $this->registr['column'][] = $key;
            $this->registr['param'][]  = $value;
        }
        return $this;
    } 
    
    /**
     * FROM -  таблица с которой будет работать класс
     * @param string $nameTable Название таблицы
     */
    public function from($nameTable) {
        $this->table = $nameTable;
        return $this;
    }
    
    /**
     * WHERE - Устанаваливает условия отбора записи
     * 
     * @param string $string Условия отбора записи
     * @return QueryBuilder
     */
    public function where($string) {
        if($this->where == NULL){
            $this->where = 'WHERE '.$string.' ';
        } else{
            $this->where .= ' AND '.$string.' ';
        }
        return $this;
    }
    
    /**
     * ORDER BY - Сортирует по указаному столбцу
     * 
     * @param array $column Столбец
     * @return QueryBuilder
     */
    public function order($column,$asc = false) {
        $order = '';
        
        if($asc){$asc = 'ASC';} else {$asc = 'DESC';}
        
        foreach ($column as $table => $col) {
            $order .= ' ORDER BY `'.$table.'`.`'.$col.'` '.$asc.' ';
        }
        $this->order = $order;
        
        return $this;
    }
    
    /**
     * LIMIT - Устанавливает лимит выборки
     * 
     * @param string|integer|array $start Начальная
     * @param string|integer $number Количество
     * @return QueryBuilder
     */
    public function limit($start,$number = null) {
        
        if(is_array($start)){
            if((count($start) == 2)){
                $number = $start[1];
                $start = $start[0];
            } elseif (count($start) == 1) {
                $number = array_shift($start);
                $start = 0;
            } else {
                throw new Exception('Wrong limit parametr');
            }
        }
        
        $this->limit = 'LIMIT '.(int) $start;
        
        if($number != NULL){
            $this->limit .= ' , '.(int) $number;
        }
        return $this;
    }
    
    /**
     * BIND - Устанавливает значения для замены в SQL-коде
     * 
     * @param string|array $mask Маска
     * @param string $value Значение
     * @return QueryBuilder
     */
    public function bind($mask,$value = null) {
        if($value=== null and is_array($mask)){
            $this->bind = array();
            foreach ($mask as $key => $val) {
                $this->bind[$key] = $val;  
            }
        } elseif ((is_string($mask) or is_numeric($mask)) and $value == null){
            if(count($this->bind) < 1){
                $this->bind[1] = $mask;
            }
            else {
                $this->bind[] = $mask;
            }
        }
        else{
            $this->bind[$mask] = $value;
        }
        return $this;
    }
    
    private function SafeQuot($array) {
        if(is_array($array)){
            foreach ($array as $key => $value) {
                $exit = $key.'`.`'.$value;
                break;
            }
        }
        if(is_string($array)){
            $string = str_replace('.', '', $array);
            if($array === $string){
                $exit = $string;
            } else {
                $array = explode('.', $array);
                if(count($array) == 2){
                    $array = array($array[0]=>$array[1]);
                } else{
                    $exit = implode('`.`', $array);
                }
            }
        }
        if(!isset($exit)){
            foreach ($array as $key => $value) {
                $exit = $key.'`.`'.$value;
            }
        }
        return _quote($exit);
    }
    
    private function column($column) {
        if($column === '*') {
            $this->column = $column;
        }
        else{
            if(is_string($column)){
                $column = explode(',',$column);
            }
            if(is_array($column)){
                $arroy = array();
                foreach ($column as $key => $value) {
                    if(is_array($value)){
                        $mors = array();
                        foreach ($value as $col) {
                            $mors[] = $key._quote().'.'._quote().$col;
                        }
                        $value = $mors;
                    }
                    $arroy[] = $value;
                }
                $this->column = $arroy;
            }
        }
    }
    
    /**
     * Возвраает последний выставленный ID
     */
    public function GetLastID() {
        return $this->PDO->lastInsertId();
    }
    
    /**
     * Обнуляет все св-ва класса
     */
    public function reset($operation = NULL) {
        if($operation <> NULL){
            $this->operation = array($operation);
        }
        
        $this->SQL      = NULL;
        $this->table    = NULL;
        $this->where    = NULL;
        $this->limit    = NULL;
        $this->count    = NULL;
        $this->order    = NULL;
        $this->bind     = NULL;
        $this->result   = NULL;
        $this->registr['column']  = array();
        $this->registr['param']   = array();
        $this->registr['set']     = array();
        self::$affected_rows = NULL;
        self::$lastInsertID  = NULL;
    }
    private function getColumn(){
        if(is_array($this->column)){
            $this->column = array_map('_quote', $this->column);
            $this->column = implode(',', $this->column);
        }
        if(is_string($this->column)){
            return $this->column;
        }
    }
    
    public function prepare(){
        if($this->operation[0] == NULL){
            $this->operation[0] = '';
        }
        switch ($this->operation[0]) {
            case 'select':
                $this->SQL.=
                    $this->getColumn()
                    .' FROM '._quote($this->table)
                    .$this->where
                    .$this->order
                    .$this->limit; break;

            case 'delete':
                $this->table = $this->SafeQuot($this->table);
                $this->SQL.=
                         ' FROM '.$this->table
                         .$this->where; break;

            case 'update':
                $this->table = $this->SafeQuot($this->table);
                $this->SQL.=   $this->table.' SET ';
                $array = array();
                foreach ($this->registr['set'] as $key => $value) {
                    if(is_numeric($value)){
                        $value = (int) $value;
                    } else {
                        $value = "'".(string) $value."'";
                    }
                    $array[] = $this->SafeQuot($key).' = '.$value;
                }
                $this->SQL.=   implode(', ',$array).' '.$this->where; break;
                     
            case 'insert':
                $this->table = $this->SafeQuot($this->table);
                $this->SQL .= ' '.$this->table.' '
                         .'('.implode(',', array_map("_quote", $this->registr['column'])).')'
                         .' VALUES '
                         .'('.implode(',', array_map("_quoter", $this->registr['param'])).');'; break;
        }
        if(self::$show === true){
            print_var($this->SQL,'SQL Code');
        }
        return $this;
    }
    public function execute() {
        
        $time = microtime(true);
        $STH = $this->PDO->prepare($this->SQL);
        
        try {
            if($this->operation[0] == 'select'){
                if($this->bind <> null){
                    foreach ($this->bind as $key => $value) {
                        $STH->bindParam($key, $value);
                    }
                }
                $STH->execute();
                $this->result = $STH->fetchAll(PDO::FETCH_ASSOC);
            } elseif (array_shift($this->operation) == NULL) {
                $STH->execute();
                $this->result = $STH->fetchAll(PDO::FETCH_ASSOC);
            } else{
                if($this->bind <> null){
                    $STH->execute($this->bind);
                } else{
                    $STH->execute();
                }
                $this->result = $STH->rowCount();
            }
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
        if(isset($this->operation[0]) and ($this->operation[0] == 'insert')){
            self::$lastInsertID = $this->GetLastID();
        }
        
        if(REMUSPANEL){
            
            $trace = debug_backtrace(); 
            
            RemusPanel::addData('query', array(
                'sql'       => $this->SQL,
                'result'    => RemusPanel::types($this->result),
                'trace'     => $trace[1]
            ));
        }
    }
    
    /**
     * Позволяет добавить свой SQL код
     */
    public function sql($sql) {
        if($this->SQL != NULL){
           $this->SQL .= $sql;
        } else {
            $this->SQL = $sql;
        }
    }
    
    /**
     * Получение результата всех манипуляций
     */
    public function result(){
        $this->prepare();
        $this->execute();
        return $this->result;
    }

    public function __toString() {
        return (string) $this->SQL;
    }
}
