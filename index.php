<?php
# Время работы скрипта
	define('TIME_START', microtime(true));

# Определение версии
    define('VERSION', '0.4');

# Определение версии PHP
    if (version_compare(phpversion(),'7.0.0','<=')){
        exit('PHP 7 or higher');
    }
# Дерективы
    define('_DS',DIRECTORY_SEPARATOR);
    define('DIR',realpath(dirname(__FILE__))._DS);

# Определение дирректорий
    /**
     *  Здесь прописываются директории
     */
    $directory = array(
        'APP'           =>  'r-app',
        'CORE'          =>  'r-core',
        'LIB'           =>  'r-app/lib',
        'APP_LANG'      =>  'r-app/lang',
        'APP_PAGE'      =>  'r-app/page',
        'VIEW'          =>  'r-core/view',
        'THEMES'        =>  'r-app/themes',
        'MODEL'         =>  'r-core/model',
        'DEV_LIB'       =>  'r-core/devlib',
        'SETTINGS'      =>  'r-app/settings',
        'VIEW_CORE'     =>  'r-core/view_core',
        'CORE_MODULE'   =>  'r-core/core_module',
        'INTERFACE'     =>  'r-app/lib/interface',
        'TYPES'         =>  'r-core/core_module/types',
        'DEFAULT'       =>  'r-core/core_module/def_set',
        'CORE_INTERFACE'=>  'r-core/core_module/interface'
    );
	
    foreach ($directory as $key => $value) {      
        if(!defined($key)){
            $value = realpath(DIR.$value)._DS;
            if($value != '\\'){
                if(is_dir($value) and !defined($value)){
                    $key = 'DIR_'.strtoupper(str_replace(' ','_',$key));
                    define($key, $value);
                }
            }
        }
    }
# Подключаем основу
    include_once DIR_CORE.'core.php';