<?php
namespace Primal;

class Cache{
    private static $allfiles=[];
    private static $md5list=CTPATH.DIRECTORY_SEPARATOR."cache.json";
    
    public static function make(){
        self::$allfiles=json_decode(file_get_contents(self::$md5list),true);
        
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
    private static function crawl($path){
        $list=scandir($path);
        $list=array_diff($list,['.','..']);

        $pattern="/(?<=".str_replace("/","\\/",TPATH).").*/";
        preg_match($pattern,$path,$basename);
        
        foreach($list as $item){
            $itemname=ltrim("$basename[0]/$item",'/');
            $item="$path/$item";
            
            if(is_dir($item)){
                self::crawl($item);
            }else{
                if(!self::check_checksum($item,$itemname)){
                    echo "$item \n";
                    self::save($item,$itemname);
                }
            }
        }
    }

    private static function save($path,$name){
        $dst=CTPATH.DIRECTORY_SEPARATOR.hash("sha1",$name).".php";
        $str=self::replace(self::read($path));
        var_dump($dst);
        self::write($dst,$str);
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

    private static function read($path){
        return file_get_contents($path);
    }

    private static function replace($str){
        $str=preg_replace_callback("/(?<=\\{\\%).+(?=\\%\\})/",function($matches){
                $matches[0]="$".trim($matches[0]);
            return $matches[0];
        },$str);
        $str=str_replace("{%","<?= ",$str);
        $str=str_replace("{{","<?php ",$str);
        $str=str_replace(["%}","}}"]," ?>",$str);
        return $str;
    }

    private static function write($dst,$str){
        file_put_contents($dst,$str);
    }

    private static function clean(){
        //TODO: clean cache
    }
}