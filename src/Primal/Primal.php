<?php
//TODO: adding syntax highlight for pml files to vscode
namespace Primal;
class Primal{

    public static function view($name,$args=[]){
        //TODO: check requested view checksum and if file has been changed so refresh cache
        $name=hash("sha1",str_replace(".","/",$name).".html").".php";
        $path=CTPATH.DIRECTORY_SEPARATOR.$name;
        if(!file_exists($path)){
            die("View Not Exists");
        }else{
            extract($args);
            include_once $path;
        }
    }

    public static function lasy($name,$args=[]){
        $filename=TPATH.DIRECTORY_SEPARATOR.$name.".html";
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
}