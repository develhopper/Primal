<?php
namespace Nodes;
use Primal\Node\Node;

include __DIR__."/../../vendor/autoload.php";

class TestNode extends Node{
    public $multiline = false;
    public function compile(){
        return "Result from TestNode";
    }
}