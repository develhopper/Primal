<?php
namespace Primal;

class Compiler{
    private $content;
    private $directive;
    public $output;

    public function __construct()
    {
        $this->directive=new Directive();
    }

    public function compile($path){
        $this->content=file_get_contents($path);
        $this->setdirective();
        $this->replace();
    }

    private function replace(){
        $content=preg_replace_callback("/(?<=\{\{).+(?=\}\})/",function($matches){
            $matches[0]="$".trim($matches[0]);
        return $matches[0];
    },$this->content);
    $content=str_replace("{{","<?= ",$content);
    $content=str_replace("{%","<?php ",$content);
    $this->output=str_replace(["%}","}}"]," ?>",$content);
    }

    public function setdirective(){
        preg_match_all("/\@\w+\(.+\)(\{([\S\s]*?)\})*/",$this->content,$directives);
        // var_dump($directives[0]);
        $this->directive->run($directives[0],$this->content);
        $this->content=$this->directive->content;
    }
    
}