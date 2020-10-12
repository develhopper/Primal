<?php
namespace Primal\Node;
use Primal\Compiler;
use Primal\Primal;
class Import extends Node{
    public $views_die,$cache_dir;
    public function compile(){
        if(!empty($this->args)){
            $pml=Primal::getInstance(["views_dir"=>$this->views_dir,"cache_dir"=>$this->cache_dir]);
            $filename=$pml->load($this->args[0]);
            return "<?php include_once '$filename'; ?>";
        }else{
            die("syntax error");
        }
    }
}