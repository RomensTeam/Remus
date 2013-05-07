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
include_once 'configuraton.php';
if(COMPRESS == TRUE && is_defined('COMPRESS') ){ob_start(ob_gzhandler);}
include_once 'core.php';
?>