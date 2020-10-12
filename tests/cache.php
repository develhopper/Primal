<?php
require_once __DIR__.'/../vendor/autoload.php';
include_once __DIR__.'/config.php';
use Primal\Core\Cache;

$cache=new Cache(__DIR__."/views",__DIR__."/cache");
$cache->make();