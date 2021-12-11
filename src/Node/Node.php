<?php
namespace Primal\Node;

class Node{
    private $args=[];
    public $tagName=null;
    public $childs_count=0;
    public $multiline = true;

    public static $temp;

    public function __construct($action_name){
        $this->tagName=$action_name;
    }

    public function compile(){

    }

    public static function strHash(string $str){
        return $str."_".substr(md5($str),0,4);
    }
    
}
