<?php
namespace Primal;
class Primal{

    public static function view($name,$args=[]){
        //TODO: Loading from cache if available
        // - adding syntax highlight for pml files to vscode
        $filename=TPATH.$name.".html";
        $str=self::read($filename);
        eval("?>".self::attach($str,$args));
    }

    private static function read($path){
        $f=fopen($path,"r") or die("$path not found");
        $r=fread($f,filesize($path));
        fclose($f);
        return $r;
    }
    private static function attach($str,$args=[]){
        foreach($args as $key=>$value)
            $str=preg_replace("/\\{\\%\\s*$key\\s*\\%\\}/",$value,$str);
        $str=str_replace("{{","<?php ",$str);
        $str=str_replace("}}","?>",$str);
        return $str;
    }

    private static function represent($str,$args=[]){
        //TODO: showing view from cache here
    }
}