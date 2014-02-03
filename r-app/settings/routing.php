<?
$routing_rules = array(
    
    # Index
    'Index' => array(
        'regxp' => array(                   # Перечисление регулярных выражений в массиве
            '/^$/'
        ),
        'regexp'     => '/^$/',      # Регулярное выражение в строке
        'module'    => 'IndexController',   # Класс-Контроллер
        'method'    => 'Start',             # Метод Класса-Контроллера
        'file'      => 'index.php'          # Файл Класса-Контроллера
    ),
    
    # Login
    'Login' => array(
        'regxp' => array(                   # Перечисление регулярных выражений в массиве
            '/^(login)$/'
        ),
        'regexp'     => '/^(login)$/',      # Регулярное выражение в строке
        'module'    => 'LoginController',   # Класс-Контроллер
        'method'    => 'Start',             # Метод Класса-Контроллера
        'file'      => 'login.php'          # Файл Класса-Контроллера
    ),
);