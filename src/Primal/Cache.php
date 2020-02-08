<?php
namespace Primal;

class Cache{
    private static $allfiles=[];
    private static $md5list=CTPATH.DIRECTORY_SEPARATOR."cache.json";
    private static $compiler;
    public static function make(){
        self::$allfiles=json_decode(file_get_contents(self::$md5list),true);
        self::$compiler=new Compiler();
        self::crawl(TPATH);
        self::updatemd5list();
    }

    public static function checkview($name){
        $path=TPATH.DIRECTORY_SEPARATOR.$name;
        self::$allfiles=json_decode(file_get_contents(self::$md5list),true);
        if(!self::check_checksum($path,$name)){
            self::save($path,$name);
            self::updatemd5list();
        }
    }
    private static function updatemd5list(){
        file_put_contents(self::$md5list,
        json_encode(self::$allfiles,JSON_PRETTY_PRINT));
    }

    private static function crawl($dir){
        $list=scandir($dir);
        $list=array_diff($list,['.','..']);

        // $pattern="/(?<=".str_replace("/","\\/",TPATH).").*/";
        // preg_match($pattern,$dir,$basename);
        $basename=explode(TPATH,$dir)[1];

        foreach($list as $item){
            $name=ltrim("$basename/$item",'/');
            $path="$dir/$item";
            if(is_dir($path)){
                self::crawl($path);
            }else{
                if(!self::check_checksum($path,$name)){
                    echo "$item \n";
                    self::$compiler->compile($path);
                    self::save($path,$name);
                }
            }
        }
    }

    private static function save($path,$name){
        $file=CTPATH.DIRECTORY_SEPARATOR.hash("sha1",$name).".php";
        file_put_contents($file,self::$compiler->output);
        self::checksum($path,$name);
    }

    private static function checksum($path,$name){
        $sum=md5_file($path);
        self::$allfiles[$name]=$sum;
    }

    private static function check_checksum($path,$name){
        if(isset(self::$allfiles[$name])){
            $sum=md5_file($path);
            return self::$allfiles[$name]==$sum;
        }
    }

    private static function clean(){
        //TODO: clean cache
    }
}