<?php

return [
    'include' => ['regex' => "/\@include\(\'(.+)\'\)/", 'class' => \Primal\Node\Import::class],
    'extends' => ['regex' => "/\@extends\(\'(.+)\'\)/", 'class' => \Primal\Node\extendNode::class],
    'if' => ['regex' => "/\@if\((.+)\)/", 'class' => \Primal\Node\IfNode::class, "stack" => true],
    'elseif' => ['regex' => "/\@elseif\((.+)\)/", 'class' => \Primal\Node\IfNode::class],
    'else' => ['regex' => "/\@else/", "class" => \Primal\Node\IfNode::class],
    'endif' => ['regex' => "/\@endif/", 'class' => \Primal\Node\IfNode::class],
    'for' => ['regex' => "/\@for\((.+)\)/", 'class' => \Primal\Node\forNode::class,"stack"=>true],
    'foreach' => ['regex' => "/\@foreach\((.+)\)/", 'class' => \Primal\Node\forNode::class,"stack"=>true],
    'endforeach' => ['regex' => "/\@endforeach/", 'class' => \Primal\Node\forNode::class],
    'endfor' => ['regex' => "/\@endfor/", 'class' => \Primal\Node\forNode::class],
    'yield' => ['regex' => "/\@yield\((.+)\)/", 'class' => \Primal\Node\YieldNode::class],
    'section' => ['regex' => "/\@section\((.+)\)/", 'class' => \Primal\Node\sectionNode::class,"stack"=>true],
    'endsection' => ['regex' => "/\@endsection/", 'class' => \Primal\Node\sectionNode::class],
];
