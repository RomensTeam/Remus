<?
class HTTP {
    public function response($name,$value){
        header($name.': '.$value);
    }
}
?>
