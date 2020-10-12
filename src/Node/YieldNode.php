<?php
namespace Primal\Node;

class YieldNode extends Node{

    public function compile(){
        $arg=Node::strHash(trim($this->args[0],"'"));
        $output="<?= \$$arg ?>";;
        return $output;
    }
}