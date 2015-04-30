<?php
# Время работы скрипта
    $time_start = microtime(true);

# Определение версии
    define('VERSION', '0.3');

# Определение версии PHP
    if (version_compare(phpversion(),'5.3.0','<')){
        exit('PHP5.3 Only');
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
    
        const DIR_APP           = "E:\\Project\\Remus_LANG\\r-app\\";
        const DIR_CORE          = "E:\\Project\\Remus_LANG\\r-core\\";
        const DIR_LIB           = "E:\\Project\\Remus_LANG\\r-app\\lib\\";
        const DIR_APP_LANG      = "E:\\Project\\Remus_LANG\\r-app\\lang\\";
        const DIR_APP_PAGE      = "E:\\Project\\Remus_LANG\\r-app\\page\\";
        const DIR_VIEW          = "E:\\Project\\Remus_LANG\\r-core\\view\\";
        const DIR_THEMES        = "E:\\Project\\Remus_LANG\\r-app\\themes\\";
        const DIR_MODEL         = "E:\\Project\\Remus_LANG\\r-core\\model\\";
        const DIR_DEV_LIB       = "E:\\Project\\Remus_LANG\\r-core\\devlib\\";
        const DIR_SETTINGS      = "E:\\Project\\Remus_LANG\\r-app\\settings\\";
        const DIR_VIEW_CORE     = "E:\\Project\\Remus_LANG\\r-core\\view_core\\";
        const DIR_CORE_MODULE   = "E:\\Project\\Remus_LANG\\r-core\\core_module\\";
        const DIR_DEFAULT       = "E:\\Project\\Remus_LANG\\r-core\\core_module\\def_set\\";
        const DIR_CORE_INTERFACE = "E:\\Project\\Remus_LANG\\r-core\\core_module\\interface\\";


    foreach ($directory as $key => $value) {      
        if(!defined($key)){
            $value = realpath(DIR.$value)._DS;
            if($value != '\\'){
                if(is_dir($value)){
                    $key = 'DIR_'.strtoupper(str_replace(' ','_',$key));
                    @define($key, $value);
                    /*echo 'const '.$key.' = "'.str_replace('\\', '\\\\', $value).'";
                            ';*/
                }
            }
        }
    }

# Подключаем основу
    include_once DIR_CORE.'core.php';