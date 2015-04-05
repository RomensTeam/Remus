<?

/**
 * @return Model
 */
function M($param = NULL,$value = NULL){
    if($param != null){
        if($value != NULL){
            return Remus::Model()->{$param} = $value;
        }else{
            return Remus::Model()->{$param};
        }
    }
    return Remus::Model();
}

/**
 * @return View
 */
function V($param = NULL,$value = NULL){
    if($param != null){
        if($value != NULL){
            return Remus::View()->{$param} = $value;
        }else{
            return Remus::View()->{$param};
        }
    }
    return Remus::View();
}

/**
 * @return Controller
 */
function C($param = NULL,$value = NULL){
    if($param != null){
        if($value != NULL){
            return Remus()->{$param} = $value;
        }else{
            return Remus()->{$param};
        }
    }
    return Remus();
}