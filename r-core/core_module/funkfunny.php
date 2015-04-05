<?
/**
 * @return Model
 */
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
/**
 * @return View
 */
function V($param = NULL,$value = NULL){
    if($param != null){
        if($value != NULL){
            return Controller::View()->{$param} = $value;
        }else{
            return Controller::View()->{$param};
        }
    }
    return Controller::View();
}

/**
 * @return Controller
 */
function С($param = NULL,$value = NULL){
    if($param != null){
        if($value != NULL){
            return Controller::Controller()->{$param} = $value;
        }else{
            return Controller::Controller()->{$param};
        }
    }
    return Controller::Controller();
}

function pattern($name, $block = false) {
    if($block){
        $name = 'block_'.$name;
    }
    return M()->pattern($name);
}