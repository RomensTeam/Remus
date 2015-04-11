<?php
$flag = array(
    'TEST_MODE'             => FALSE,
    'URL'                   => 'http://' . $_SERVER['HTTP_HOST'] . '/',
    'WWW'                   => TRUE,
    'LOAD_MODEL'            => TRUE,
    'NOT_INDEX'             => TRUE,
    'BASE_CONFIG_PHP'       => FALSE,
    'BASE'                  => 'MySQL',
    'BASE_DRIVER'           => 'PDO',
    'BASE_NUMBER'           => 1,
    'COMPRESS'              => FALSE,
    'CHARSET'               => 'UTF-8',
    'BASE_HOST'             => 'localhost',
    'BASE_PATH'             => 'r-app/base/mybase.sqlite',
    'BASE_SETTINGS_FILE'    => 'base.php',
    'BASE_LOGIN'            => 'root',
    'BASE_PASS'             => '',
    'BASE_PREFIX'           => '',
    'BASE_PORT'             => 3306,
    'BASE_BASE'             => 'remus',
    'ROUTER'                => 'DYNAMIC2',
    'FUNC_FUNNY'            => TRUE,
    'NOT_ROUTING_FILE'      => '404.php',
    'APP_LANG_METHOD'       => 'JSON_FILE',
    'APP_LANG_FORMAT'       => 'JSON',
    'APP_LANG_PREFIX'       => '',
    'APP_LANG_PATTERN'      => '',
    'APP_LANG_EXT'          => 'json',
    'APP_VIEW_HTML'         => 'View',
    'APP_MODEL'             => 'Model',
    'LAYOUT_FOLDER'         => 'page',
    'THEME_FILE'            => 'theme.json',
    'SUPPORT_DEVELOPERS'    => TRUE,
    'ENV'                   => 'LOCAL',
    'VIEW_CORE'             => 'RemusView',
    
    # Предопределенные константы
    'LIBRARY' => 2,
    
    # Настройка обработчика View
    'VIEW_TAG_PATTERN'          =>'/{\[([A-Z0-9_]+)\]\}/',
    
    'VIEW_BLOCK_TAG_PATTERN'    =>'/{\[BLOCK_([A-Z0-9_]+)\]\}/',
    
    'FOREACH_TAG_PATTERN'       =>'/\{\[FOREACH\(([A-Z0-9_]+)\)\:START\]\}([^\:]+)\{\[FOREACH\:END\]\}/',
    
    'FILL_TAG_PATTERN'          =>'/\{\[(.*)\]\|\[([A-Z0-9_]+)\]\}/',
    'FILL_ALTER_TAG_PATTERN'    =>'???',
    
    'VIEW_BLOCK_TAG_NAME'       =>'BLOCK_',
    'VIEW_BLOCK_TAG_FOLDER'     =>'block',
    'VIEW_EXP_FILE'             =>'tpl',
    'VIEW_TAG_START'            =>'{[',
    'VIEW_TAG_END'              =>']}',
    'LANG'                      =>'ru'
);
foreach ($flag as $key => $value) {
    $key = strtoupper($key);
    if(!defined($key)){
        define($key,$value);
    }
}

# Экономим память
unset($flag);

# Определяем защищённые
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' && !defined('URLS') && defined('URL')){
    define('URLS',  str_replace('http://', 'https://', URL));
    define('HTTPS', TRUE);
}