<?php
namespace Primal\Core;

class Cache{
    private $allfiles;
    private $md5list;
    private $compiler;
    private $cache_dir,$views_dir;

    public function __construct($views_dir,$cache_dir){
        $this->views_dir=$views_dir;
        $this->cache_dir=$cache_dir;
        $this->md5list=$this->cache_dir."/cache.json";
    }

    public function make(){
        $this->allfiles=$this->cacheList();
        $this->compiler=new Compiler();
        $this->compiler->views_dir=$this->views_dir;
        $this->compiler->cache_dir=$this->cache_dir;
        $this->crawl($this->views_dir);
        $this->updatemd5list();
    }

    public function checkview($name){
        $path=$this->views_dir.DIRECTORY_SEPARATOR.$name;
        $this->allfiles=$this->cacheList();
        if(!FileSystem::md5check($path,$this->getCheckSum($name))){
            $this->compiler=new Compiler();
            $this->compiler->views_dir=$this->views_dir;
            $this->compiler->cache_dir=$this->cache_dir;
            $this->compiler->compile(FileSystem::read($path));
            $this->save($path,$name);
            $this->updatemd5list();
        }
        return $this->getPath($name);
    }
    private function updatemd5list(){
        FileSystem::write($this->md5list,
        json_encode($this->allfiles,JSON_PRETTY_PRINT));
    }

    private function crawl($dir){
        $list=scandir($dir);
        $list=array_diff($list,['.','..']);
        $basename=explode($this->views_dir,$dir)[1];
        foreach($list as $item){
            $path="$dir/$item";
            $name="$basename/$item";
            if(is_dir($path)){
                $this->crawl($path);
            }elseif(!FileSystem::md5check($path,$this->getCheckSum($name))){
                    echo "$item \n";
                    $this->compiler->compile(FileSystem::read($path));
                    $this->save($path,$name);
            }
        }
    }

    private function save($path,$name){
        $file=$this->cache_dir.DIRECTORY_SEPARATOR.hash("sha1",$name).".php";
        FileSystem::write($file,$this->compiler->out_string);
        $this->setCheckSum($path,$name);
    }

    private function setCheckSum($path,$name){
        $sum=md5_file($path);
        $this->allfiles[$name]=$sum;
    }

    private function getCheckSum($name){
        if(isset($this->allfiles[$name])){
            return $this->allfiles[$name];
        }
        return null;
    }

    private static function clean(){
        //TODO: clean cache
    }

    public function cacheList(){
        $result=FileSystem::read($this->md5list);
        return (is_null($result))?[]:json_decode($result,true);
    }

    public function getPath($name){
        return $this->cache_dir.DIRECTORY_SEPARATOR.hash("sha1",$name).".php";
    }
}