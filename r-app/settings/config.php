<?
/**
 * Конфигурация приложения и фреймворка в целом
 *
 */
# Настройки движка
define('LANG', 'ru'); # Язык фреймворка ошибок
define('TEST_MODE', TRUE);
define('WWW', FALSE); # Оставлять доступ к сайту через www.your_site.com
define('FUNC_FUNNY',TRUE);


/**
 * Настройки базы данных
 *
 * Если вы используете SQLite то укажите путь.
 */
define('BASE_SETTINGS_FILE', 'base.json'); # Название файла настроек


 /**
  * Настройки роутинга
  *
  */
define('ROUTER', 'DYNAMIC2');


/**
 *  Environment
 *
 *  Access values:
 *    LOCAL         - локальный сервер
 *    DEVELOPMENT   - разработка
 *    TESTING       - тестирование
 *    PRODUCTION    -
 *
 */
define('ENV', 'LOCAL');
