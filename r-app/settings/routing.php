<?
/** 
 * Настройки роутера
 *
 * DYNAMIC - На каждый паттерн свой обработчик
 * ^Пример: http://romens.ru/feed/  => http://romens.ru/app/feed.php
 * STATIC - Паттерны игнорируются и запрос напрямую идёт к обработчику
 * ^Пример: http://romens.ru/feed.php?lol=true  => http://romens.ru/app/feed.php
 *
 * В переменной "app" вводятся данные для роутера.
 * При STATIC этот параметр не нужен.
 */
$routing_rules = array(
    '/^(login)$/' => 'login.php',
    '/^favicon.png$/' => 'http://habrahabr.ru/favicon.ico',
    # Укажите ПАТТЕРН => Исполняемый файл
    # Укажите ПАТТЕРН => Ссылка
);