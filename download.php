<?php
header("Content-type:application/test");

$downloadfile = $_GET["file"];
$fileproper = substr($downloadfile,8,50);

// It will be called downloaded.pdf
header("Content-Disposition:attachment;filename=$fileproper");

// The PDF source is in original.pdf
readfile($downloadfile);
?>
