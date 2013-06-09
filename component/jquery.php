<?
if(defined('DIR')){exit;}
if(defined('JQUERY_VERSION')){
    $url =  'http://code.jquery.com/jquery-'.JQUERY_VERSION.'.min.js';
}
else{
    $url =  'http://code.jquery.com/jquery-latest.min.js';
}
echo "{'addSript':'".$url.",TRUE'}";