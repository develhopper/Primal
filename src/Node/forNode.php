<?php
namespace Primal\Node;

class forNode extends Node{
    
    public function compile(){
        switch($this->tagName){
            case "for":
                return "<?php for({$this->args[0]}): ?>";
            case "foreach":
                return "<?php foreach({$this->args[0]}): ?>";
            case "endforeach":
                return "<?php endforeach; ?>";
            default:
                return "<?php endfor; ?>";
        }
    }
}