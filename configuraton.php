<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


/*
 *  Определяет работоспособность фреймворка
 * 
 * Если значение FALSE - Фреймворк отключаеться
 * Если значение TRUE  - фреймворк продолжает работу
 * 
 */
const SITE_ENGINE = FALSE;
/*
 *  Язык фреймворка
 * 
 * Служит для вывода логов и ошибок на определёном языке для уддобства разработчика
 * 
 */
const LANG = 'ru';

/*
 *  Доступ к базе с которым будет работать фреймворк
 * 
 *  Тип доступа:
 *      <li>MySQL - не рекомендуется</li>
 *      <li>MySQLI</li>
 *      <li>PDO</li>
 * 
 */
const BASE = 'MySQLI';

/*
 *  Кол-во баз с которой будет работать фреймворк
 * 
 * Укажите число баз с которыми вы будете работать
 * 
 */
const BASE_NUMBER = 1;

/*
 *  Параметры для доступа к базе данных
 * 
 * host - хост базы данных
 * user - логин
 * pass - пароль
 * prefix - префикс базы данных, если его нет то оставить пустым
 * base - база (базы) данных
 * 
 */
$cfg['base']['host']   = 'localhost';
$cfg['base']['user']   = 'root';
$cfg['base']['pass']   = '';
$cfg['base']['prefix'] = '';
$cfg['base']['base']   = array(
    'base_number_1', // Первая база данных
    'base_number_2'
);

?>
