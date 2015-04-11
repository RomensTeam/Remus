<?
/**
 * Конфигурация приложения и фреймворка в целом
 *
 */
# Настройки движка
define('LANG', 'ru'); # Язык фреймворка
define('TEST_MODE', TRUE);
define('WWW', FALSE); # Оставлять доступ к сайту через www.your_site.com


/**
 * Настройки базы данных
 *
 * Если вы используете SQLite то укажите путь.
 */
define('BASE_SETTINGS_FILE', 'base.php'); # Название файла настроек


 /**
  * Настройки роутинга
  *
  */
define('ROUTER', 'DYNAMIC2');

/**
 *  Environment - среда выполнения
 *
 *  Access values:
 *    LOCAL     - локальный сервер
 *    DEVELOP   - разработка
 *    TESTING   - тестирование
 *    PRODUCT   - продакшн
 *
 */
define('ENV', 'LOCAL');