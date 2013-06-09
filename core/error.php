<?php
class Error {
    public $error = array(
        400=>'Bad Request',
        401=>'Unauthorized',
        402=>'Payment Required',
        403=>'Forbidden',
        404=>'Not Found',
        405=>'Method Not Allowed',
        408=>'Request Timeout',
        414=>'Request-URL Too Long'
    );
    public static function error( $number = 404, $redirect = FALSE){
        if(is_numeric($number)){
            $number = intval($number);
            header('Status: '.$number.' '.$this->error[$number]);
            if($redirect!=FALSE){header('Location: '.$redirect);}
            exit();
        }
    }
}

?>
