<?
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
if(substr($_SERVER['HTTP_HOST'],-1) == '.'){
    header('Status: 404 Not Found');
    $host = $_SERVER['HTTP_HOST'];
    $n = strlen($host);
    $host = substr($host,0,$n-1);
    header('Location: http://'.$host.'/');
    exit();
}

?>