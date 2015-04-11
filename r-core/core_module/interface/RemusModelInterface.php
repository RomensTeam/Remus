<?php

/**
 *  RemusModelInterface - интерфейс фреймворка для поддержания совместимости со
 *  стороними решениями
 * 
 * @author Roman
 */
interface RemusModelInterface {
    
    /**
     * Начинает работу HTML приложения
     * 
     * @param array $meta Необходимые META-данные
     * @return RemusModelInterface Возвращает самого себяы
     */
    public function start_html_app($meta = array());
    
    /**
     * Выполняет добавление данных для отображения
     * 
     * @param mixed $var
     * @param mixed $value
     */
    public function var_app($var = null, $value = null);
    
    /**
     * Заканчивает работу HTML приложения и отображает данные
     * 
     * @return RemusModelInterface
     */
    public function end_html_app();
    
    /**
     * Производит обработку данных для последующего отображения
     */
    public function render();
}
