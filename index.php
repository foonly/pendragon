<?php
define("ENTRY","index");

require "include/init.php";

$parser->populate(file_get_contents("data/warlord.dat"));
$table = nl2br($parser->generate());

$html = file_get_contents("header/header.html");
echo str_replace("#page#",$table,$html);
