<?
if(!defined('DIR')){exit();} // Защита
$lang = $romens->app_lang('ru-RU'); // Этот модуль включает в себя Многоязычность приложения
$romens->setLayout('index'); // Выбираем страницу INDEX из темы
$romens->type_output(HTML);  // Тип вывода
    // Прописываем META
    $site_meta['title']         = $lang['index_title'];
    $site_meta['description']   = $lang['index_description'];
    $site_meta['keywords']      = $lang['index_keywords'];
$romens->start_html_app($site_meta);
$romens->addToHead('<link href="style/style.css" media="screen" rel="stylesheet">');
// Ваш код здесь!

$array = array(
    'header'=>'Поздравляю вас! Всё работает.'
);
$romens->var_app($array); // Добавление переменных
$romens->render(); // Загрузка шаблона, рендеринг и отправка данных.