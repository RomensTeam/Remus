<?php
# Защита
if (!defined('VERSION')){exit();}

include_once DIR_CORE_MODULE.'Core.php';

try {

    new Core();
} catch (Throwable $exc){
    exception_handler($exc);
    exit();
}
catch (RemusException $exc){
    exception_handler($exc);
    exit();
}