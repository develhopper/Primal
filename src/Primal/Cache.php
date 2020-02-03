<?php
namespace Primal;

class Cache{
    public static function all(){
        //TODO: make cache from all files in directory
        // save cached files by hash code
        $test=TPATH."test.html";
        $dst=CTPATH."/test.php";
        $str=self::read($test);
        self::write($dst,self::replace($str));
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