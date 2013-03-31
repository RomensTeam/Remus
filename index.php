<?
/*
 *  Файл index.php - основная точка входа
 * 
 * Описание
 * 
 * Алгоритм: 
 *      - Проверка версии PHP
 *      - Подключение конфигурации
 *
 */

if (version_compare(phpversion(), '5.3.0', '<') == true){exit('PHP5.3 Only');}

include 'core.php';
include 'configuraton.php';




?>