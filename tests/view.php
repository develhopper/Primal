<?php
include __DIR__.'/../vendor/autoload.php';
include __DIR__.'/nodes/TestNode.php';

use Primal\Primal;

$options = [
    "views_dir"=>__DIR__."/views",
    "cache_dir"=>__DIR__."/cache",
    "nodes" => [
        "test"=>["regex"=>"/\@test/", "class"=>Nodes\TestNode::class]
    ]
];

$primal=Primal::getInstance($options);
echo $primal->view("test.html",[
    "title"=>"Primal",
    "name"=>"dear user",
    "list"=>["number 1","number 2"]
]);
