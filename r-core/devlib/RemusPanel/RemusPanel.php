<?php

/**
 * RemusPanel - Debug panel
 * 
 *
 * @author Romens
 */
class RemusPanel {
    
    public static $hidden = true;
    private static $lang = false;
    public  static $theme = 'RemusPanelStandartStyle';
    
    /**
     * 
     * @var RemusPanelStyleInterface
     */
    private static $themeObj = null;
    
    public static $urlPath = false;
    
    public  static $_data = array(
        'constants' => array(),
        'files' => array(),
        'var_app' => array(),
        'query' => array(),
        'log' => array()
    );

    public function __construct($theme = null){
        if(lang('remuspanel_head') != null){
            self::$lang = true;
        }
        if(!is_null($theme)){
            self::$theme = $theme;
        }
        
        self::$urlPath = _urlen(str_replace(DIR, getURL(),__DIR__._DS));
        self::$themeObj = new self::$theme();
    }
    
    public static $flag = true;
    
    public static function off() {
        self::$flag = false;
    }
    
    public static function name($key) {
        $data = lang('remuspanel_tabs_'.strtolower($key));
        if($data != NULL){
            return $data;
        }
        return $key;
    }
    

    public static function addData($name,$data) {
        if(isset(self::$_data[strtolower($name)])){
            self::$_data[strtolower($name)][] = $data;
        }
    }
    
    public static function types($yes){
        return self::$themeObj->types($yes);
    }
    
    public static function log($message, $type = 'default') {
        $text = debug_backtrace();
        $data = str_replace(DIR,'',$text[0]['file']).': '.$text[0]['line'];
        if(isset($text[1]['class'],$text[1]['function'])){
            $call = $text[1]['class'].':'.$text[1]['function'].'()';
        } else {$call = null;}
        
        if($message instanceof Exception){
            self::$_data['log'][] = array($message->getMessage(),'danger',$data,  get_class($message));
            return true;
        }
        
        self::$_data['log'][] = array($message,$type,$data,$call);
    }
    
    public static function renderPanel($head = 'RemusPanel',$subnav = 'Testing Panel') {
        if(!self::$flag){
            return null;
        }
        self::$themeObj->getStyle();
        self::$_data = self::$themeObj->prepare(self::$_data);
        
        if(self::$lang){
            $head = lang('remuspanel_head');
        }
        self::$themeObj->render(array($head,$subnav), self::$_data);
    }
}

interface RemusPanelStyleInterface {
    public function getStyle();
    public function prepare($data);
    public function render($head,$data);
}

/**
 * RemusPanelStandartStyle - simple style for RemusPanel 
 * using Bootstrap and jQuery
 * 
 */
class RemusPanelStandartStyle implements RemusPanelStyleInterface {
    
    public function prepare($data) {
        foreach ($data as $tab_name => $tab_data) {
            switch ($tab_name) {
                case 'constants': $data[$tab_name] =  self::constantsRender($tab_data); break;
                case 'files':     $data[$tab_name] =  self::filesRender($tab_data);     break;
                case 'var_app':   $data[$tab_name] =  self::varRender($tab_data);       break;
                case 'query':     $data[$tab_name] =  self::queryRender($tab_data);     break;
                case 'log':       $data[$tab_name] =  self::logRender($tab_data);       break;
            }
        }
        return $data;
    }
    
    public function render($head,$data) {
        
        if(RemusPanel::$hidden){
            $style = 'display: none;';
        }
        
        echo '<div class="container navbar-fixed-bottom"><div class="panel panel-default" id="remus_panel" style="border: 1px solid rgb(221, 221, 221);box-shadow: 0 0 3px rgb(230, 230, 230); margin-bottom:0; border-radius:0;">
            <div class="panel_head panel-heading">
            <h3  class="panel-title" style="font-size:1.5em;">'.$head[0].' <small>'.$head[1].'</small> 
                <div class="btn-group-xs pull-right">
                <span class=" btn btn-default" onclick="$(\'#remus_panel .panel-body\').toggle();">_</span>
                <span class="btn btn-default" onclick="$(\'#remus_panel\').text(\'\')">X</span>
                </div>
            </h3>
            </div>
            <div class="panel_body panel-body" style="padding:0;'.$style.'">
         '.self::renderTabs($data).self::renderArea($data).'
         </div>
         </div></div>';
        
    }
    
    public function getStyle() {
        echo '<link href="'.RemusPanel::$urlPath.'style/bootstrap.min.css" rel="stylesheet" type="text/css">';
        echo '<link href="'.RemusPanel::$urlPath.'style/panel.css" rel="stylesheet" type="text/css">';
        echo '<script src="'.RemusPanel::$urlPath.'style/jquery.min.js" type="text/javascript"></script>';
        echo '<script src="'.RemusPanel::$urlPath.'style/bootstrap.min.js" type="text/javascript"></script>';
        echo "<script>$('#remus_panel > div.panel_body > ul > li > a').click(function (e) {e.preventDefault()$(this).tab('show')})</script>";
    }

