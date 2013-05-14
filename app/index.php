<?
if(!defined('DIR')){exit();} // Защита

$lang = $romens->app_lang($_GET['lang']); // Этот модуль включает в себя Многоязычность приложения
$romens->set_layout('default');
$site_meta['title'] = 'Название сайта'; $site_meta['description'] = 'Описание сайта'; 
$romens->start_app($site_meta);
$romens->set_page('index');
$romens->page = str_replace('{LANG[HELLO]}','Привет!',$romens->page);
$romens->out_page();
$romens->end_app();
?>
