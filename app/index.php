<?
if(!defined('DIR')){exit();} // Защита
$lang = $romens->app_lang('ru'); // Этот модуль включает в себя Многоязычность приложения
$romens->setLayout('index'); // Выбираем страницу INDEX из темы
$romens->type_output(HTML);  // Тип вывода
    // Прописываем META
    $site_meta['title']         = $lang['index_title'];
    $site_meta['description']   = $lang['index_description'];
    $site_meta['keywords']      = $lang['index_keywords'];
$romens->start_html_app($site_meta);
// Ваш код здесь!
/*$romens->connect_base();
$romens->change_base('user32052_romens_user');
$query_to_base = 'SELECT * FROM  `romens_user_profile`'; 
$result = $romens->base->query($query_to_base, ASSOC);*/
$array = array(
    'header'=>'Здесь шаблон HEADER'
);
$romens->var_app($array); // Добавление переменных
$romens->render(); // Загрузка шаблона, рендеринг и отправка данных.