<?php 
include __DIR__.'/../../../vendor/autoload.php';
$file = ['./2.jpg','./3.jpg','./4.jpg','./5.jpg','./6.jpg','./7.jpg','./8.jpg'];

$pic = new RainSunshineCloud\picSearch('./1.jpg');

$res = $pic->in($file);