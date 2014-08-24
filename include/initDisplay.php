<?php
if (!defined("ENTRY")) exit("Invalid Entry Point");

require "init.php";

$html = file_get_contents("header/header.html");
$html = str_replace("#base#",RPATH,$html);
$html = str_replace("#title#",TITLE,$html);
$html = str_replace("#header#",HEADER,$html);
$html = str_replace("#footer#",FOOTER,$html);
