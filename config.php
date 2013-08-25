<?
/**
 * Конфигурация приложения и фреймворка в целом
 *
 */
if (!defined('VERSION')) {
    exit();
} # Защита
# Настройки движка
define('LANG', 'ru'); # Язык фреймворка ошибок
define('TEST_MODE', FALSE);
define('WWW', FALSE); # Оставлять доступ к сайту через www.your_site.com
define('LOAD_ROMENS', TRUE); # Создавать ли объект с классом Romens
define('NOT_INDEX', TRUE); # Перенаправляет с INDEX.HTML и index.php на URL
# Настройки базы данных
define('BASE_CONFIG_PHP', FALSE); # Если у вас настройки для подключения к базе данных прописаны в php.ini или в .htaccess то укажите этот параметр
define('BASE', 'MySQL'); # Поддержка: MySQL, SQLite, PostgreSQL. Если этого параметра нет, то база использоваться не будет во всё приложении.
define('BASE_DRIVER', 'MySQL'); # Желательно выбрать PDO, но если вы хотите работать с другим драйвером то укажите.
define('BASE_NUMBER', 1); # Кол-во баз с которыми вы будете работать.
define('ROMENSBASE', TRUE);

/** 
 * Настройки базы данных
 *
 * Если вы используете SQLite то укажите путь.
 *
 */
define('BASE_HOST', 'localhost'); # Сервер хранения базы данных
define('BASE_PATH', 'app/base/mybase.php'); # Путь к базе данных. Если база данных это SQLite
define('BASE_LOGIN', 'root'); # Логин пользователя
define('BASE_PASS', ''); # Пароль
define('BASE_PREFIX', ''); # Префикс таблиц
define('BASE_PORT', ''); # Порт
define('BASE_BASE', 'user32052_romens_user , base_number_2'); # Представленны две базы

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
# Роутинг
$app = array(
    '/index/' => 'index.php', 
    '/favicon.png/' => 'http://habrahabr.ru/favicon.ico'
    # Укажите ПАТТЕРН => Исполняемый файл
    # Укажите ПАТТЕРН => Ссылка
);