<?php

class RemusException extends Exception {}

/**
 * Добавление записи в лог
 *
 */
function writeLog($data, $type = null){
    if($type == 'json')
        $data = json_encode( $data, JSON_PRETTY_PRINT);
    error_log( print_r($data,true)."\n", 3, DIR_APP . 'debug.log');
}

function exception_handler( Throwable $exc) {

        if(TEST_MODE){
            if(REMUSPANEL)
                RemusPanel::log($exc);
            else
                writeLog($exc);
            return FALSE;
        }
        echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">';
        echo '<div class="alert alert-danger">';
        echo '<b>'.get_class($exc) .'</b>: '.lang('exc_pull').': <i>';
        echo '<p>'.$exc->getMessage() . '</p>';
        echo '<table class="table table-bordered well"><tbody>';
        $i = 0;
        $array = $exc->getTrace();
        asort($array);
        foreach ($array as $value) {
            echo '<tr>';
            echo '<td>'.$i.'</td><td> <code>'.  @str_replace(DIR, '', $value['file']).'</code> <span class="badge">'.@$value['line'].'</span></td><td>'; 
                echo @$value['class']; 
                echo @$value['type']; 
                echo @$value['function']; 
                if(is_array($value['args'])){
                    echo '('; $l = 0;
                    foreach ($value['args'] as $value) {
                        if($l > 0){echo ',';} echo '<code><span title="'.gettype($value).'">'.$value.'</span></code>'; $l++;
                    } echo ')';
                }
                echo '</td>';
            echo '</tr>';
            $i++;
        }
        echo'</tbody></table>'.lang('exc_path').': <b>' . $exc->getFile() . '</b> '.lang('exc_line').' <b>' . $exc->getLine() . '</b></div>';
}
function error_handler($number, $string, $file, $line)
{
    if (intval(E_WARNING) != intval($number))
    {
        $file = str_replace(DIR,'',$file);
        writeLog("PHP Error: ".$number." ".$file."(".$line.") | ".$string."");
    }
}
set_error_handler("error_handler",E_ALL);
set_exception_handler('exception_handler');