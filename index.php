<?php
define("ENTRY","index");

require "include/initDisplay.php";

if (!empty($_REQUEST['template']) && ctype_alnum($_REQUEST['template']) && file_exists(APATH."/templates/{$_REQUEST['template']}.php")) {
    $template = $_REQUEST['template'];
} else {
    $template = "main";
}


$output = "";
if (file_exists(getcwd()."/templates/{$template}.php")) {
    ob_start();
    if (include "templates/{$template}.php") {
        $output = ob_get_clean();
    } else {
        exit();
    }
}

$html = str_replace("#page#",$output,$html);
echo $html;
