<?php

use Primal\Compiler;

include __DIR__.'/../vendor/autoload.php';
include_once __DIR__.'/config.php';
$path=__DIR__."/views/test.html";
$compiler=new Compiler();
$compiler->compile($path);

var_dump($compiler->output);