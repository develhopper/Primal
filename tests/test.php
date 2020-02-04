<?php
include __DIR__.'/../vendor/autoload.php';
include_once __DIR__.'/config.php';
 use Primal\Primal;
Primal::view("test",[
    "title"=>"Far Cry: Primal",
    "name"=>"Takkar"
]);
// use Primal\Cache;
// Cache::make();