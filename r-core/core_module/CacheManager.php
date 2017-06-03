<?php

class CacheManager
{
    private $mode = null;
    private $time = null;
    private $lastCacheFile = null;

    public function __construct($mode = 'data', $time = 300)
    {
        $this->mode = $mode;
        $this->time = $time;
    }

    public function get($tagName = NULL){
        if(is_null($tagName))
            $tagName = $this->lastCacheFile;
        $path = $this->getPath($tagName);

        return $this->getData($path);
    }

    private function getData($path)
    {
        $data = file_get_contents($path);
        if($this->mode === 'data')
            return json_decode($data,true);
        return $data;
    }

    public function set($tagName = NULL, $data){
        if(is_null($tagName))
            $tagName = $this->lastCacheFile;

        RemusPanel::log($this->getPath($tagName));
        RemusPanel::log($data);
        $file = fopen($this->getPath($tagName), "w");

        if($this->mode === 'data')
            $data = json_encode($data);
        fputs($file, $data);
        fclose($file);
    }

    private function getPath($tagName){
        return DIR_CACHE.$this->mode._DS.$tagName.'.cache';
    }

    public function check($tagName)
    {
        $cacheFile = $this->getPath($tagName);
        $this->lastCacheFile = $cacheFile;
        if(file_exists($cacheFile)){
            RemusPanel::log(date('H:i:s',TIME_START).' = Время скрипта');
            RemusPanel::log(date('H:i:s',filemtime($cacheFile)).' = Время файла');
            RemusPanel::log(date('H:i:s',(filemtime($cacheFile)+$this->time)).' = Время истечения срока файла');
            if($this->mode === 'layout'){
                return TIME_START < filemtime($cacheFile);
            } else {
                return TIME_START < (filemtime($cacheFile)+$this->time);
            }
        }
        return false;
    }
}