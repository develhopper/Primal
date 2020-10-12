<?php
namespace Primal\Node;
use Primal\Compiler;
use Primal\Primal;
class extendNode extends Node{
    public $views_die,$cache_dir;
    public $output;
    public function compile(){
        if(!empty($this->args)){
            $pml=Primal::getInstance(["views_dir"=>$this->views_dir,"cache_dir"=>$this->cache_dir]);
            $filename=$pml->load($this->args[0]);
            $this->output="<?php include_once '$filename'; ?>";
            return $this;
        }else{
            die("syntax error");
        }
    }
}