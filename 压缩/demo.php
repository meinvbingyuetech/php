<?php
include("zip.php");
$ziper = new zipfile();
$ziper->addFiles(array("1.html","file.png"));  //array of files
$ziper->output("myzip.zip");
?>

