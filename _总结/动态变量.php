<?php

$w1 = '1';
$w2 = '2';
$i = 1;
echo ${'w'.$i};


$control = new control();
$method = 'on'.$_GET['act'];
$control->$method();