<?php
/**
 * RegExp - библиотека регулярных выражений
 * 
 * @category Library
 * @package RomensEngineStandartLibrary
 * @version 1.0 Mini
 * @author Roman Trutnev <romantrutnev@gmail.com>
 */
class RegExp {
    public $RegExp = array(
        'email'=>'/^([0-9a-zA-Z]([-.w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-w]*[0-9a-zA-Z].)+[a-zA-Z]{2,9})$/si', // Email. Example: <i@phpmaster.com>
        'time'=>'/^([0-1][0-9]|[2][0-3]):([0-5][0-9])$/si', // Time. Example: <24:03>
        'login'=>'/^([0-9a-zA-Z]([-.w]*[0-9a-zA-Z])$/', // Login. Example: <Romens>
        'login_lower'=>'/^([0-9a-z]([-.w]*[0-9a-z])$/', // Login Lower. Example: <romens>
        'ip_address'=>'/^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/', // . <>
        'full_domen_name'=>'/^(http|https|ftp)://([A-Z0-9][A-Z0-9_-]*(?:.[A-Z0-9][A-Z0-9_-]*)+):?(d+)?/?/i' // Full Domen Name. Example: <http://romens.ru/>
    );
    
    public function __construct($regexp) {
        $this->RegExp = $regexp;
    }
    
    public function addRegExp($regexp){
        if(is_array($regexp)){
            $this->RegExp = array_merge($this->RegExp, $regexp);
        }
        if(is_string($regexp)){
            $this->RegExp[] = $regexp;
        }
    }

    public function check($subject,$pattern){
        return preg_match($this->RegExp[$pattern],$subject);
    }
    public function replace($pattern, $replacement,$subject){
        return preg_replace($this->RegExp[$pattern], $replacement, $subject);
    }
    public function match_all($pattern, $subject, $matches = NULL){
        return preg_match_all($this->RegExp[$pattern], $subject, $matches);
    }
}
?>
