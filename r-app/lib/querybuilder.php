<?

/**
 * Description of querybuilder
 *
 * @author Romens
 */
class SQLQueryBuilder {
        
        /**
         * SQL_Operators - операторы SQL
         */
        public $SQL_Operators = array(
            'SELECT',
            'INSERT',
            'DELETE',
            'FROM',
            'AS',
            'DESC',
            'ORDER BY',
            'JOIN',
            'INNER JOIN'
        );
        
        public $SQL_Array;
        
        public $SQL_Table;
        
        public $SQL_TableNum;


        public $SQL_Result;


        public function select($table, $column = '*') {
            $this->SQL_Result = 'SELECT '.$this->ArrayAsString($column).' FROM '.$this->Quotes($table);
            return $this;
        }
        
        public function where($parametr) {
            $this->SQL_Result .= 'WHERE ';
        }
        
        public function update() {
            
        }
        
        public function limit() {
            
        }
        
	private function ArrayAsString($array) {
            if(is_array($array)){
                $array = '`'.implode('`, `', $array).'`';
            }
            return $array;
        }
        
        private function Quotes($item) {
            return '`'.$item.'`';
        }
		
        
        public function __toString() {
            foreach ($this->SQL_Operators as $value) {
                $this->sql = str_replace(strtolower($value), strtoupper($value), $this->sql);
            }
            return $this->sql;
        }
    }