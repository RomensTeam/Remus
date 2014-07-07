<?
function M($param = NULL,$value = NULL){
    if($param != null){
        if($value != NULL){
            return Controller::Model()->{$param} = $value;
        }else{
            return Controller::Model()->{$param};
        }
    }
    return Controller::Model();
}