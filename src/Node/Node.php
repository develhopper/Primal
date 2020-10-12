<?php
namespace Primal\Node;

class Node{
    private array $args;
    public $tagName=null;
    public $childs_count=0;
    public $views_die,$cache_dir;
    public static $actions=[
        'include'=>['regex'=>"/\@include\(\'(.+)\'\)/",'class'=>\Primal\Node\Import::class],
        'extends'=>['regex'=>"/\@extends\(\'(.+)\'\)/",'class'=>\Primal\Node\extendNode::class],
        'if'=>['regex'=>"/\@if\((.+)\)/",'class'=>\Primal\Node\IfNode::class],
        'else'=>['regex'=>"/\@else/","class"=>\Primal\Node\IfNode::class],
        'elseif'=>['regex'=>"/\@elseif\((.+)\)/",'class'=>\Primal\Node\IfNode::class],
        'endif'=>['regex'=>"/\@endif/",'class'=>\Primal\Node\IfNode::class],
        'for'=>['regex'=>"/\@for\((.+)\)/",'class'=>\Primal\Node\forNode::class],
        'foreach'=>['regex'=>"/\@foreach\((.+)\)/",'class'=>\Primal\Node\forNode::class],
        'endforeach'=>['regex'=>"/\@endforeach/",'class'=>\Primal\Node\forNode::class],
        'endfor'=>['regex'=>"/\@endfor/",'class'=>\Primal\Node\forNode::class],
        'yield'=>['regex'=>"/\@yield\((.+)\)/",'class'=>\Primal\Node\YieldNode::class],
        'section'=>['regex'=>"/\@section\((.+)\)/",'class'=>\Primal\Node\sectionNode::class],
        'endsection'=>['regex'=>"/\@endsection/",'class'=>\Primal\Node\sectionNode::class],
    ];

    public static $temp;

    public function __construct($action_name){
        $this->tagName=$action_name;
    }

    public function compile(){

    }

    public static function strHash(string $str){
        return $str."_".substr(base64_encode($str),0,4);
    }
    
}