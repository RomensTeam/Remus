<?
/**
 * Конфигурация приложения и фреймворка в целом
 *
 */
# Настройки движка
define('LANG', 'ru'); # Язык фреймворка ошибок
define('TEST_MODE', FALSE);
define('WWW', FALSE); # Оставлять доступ к сайту через www.your_site.com
define('LOAD_ROMENS', TRUE); # Создавать ли объект с классом Romens
define('NOT_INDEX', TRUE); # Перенаправляет с INDEX.HTML и index.php на URL
/** 
 * Настройки базы данных
 *
 * Если вы используете SQLite то укажите путь.
 */
define('BASE_HOST', 'localhost'); # Сервер хранения базы данных
define('BASE_PATH', 'app/base/mybase.php'); # Путь к базе данных. Если база данных это SQLite
define('BASE_LOGIN', 'root'); # Логин пользователя
define('BASE_PASS', ''); # Пароль
define('BASE_PREFIX', ''); # Префикс таблиц
define('BASE_PORT', ''); # Порт
define('BASE_BASE', 'user32052_romens_user , base_number_2'); # Представленны две базы
define('ROUTER', 'DYNAMIC');