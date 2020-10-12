<?php
include __DIR__.'/../vendor/autoload.php';
include_once __DIR__.'/config.php';
 use Primal\Primal;
 $primal=Primal::getInstance(["views_dir"=>__DIR__."/views","cache_dir"=>__DIR__."/cache"]);
$primal->view("test.html",[
    "title"=>"Primal",
    "name"=>"dear user",
    "list"=>["number 1","number 2"]
]);
