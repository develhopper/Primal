<?php
namespace Primal\Core;

use Primal\Primal;

class Cache{
    private $allfiles;
    private $md5list;
    private $compiler;
    private $options;
    private static $INSTANCE;

    public function __construct($options){
        $this->options = $options;
        $this->md5list=$this->options['cache_dir']."/cache.json";
    }

    public static function getInstance($options=[]){
        if(!self::$INSTANCE){
            self::$INSTANCE = new Cache($options);
        }
        return self::$INSTANCE;
    }

    public function make(){
        Primal::getInstance($this->options);
        $this->allfiles=$this->cacheList();
        $this->compiler=Compiler::getInstance($this->options);
        $this->crawl($this->options['views_dir']);
        $this->updatemd5list();
    }

    public function get_view($name){
        $path=$this->options['views_dir'].'/'.$name;
        $this->allfiles=$this->cacheList();
        if(!FileSystem::md5check($path,$this->getCheckSum($name))){
            $this->compiler=Compiler::newInstance();
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

    // not working properly
    private function crawl($dir){
        $list=scandir($dir);
        $list=array_diff($list,['.','..']);
        $basename=explode($this->options['views_dir'],$dir)[1];
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
        $file=$this->options['cache_dir'].'/'.hash("sha1",$name).".php";
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
        return $this->options['cache_dir'].'/'.hash("sha1",$name).".php";
    }
}