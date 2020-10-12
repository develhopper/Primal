<?php
namespace Primal\Node;
use Primal\Compiler;
class IfNode extends Node{
    

    public function compile(){
            switch($this->tagName){
                case "if":
                    return "<?php if({$this->args[0]}): ?>";
                case "else":
                    return "<?php else: ?>";
                case "elseif":
                    return "<?php elseif({$this->args[0]}): ?>";
                case "endif":
                    return "<?php endif; ?>";
            }
    }

}