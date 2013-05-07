<?php
/**
 * RegExp - библиотека регулярных выражений
 * 
 * @category Library
 * @package RomensEngineStandartLibrary
 * @version 1.0
 * @author Roman Trutnev <romantrutnev@gmail.com>
 */
class RegExp {
    public $regexp = array(
        'email'=>'/^([0-9a-zA-Z]([-.w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-w]*[0-9a-zA-Z].)+[a-zA-Z]{2,9})$/si', // Email. Example: <i@phpmaster.com>
        'time'=>'/^([0-1][0-9]|[2][0-3]):([0-5][0-9])$/si', // Time. Example: <24:03>
        'full_domen_name'=>'/^(http|https|ftp)://([A-Z0-9][A-Z0-9_-]*(?:.[A-Z0-9][A-Z0-9_-]*)+):?(d+)?/?/i' // Full Domen Name. Example: <http://romens.ru/>
    );
    
    public function check($subject,$pattern){
        return preg_match($this->regexp[$pattern],$subject);
    }
    public function replace($pattern, $replacement,$subject){
        return preg_replace($this->regexp[$pattern], $replacement, $subject);
    }
    public function match_all($pattern, $subject, $matches = NULL){
        return preg_match_all($this->regexp[$pattern], $subject, $matches);
    }
}
?>
