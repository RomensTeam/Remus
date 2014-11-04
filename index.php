<?
$time_start = microtime(true);

define('VERSION', '0.2');

if (version_compare(phpversion(),'5.3.0','<')){
	exit('PHP5.3 Only');
}

define('_DS',DIRECTORY_SEPARATOR);
define('DIR',realpath(dirname(__FILE__))._DS);

$directory = array(
	'APP'           =>  'r-app',
	'CORE'          =>  'r-core',
	'LIB'           =>  'r-app/lib',
	'VIEW'          =>  'r-core/view',
	'MODEL'         =>  'r-core/model',
	'SETTINGS'      =>  'r-app/settings',
	'APP_LANG'      =>  'r-app/app-lang',
	'APP_PAGE'      =>  'r-app/app-page',
	'THEMES'        =>  'r-app/app-themes',
	'CORE_MODULE'   =>  'r-core/core_module',
	'INTERFACE'     =>  'r-app/lib/interface',
	'DEFAULT'       =>  'r-core/core_module/def_set',
);

foreach ($directory as $key => $value) {
	if(!defined($key)){
		$value = realpath(DIR.$value)._DS;
		if($value != '\\'){
			if(is_dir($value)){
				$key = 'DIR_'.strtoupper(str_replace(' ','_',$key));
				@define($key, $value);
			}
		}
	}
}

# Подключаем ядро
    include DIR_CORE.'core.php';

# Конец работы фреймворка
if(defined('TEST_MODE_ON') || TEST_MODE){
    if(!defined('TEST_MODE_OFF')){
		$string = sprintf(Controller::Model()->lang['test_time_script'],microtime(true)-$time_start);
		$title = Controller::Model()->lang['test_time_name'];
        print_var($string,$title);
    }
}