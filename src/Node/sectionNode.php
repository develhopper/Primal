<?php
namespace Primal\Node;

class sectionNode extends Node{
    
    public function compile(){
        $arg=Node::strHash(trim($this->args[0],"'"));
        switch($this->tagName){
            case "section":
                return "<?php ob_start(); ?>";
            case "endsection":
                return "<?php \$$arg=ob_get_contents();ob_end_clean(); ?>";
        }
    }
}