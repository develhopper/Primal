<?php
//TODO: adding syntax highlight for pml files to vscode
namespace Primal;
use Primal\Core\Compiler;
use Primal\Core\FileSystem;
use Primal\Core\Cache;

class Primal{

    private $compiler;
    private $cache;
    private static $pml=null;
    private $options;
    
    private function __construct($options){
        $this->compiler = Compiler::getInstance($options);
        $this->options = $options;
    }

    public function __set($key,$value){
        $this->$key=$value;
    }

    public function initCache(){
        $this->cache=Cache::getInstance($this->options);
    }

    public static function getInstance(array $options=[]){
        if(self::$pml==null){
            self::$pml=new Primal($options);
        }
        foreach($options as $key=>$value){
            self::$pml->$key=$value;
        }
        self::$pml->initCache();
        return self::$pml;
    }

    public function load($view){
        return $this->cache->get_view($view);
    }

    public function view($name,array $args=[]){
        $path=$this->load($name);
        extract($args);
		ob_start();
        include $path;
		$content = ob_get_clean();
		return $content;
    } 
}
