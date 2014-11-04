<?
# Убираем WWW
if(defined('WWW')){
    if(WWW == FALSE){
        if(preg_match('/^www.(.*).([a-z])$/',$_SERVER['HTTP_HOST'])){
            header('Status: 404 Not Found');
            $host = $_SERVER['HTTP_HOST'];
            $n = strlen($host);
            $host = substr($host,4,$n);
            header('Location: http://'.$host.'/');
            exit();
        }
    }
}
# Убираем точку в конце хоста
if(substr($_SERVER['HTTP_HOST'],-1) === '.'){
    header('Status: 404 Not Found');
    $host = $_SERVER['HTTP_HOST'];
    $n = strlen($host);
    $host = substr($host,0,$n-1);
    header('Location: http://'.$host.'/');
    exit();
}
# Убираем доступ к index.php
if(defined('NOT_INDEX')){
    if(NOT_INDEX == TRUE){
        if('/index.php' === $_SERVER['REQUEST_URI'] || '/index.html' === $_SERVER['REQUEST_URI']){
            header('Status: 404 Not Found');
            $host = $_SERVER['HTTP_HOST'];
            $n = strlen($host);
            $host = substr($host,4,$n);
            header('Location: http://'.$host.'/');
            exit();
        }
    }
}
?>