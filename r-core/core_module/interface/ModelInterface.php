<?php

/**
 *  RemusModelInterface - интерфейс фреймворка для поддержания совместимости со
 *  стороними решениями
 * 
 * @author Roman
 */
interface ModelInterface {
    
    /**
     * Выполняет добавление данных для отображения
     * 
     * @param mixed $var
     * @param mixed $value
     */
    public function var_app($var = null, $value = null);
    
    /**
     * Производит обработку данных для последующего отображения
     */
    public function render();
}
