<?
// Настройки движка
define('LANG', 'ru'); // Язык фреймворка ошибок
define('TEST_MODE', TRUE); // Режим тестирования
define('URL','http://'.$_SERVER['HTTP_HOST'].'/');
define('URLS','https://'.$_SERVER['HTTP_HOST'].'/');

// Настройки базы данных
define('BASE','MySQL'); // Поддержка: MySQL, SQLite, PostgreSQL. Если этого параметра нет, то база использоваться не будет во всё приложении.
define('BASE_DRIVER', 'MySQL'); // Желательно выбрать PDO, но если вы хотите работать с другим драйвером то укажите.
define('BASE_NUMBER', 1); // Кол-во баз с которыми вы будете работать.

// Настройки вывода
define('COMPRESS', FALSE); // Сжимать данные перед отправкой или нет
define('CHARSET', 'UTF-8'); // Кодировка. Настоятельно использовать только UTF-8

/** 
 * Настройки базы данных
 * 
 * Если вы используете SQLite то укажите путь.
 * 
 */

$_cfg['host']   = 'localhost'; // Сервер хранения базы данных
$_cfg['path']   = 'app/base/mybase.php'; // Путь к базе данных. Если база данных это SQLite  
$_cfg['login']  = 'root'; // Логин пользователя
$_cfg['pass']   = ''; // Пароль
$_cfg['prefix'] = ''; // Префикс таблиц
$_cfg['base']   = array(
    'base_number_1', // Первая база данных
    'base_number_2' // Вторая
);

/** 
 * Настройки роутера
 * 
 * DYNAMIC - На каждый паттерн свой обработчик
 * ^Пример: http://romens.ru/feed.php?lol=true  => http://romens.ru/app/feed.php
 * STATIC - Паттерны игнорируются и запрос напрямую идёт к обработчику 
 * ^Пример: http://romens.ru/feed.php  => http://romens.ru/app/feed.php?lol=true
 * 
 * В переменной "app" вводятся данные для роутера.
 * При STATIC этот параметр не нужен.
 */ 
define('ROUTER', 'DYNAMIC');
// Роутинг
$app = array(
    '/index/'=>'index.php' // Укажите ПАТТЕРН => Исполняемый файл
);

// Настройки сайта по умолчанию
// Вы можете этого не указывать
$site_meta = array(
    'title'=>'Romens-Engine: Первый Сайт',
    'description'=>'Первый сайт сделанный на Romens-Engine',
    'keywords'=>'Romens-Engine',
    'favicon'=>URL.'favicon.png',
    'preview-image'=>URL.'preview_image.png'
);

/**
 * Настройки параметров для локализации приложения
 * 
 * Пока не надо ничего менять
 */
define('APP_LANG_METHOD', 'JSON_FILE');
define('APP_LANG_FORMAT', 'JSON');
define('APP_LANG_PREFIX', '');
define('APP_LANG_PATTERN', '');
define('APP_LANG_EXT', 'json');
?>
