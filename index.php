<?php
define("ENTRY","index");

require "include/init.php";

$template = "main";

$output = "";
if (file_exists(getcwd()."/templates/{$template}.php")) {
    ob_start();
    include "templates/{$template}.php";
    $output = ob_get_clean();
}

$html = file_get_contents("header/header.html");
echo str_replace("#page#",$output,$html);
