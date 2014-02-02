<?
$routing_rules = array(

    #  Login
    'Login' => array(
        'regxp' => array(                   # Перечисление регулярных выражений в массиве
            '/^(login)$/'
        ),
        'regexp'     => '/^(login)$/',      # Регулярное выражение в строке
        'module'    => 'LoginController',   # Класс-Контроллер
        'method'    => 'Start',             # Метод Класса-Контроллера
        'file'      => 'login.php'          # Файл Класса-Контроллера
    ),
    'Login' => array(
        'regexp' => array(                   # Перечисление регулярных выражений в массиве
            '/^$/'
        ),
        'module'    => 'IndexController',   # Класс-Контроллер
        'method'    => 'Start',             # Метод Класса-Контроллера
        'file'      => 'index.php'          # Файл Класса-Контроллера
    ),
);