    public static function renderTabs($tabs) {
        $data = '<ul class="nav nav-tabs">';
        foreach ($tabs as $key => $value) {
            $data .= '<li><a href="#'.$key.'" data-toggle="tab" style="border-radius:0; border-top:none;">'. RemusPanel::name($key).'</a></li>';
        }
        $data .= '</ul>';
        return $data;
    }
    
    public static function renderArea($areaData) {
        $data = '<div class="tab-content" style="height:300px;overflow-y:scroll;">';
        
        foreach ($areaData as $key => $value) {
            if($key == 'log'){
                $data .= '<div class="tab-pane seduce active" id="'.$key.'">'.$value.'</div>';
            } else {
                $data .= '<div class="tab-pane" id="'.$key.'">'.$value.'</div>';
            }
        }
        
        $data .= '</div>';
        
        return $data;
    }
    
    public static function constantsRender() {
        
        $settings  = require DIR_DEFAULT.'config.php';
        
        $result = '<table class="table table-condensed"><tbody>';
        
        $data = get_user_constants();
        
        foreach ($data as $key => $value) {
            
            if(isset($settings[$key])){
                if($settings[$key] === $value){
                    $result .= '<tr class="warning"><th><abbr title="Значение по умолчанию">'.$key.'</abbr></th><td>'.  self::types($value).'</td></tr>';
                } else {
                    $result .= '<tr class="success"><th><abbr title="Измененно">'.$key.'</abbr></th><td>'.  self::types($value).'</td></tr>';
                }
            } else {
                if(substr($key, 0,4) == 'DIR_'){
                    $result .= '<tr class="active"><th><abbr title="Являются директориями приложения">'.$key.'</abbr></th><td>'.  self::types($value).'</td></tr>';
                } else {
                    $result .= '<tr><th>'.$key.'</th><td>'.  self::types($value).'</td></tr>';
                }
            }
        }
        
        $result .= '</tbody></table>';
        return $result;
    }
    
    public static function filesRender() {
        
        $data = '<table class="table table-bordered"><tbody>';
        
        $files = get_included_files();
        
        $data .= '<tr class="danger"><th>All files: '.  count($files).'</th></tr>';
        
        foreach ($files as $value) {
            $data .= '<tr><td>'.str_replace(DIR, '<abbr title="'.DIR.'"><b>DIR</b></abbr> ', $value).'</td></tr>';
        }
        
        $data .= '</tbody></table>';
        return $data;
    }
    
    public static function logRender($log) {
        $result = '<table class="table table-condensed"><tbody>';
        
        foreach ($log as $value) {
            $value[2] = '['.$value[2].']';
            switch ($value[1]) {
                case 'danger':
                case 'error':
                    $result .= '<tr class="danger">';
                    break;
                default:
                    $result .= '<tr class="'.$value[1].'">';
                    break;
            }
            $result .= '<th>'.$value[3].'</th><th>'.$value[2].'</th><td>'.$value[0].'</td></tr>';
            
        }
        $result .= '</tbody></table>';
        return $result;
    }
    
    public static function varRender() {
        $result = '<table class="table table-striped"><tbody>';
        
        foreach (Remus::Model()->var_app as $key => $value) {
            $result .= '<tr><th>'.$key.'</th><td>'.  self::types($value).'</td></tr>';
        }
        
        $result .= '</tbody></table>';
        
        return $result;
    }
    
    public static function queryRender($query) {
        $result  = '<table class="table"><thead>';
        $result .= '<tr><th>BackTrace</th><th>SQL</th><th>Result</th></tr></thead><tbody>';
        
        foreach ($query as $value) {
            $trace = '['.str_replace(DIR, 'DIR'._DS, $value['trace']['file']).':'.$value['trace']['line'].']';
            $result .= '<tr><th>'.$trace.'</th><th><code>'.$value['sql'].'</code></th><td>'.$value['result'].'</td></tr>';
        }
        
        $result .= '</tbody></table>';        unset($query);
        return $result;
    }
    public static function types($mixed) {
        if(is_string($mixed)){
            $string = trim($mixed);
            if($string === ''){$result = '(empty string)';}
            $mixed = preg_replace_callback(VIEW_TAG_PATTERN, function($match){return '<b>'.$match[0].'</b>';}, htmlspecialchars($string));
            $result = '<code>'.$mixed.'</code>';
        }
        if(is_bool($mixed)){   
            if($mixed)
                { $result = '<span class="label label-info">TRUE</span>';} 
            else 
                { $result = '<span class="label label-danger">FALSE</span>';}
        }
        if(is_numeric($mixed)){$result = '<span class="badge">'.$mixed.'</span>';}
        if(is_null($mixed)){$result = 'NULL';} 
        if(is_array($mixed)){$result = 'array <span class="label label-info">'.count($mixed).'</span>'; } else { $result = 'ERROR'; }
        return $result;
    }
}