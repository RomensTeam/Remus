<?php
const _DS = DIRECTORY_SEPARATOR;
function __autoload($class_name) {
    $filename = strtolower($class_name) . '.php';
    $file = 'lib'._DS.$filename;
    if (file_exists($file) == false) {
        return false;
    }
    include $file;
}
?>
