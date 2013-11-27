<?
if(!defined('DIR')){exit();} // Защита
$romens->app_lang('ru-RU'); // Этот модуль включает в себя Многоязычность приложения
$romens->setLayout('index2'); // Выбираем страницу INDEX из темы
    // Прописываем META
    $site_meta['title']         = $lang['index_title'];
    $site_meta['description']   = $lang['index_description'];
    $site_meta['keywords']      = $lang['index_keywords'];
$romens->start_html_app($site_meta);
$romens->addToHead('<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">');
$romens->addToHead('<link href="style/style.css" media="screen" rel="stylesheet">');
$array = array(
    'version'=>VERSION
);
$romens->var_app($array); // Добавление переменных
$romens->render(); // Загрузка шаблона, рендеринг и отправка данных.