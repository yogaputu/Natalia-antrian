<?php
$imagick = new Imagick();

$imagick->readImage(__DIR__ .'/sep/sep.pdf');

$imagick->writeImages(__DIR__ .'/sep/sep.png', true);
header("location:cetaksep.php");
