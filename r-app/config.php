<?
if(!defined('DIR')){exit();} // Защита
// Настройки сайта по умолчанию
$site_meta = array(
    'title'=>'Romens-Engine: Первый Сайт',
    'description'=>'Первый сайт сделанный на Romens-Engine',
    'keywords'=>'Romens-Engine',
    'favicon'=>URL.'favicon.ico',
    'preview-image'=>URL.'preview_image.png'
);
Controller::Model()->setTheme('default'); // Выбираем тему