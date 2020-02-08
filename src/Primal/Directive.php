<?php
namespace Primal;

class Directive{
    public $content;
    public function run($directives=[],$content){
        $this->content=$content;
        foreach($directives as $item){
            $this->scavenge($item);
        }
    }

    private function extends($name){
        $name=TPATH.DIRECTORY_SEPARATOR.str_replace(".","/",$name).".html";
        return file_get_contents($name);
    }

    private function holder($name){
        return "@holder('$name')";
    }

    private function section($name,$body){
        $this->content=str_replace("@holder('$name')",$body,$this->content);
        return "";
    }

    private function scavenge($item){
        preg_match_all("((?<=\@)\w+|(?<=\(\').+(?=\')|(?<=\{)[\w\W]*(?=\}))",$item,$matches);
        $matches=$matches[0];
            $fun_name=$matches[0];
            if(!method_exists($this,$fun_name))
                die("$fun_name directive does not exists");

            $args=array_slice($matches,1);
            $out=call_user_func_array([$this,$fun_name],$args);
            $this->content=str_replace($item,$out,$this->content);
    }
}