<?php
define("ENTRY","index");

require "include/initDisplay.php";

if (ctype_alnum($_REQUEST['template']) && file_exists(APATH."/templates/{$_REQUEST['template']}.php")) {
    $template = $_REQUEST['template'];
} else {
    $template = "main";
}


$output = "";
if (file_exists(getcwd()."/templates/{$template}.php")) {
    ob_start();
    include "templates/{$template}.php";
    $output = ob_get_clean();
}

$html = str_replace("#page#",$output,$html);
echo $html;
