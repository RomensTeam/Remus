<?
$path = DIR_APP_LANG.APP_LANG_PREFIX.$lang.'.'.APP_LANG_EXT;
if(is_file($path)){
    $this->app_lang = $this->open_json($path);
}

if($library <> FALSE){
    if(is_string($library)){
        $library = explode(',', $library);
    }
    foreach ($library as $lib){
        $path = DIR_APP_LANG.$lang._DS.APP_LANG_PREFIX.$lib.'.'.APP_LANG_EXT;
        if(is_file($path)){
            $app_lang = $this->open_json($path);
            $this->app_lang = array_merge($this->app_lang,$app_lang);
        }
    }
}