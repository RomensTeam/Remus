<?php

/**
 * InfoBlock - базовый тип позволяющий осуществлять CRUD-операции
 *
 * @author Romens
 */
class InfoBlock {
    
    /**
     * 
     * @var QueryBuilder
     */
    protected static $QB = NULL;
    
    protected $_name = null;


    public function __construct($table = null) 
    {
        Remus::Model()->connect('Соединение с БД инициализировано через тип данных InfoBlock');
        if(isset(Model::$PDO) and Model::$PDO instanceof PDO){
            self::$QB = new QueryBuilder(Model::$PDO);
        } else {
            throw new RemusException('Не подключен');
        }
        
        if(is_string($table)){
            $this->_name = $table;
            return TRUE;
        }
        
        return FALSE;
    }
    
    /**
     * Add - добавление записи в инфоблок
     * 
     * Status: WORK!
     */
    public function add($record = array())
    {
        QueryBuilder::$show = true;
        if(!empty($record)){
            self::$QB->insert($record)
                     ->from($this->_name);
            if((bool) self::$QB->result()){
                return self::$QB->GetLastID();
            } else {
                return FALSE;
            }
        }
        return FALSE;
    }
    
    /**
     * Get - получение записи инфоблока
     * 
     * Status: WORK!
     */
    public function get($type = null,$column = '*', $limit = array(0,10)) 
    {
        self::$QB->select($column)
                ->from($this->_name);
        if(is_numeric($type)){
            self::$QB->where(' `id` = '.(int) $type);
        }
        if(is_array($type)){
            foreach ($type as $key => $val) {
                if(is_numeric($val)){
                    $val = (int) $val;
                    self::$QB->where(' `'.$key.'` = '.$val);
                } else {
                    if(is_null($val)){
                        self::$QB->where(' `'.$key.'` IS NULL ');
                    } else {
                        self::$QB->where(' `'.$key.'` = '.  _quoter($val));
                    }
                }
            }
        }
        self::$QB->limit($limit);
        $result = self::$QB->result();
        return $result;
    }
    
    /**
     * getParam - получение информации через id
     * 
     */
    public function getParam($id,$param) 
    {
        if(empty($param)){
            return $this->get($id);
        } else {
            self::$QB->select($param)
                    ->from($this->_name)
                    ->where(' `id` = '.(int) $id);
            $result = self::$QB->result();
            
            if(!empty($result) and is_array($result)){
                return array_shift($result);
            } else {return $result;}
        }
        return FALSE;
    }
    
    /**
     * Update - обновление записи инфоблока
     * 
     * Status: WORK!
     */
    public function update($id,$record) 
    {
        if(!empty($record)){
            self::$QB->update($record)
                     ->from($this->_name)
                    ->where('`id` = '. (int) $id);
             return (bool) self::$QB->result();
        }
        return FALSE;
    }
    
    /**
     * Delete - удаление записи инфоблока
     * 
     * Status: WORK!
     */
    public function delete($id)
    {
        self::$QB->delete()
                ->from($this->_name)
                ->where('`id` = '. (int) $id);
        QueryBuilder::$show = true;
        return (bool) self::$QB->result();
    }
}