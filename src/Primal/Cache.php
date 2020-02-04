<?php
namespace Primal;

class Cache{
    public static function make(){
        self::crawl(TPATH);
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
                self::save($item,$itemname);
                echo hash("sha1",$itemname).".php\n";
            }
        }
    }

    private static function save($path,$name){
        $dst=CTPATH.DIRECTORY_SEPARATOR.hash("sha1",$name).".php";
        $str=self::replace(self::read($path));
        self::write($dst,$str);
    }

    private static function read($path){
        $f=fopen($path,"r");
        $r=fread($f,filesize($path));
        fclose($f);
        return $r;
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