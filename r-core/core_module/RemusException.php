<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Exception
 *
 * @author Roman
 */
class RemusException extends Exception {}

function exception_handler(Exception $exc) {
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
set_exception_handler('exception_handler');