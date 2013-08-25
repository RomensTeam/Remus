<?
$flag = array(
    'TEST_MODE'=>FALSE, # Режим тестирования
    'URL'=>'http://' . $_SERVER['HTTP_HOST'] . '/', # HTTP-адрес сайта
    'WWW'=> TRUE,
    'LOAD_ROMENS'=> TRUE,
    'NOT_INDEX'=> TRUE,
    'BASE_CONFIG_PHP'=>FALSE,
    'BASE'=>'MySQL',
    'BASE_DRIVER'=> 'MySQL',
    'BASE_NUMBER'=> 1,
    'ROMENSBASE'=> FALSE,
    'COMPRESS'=> FALSE,
    'CHARSET'=> 'UTF-8',
    'BASE_HOST'=>'localhost',
    'BASE_PATH'=>'app/base/mybase.php',
    'BASE_LOGIN'=> 'root',
    'BASE_PASS'=> '',
    'BASE_PREFIX'=> '',
    'BASE_PORT'=> 3306,
    'BASE_BASE'=> 'mybase',
    'ROUTER'=>'DYNAMIC',
    'APP_LANG_METHOD'=>'JSON_FILE',
    'APP_LANG_FORMAT'=>'JSON',
    'APP_LANG_PREFIX'=>'',
    'APP_LANG_PATTERN'=>'',
    'APP_LANG_EXT'=>'json',
    'APP_VIEW_HTML'=>'RomensViewHTML',
    'APP_MODEL'=>'RomensModel',
    'SUPPORT_DEVELOPERS'=>TRUE,
    # Настройка обработчика View
    'VIEW_TAG_PATTERN'=>'{\[(.*)\]\}',
    'VIEW_TAG_START'=>'{[',
    'VIEW_TAG_END'=>']}',
    'LANG'=>'en'
);
foreach ($flag as $key => $value) {
    if(!defined($key)){define($key,$value);}
}