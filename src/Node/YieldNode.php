<?php
namespace Primal\Node;

class YieldNode extends Node{
    public $multiline = false;
    public function compile(){
        $arg=Node::strHash(trim($this->args[0],"'"));
		$output="<?php if(isset(\$$arg)): ?>";
		$output.="<?= \$$arg ?>";
		$output.="<?php endif; ?>";
        return $output;
    }
}
