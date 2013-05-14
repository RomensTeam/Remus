<?
define('VERSION', '0.1');

if (version_compare(phpversion(), '5.3.0', '<') == true){
    exit('PHP5.3 Only');
}
include_once 'config.php';
include_once 'core.php';
?>