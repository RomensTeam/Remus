<?php
if(!defined('DIR')){exit();} // Защита
// Настройки сайта по умолчанию
$site_meta = array(
    'title'         => 'Remus: Первый Сайт',
    'description'   => 'Первый сайт сделанный на Remus',
    'keywords'      => 'Remus',
    'favicon'       => URL.'favicon.ico',
    'preview-image' => URL.'preview_image.png'
);
Remus::View()->head($site_meta);
Remus::View()->setTheme('version03'); // Выбираем тему   
Remus::View()->addScript('style/jquery.min.js', true);
Remus::View()->addToHead('<link rel="stylesheet" href="{[URL]}style/assets/css/normalize.css" media="screen">');
Remus::View()->addToHead('<link rel="stylesheet" href="{[URL]}style/assets/css/grid.css" media="screen">');
Remus::View()->addToHead('<link rel="stylesheet" href="{[URL]}style/assets/css/style.css" media="screen">');
Remus::View()->addToHead('<link rel="stylesheet" href="{[URL]}style/assets/font-awesome/css/font-awesome.min.css">');