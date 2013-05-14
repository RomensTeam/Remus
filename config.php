<?
// Настройки движка
define('LANG', 'ru');

define('BASE','MySQL'); // Поддержка: MySQL, SQLite, PostgreSQL. Если этого параметра нет, то база использоваться не будет во всё приложении.
define('BASE_DRIVER', 'MySQL'); // Желательно выбрать PDO, но если вы хотите работать с другим драйвером то укажите.
define('TEST_MODE', TRUE);
define('BASE_NUMBER', 1);
define('COMPRESS', FALSE);
define('CHARSET','UTF-8');

// Настройки базы
$_cfg['host']   = 'localhost';
$_cfg['login']  = 'root';
$_cfg['pass']   = '';
$_cfg['prefix'] = '';
$_cfg['base']   = array(
    'base_number_1', // Первая база данных
    'base_number_2'
);

// Роутинг
$app = array(
    '/index/'=>'index.php'
);
?>
