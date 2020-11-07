<?php
namespace Primal\Core;
use Primal\Node\Node;
class Compiler{
    public $src_string;
    public $out_string;
    public $views_dir,$cache_dir;
    public $stack=[];
    public $append=[];
    public function __construct(){

    }

    public function compile($src_string){
        $this->src_string=$src_string;
        $split=explode("\n",$src_string);
        for($i=0;$i<count($split);$i++){
            $line=$split[$i];

            if(empty($line)){
                $this->write("\n");
                continue;
            }
            else if(strpos($line,"@")!==FALSE){
                $node=$this->getNode($line);
                if($node){
                    $output=$node->compile();
                    if(is_object($output)){
                        array_push($this->append,$output);
                    }else
                        $this->write($output."\n");
                }else
					$this->write($line."\n");
            }else{
                $this->write($line."\n");
            }
        }
        $this->doAppends();
        $this->replaceTags();
    }

    private function doAppends(){
        foreach($this->append as $node){
            $this->write($node->output);
        }
    }

    private function replaceTags(){
        $this->out_string=str_replace("{{","<?= ",$this->out_string);
        $this->out_string=str_replace("{%","<?php ",$this->out_string);
        $this->out_string=str_replace(["%}","}}"]," ?>",$this->out_string);
    }

    public function getNode($line){
        foreach(Node::$actions as $name=>$action){
            preg_match($action['regex'],$line,$matches);
            if($matches){
                if(strpos($name,"end")===0){
                    $class=$this->pop();
                    $class->tagName=$name;
                    return $class;
                }
                $class=new $action['class']($this);
                $class->args=array_slice($matches,1);
                $class->tagName=$name;
                $class->views_dir=$this->views_dir;
                $class->cache_dir=$this->cache_dir;
                $this->push($class);
                return $class;
            }
        }
    }


    private function push($node){
        array_push($this->stack,$node);
    }

    private function pop(){
        return array_pop($this->stack);
    }

    public function write($str){
        $this->out_string.=$str;
        return $this;
    }
    
}
