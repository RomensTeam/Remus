<?php
# Определение AJAX-запроса
if ( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest' ){
       define('AJAX',TRUE);
} else{
       define('AJAX',FALSE);
}