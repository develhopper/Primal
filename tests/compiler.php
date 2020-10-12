<?php
use Primal\Primal;
use Primal\Compiler;

$start_time = microtime(true);
include __DIR__.'/../vendor/autoload.php';


$primal=Primal::getInstance([
    "views_dir"=>__DIR__."/views",
    "cache_dir"=>__DIR__."/cache"
]);

$primal->load("test.html");

$end_time = microtime(true);
$execution_time = ($end_time - $start_time);
echo " It takes ". $execution_time." seconds to execute the script\n";