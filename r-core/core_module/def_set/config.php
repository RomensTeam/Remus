<?php
return array(
    'TEST_MODE'             => FALSE,
    'URL'                   => getURL(),
    'WWW'                   => TRUE,
    'LOAD_MODEL'            => TRUE,
    'NOT_INDEX'             => TRUE,
    'COMPRESS'              => FALSE,
    'CHARSET'               => 'UTF-8',
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
    'REMUSPANEL'            => FALSE,
    
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