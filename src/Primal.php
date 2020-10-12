<?php
//TODO: adding syntax highlight for pml files to vscode
namespace Primal;
use Primal\Core\Compiler;
use Primal\Core\FileSystem;
use Primal\Core\Cache;

class Primal{

    private $views_dir;
    private $cache_dir;
    private $compiler;
    private $cache;
    private static $pml=null;
    
    private function __construct(){}

    public function __set($key,$value){
        $this->$key=$value;
    }

    public function initCache(){
        $this->cache=new Cache($this->views_dir,$this->cache_dir);
    }

    public static function getInstance(array $options=[]){
        if(self::$pml==null){
            self::$pml=new Primal();
        }
        foreach($options as $key=>$value){
            self::$pml->$key=$value;
        }
        self::$pml->initCache();
        return self::$pml;
    }

    public function load($view){
        return $this->cache->checkview($view);
    }

    public function view($name,array $args=[]){
        $path=$this->load($name);
        extract($args);
        include $path;
    } 
}