<?php
namespace Primal\Node;
use Primal\Compiler;
use Primal\Primal;
class extendNode extends Node{
    public $options;
    public $output;
    public function compile(){
        if(!empty($this->args)){
            $this->output="<?php \r\n".
            "use Primal\Primal;\r\n".
            "\$primal_options = ['views_dir'=>'{$this->options['views_dir']}','cache_dir' => '{$this->options['cache_dir']}'];\r\n".
            "\$pml = Primal::getInstance();\r\n".
            "\$view_path = \$pml->load('{$this->args[0]}');\r\n".
            "include_once \$view_path;\r\n". 
            "?>";
            return $this;
        }else{
            die("syntax error");
        }
    }
}