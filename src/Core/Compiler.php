<?php
namespace Primal\Core;
use Primal\Node\Node;
class Compiler{
    public $src_string;
    public $out_string;
    public $options;
    public $stack=[];
    public $append=[];
    private static $INSTANCE;

    private function __construct($options){
        $this->options = $options;
    }

    public static function getInstance($options = null){
        if(!self::$INSTANCE){
            self::$INSTANCE = new Compiler($options);
        }
        return self::$INSTANCE;
    }

    public static function newInstance($options = []){
        if(self::$INSTANCE){
            return new Compiler(self::$INSTANCE->options);
        }else{
            return new Compiler($options);
        }
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
				}else{
					$this->write($line."\n");
				}
            }else{
                $this->write($line."\n");
            }
        }
        $this->append_nodes();
        $this->replace_tags();
    }

    private function append_nodes(){
        foreach($this->append as $node){
            $this->write($node->output);
        }
    }

    private function replace_tags(){
        $this->out_string=str_replace("{{","<?= ",$this->out_string);
        $this->out_string=str_replace("{%","<?php ",$this->out_string);
        $this->out_string=str_replace(["%}","}}"]," ?>",$this->out_string);
    }

    public function getNode($line){
        foreach($this->options['nodes'] as $name=>$node){
            preg_match($node['regex'],$line,$matches);
            if($matches){
                if(strpos($name,"end")===0){
                    $class=$this->pop();
                    $class->tagName=$name;
                    return $class;
                }
                $class=new $node['class']($this);
                $class->args=array_slice($matches,1);
                $class->tagName=$name;
                $class->options=$this->options;
                if(isset($node['stack']) && $node['stack'] == true)
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
