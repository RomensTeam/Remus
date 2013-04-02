<?php
interface Base {
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
    function select($column, $table, $colflt, $signs, $value, $output); 
    
    
} 
?>
