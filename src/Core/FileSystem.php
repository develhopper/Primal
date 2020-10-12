<?php
namespace Primal\Core;

class FileSystem{

    public static function read($path){
        if(file_exists($path)){
            return file_get_contents($path);
        }
    }

    public static function write($path,$content){
        if(self::isWritable($path)){
            file_put_contents($path,$content);
        }
    }

    public static function isWritable($path){
        if(file_exists($path)){
            return is_writable($path);
        }else{
            return is_writable(dirname($path));
        }
    }

    public function md5check($path,$md5){
        if(!file_exists($path)||is_null($md5))
            return false;
        return md5_file($path)==$md5;
    }
}