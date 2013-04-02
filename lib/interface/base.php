<?php
interface Base {
    /**
     *  SELECT - выборка из базы данных
     * 
     * @param array|string  $column Какие столбцы нужны
     * @param string        $table  Имя таблицы
     * @param string|array  $colflt Description
     * @param string|array  $sings  Символы
     * @param array|string  $value  Значения
     * 
     *        
     */
    public function select($column, $table, $colflt, $signs, $value); 
} 
?>
