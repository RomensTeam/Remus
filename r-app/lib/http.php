<?php
class HTTP {
    public function Response($name,$value){
        header($name.': '.$value);
    }
    static public function Info(){
        echo '';
    }
}
?>
