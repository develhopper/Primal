<?php

return [
    'include' => ['regex' => "/\@include\(\'(.+)\'\)/", 'class' => \Primal\Node\Import::class],
    'extends' => ['regex' => "/\@extends\(\'(.+)\'\)/", 'class' => \Primal\Node\extendNode::class],
    'if' => ['regex' => "/\@if\((.+)\)/", 'class' => \Primal\Node\IfNode::class],
    'elseif' => ['regex' => "/\@elseif\((.+)\)/", 'class' => \Primal\Node\IfNode::class],
    'else' => ['regex' => "/\@else/", "class" => \Primal\Node\IfNode::class],
    'endif' => ['regex' => "/\@endif/", 'class' => \Primal\Node\IfNode::class],
    'for' => ['regex' => "/\@for\((.+)\)/", 'class' => \Primal\Node\forNode::class],
    'foreach' => ['regex' => "/\@foreach\((.+)\)/", 'class' => \Primal\Node\forNode::class],
    'endforeach' => ['regex' => "/\@endforeach/", 'class' => \Primal\Node\forNode::class],
    'endfor' => ['regex' => "/\@endfor/", 'class' => \Primal\Node\forNode::class],
    'yield' => ['regex' => "/\@yield\((.+)\)/", 'class' => \Primal\Node\YieldNode::class],
    'section' => ['regex' => "/\@section\((.+)\)/", 'class' => \Primal\Node\sectionNode::class],
    'endsection' => ['regex' => "/\@endsection/", 'class' => \Primal\Node\sectionNode::class],
];
