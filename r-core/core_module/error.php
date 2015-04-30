<?php
class Error {
    public static $error = array(
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        408 => 'Request Timeout',
        414 => 'Request-URL Too Long'
    );
    public static function error( $number = 404, $redirect = false){
		$number = (integer) $number;
		header('Status: '.$number.' '.self::$error[$number]);
		if($redirect){
			header('Location: '.$redirect);
			exit();
		}
            
    }
}

?>
