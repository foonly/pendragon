<?php
if (!defined("ENTRY")) exit("Invalid Entry Point");

header ("Content-Type: text/html; charset=UTF-8");

require "settings.php";
require "randomtable/randomtable.class.php";

$parser = new randomTable();

/*
 * Functions
 */

function us2uc ($text) { // Again bad practice, move this if this project gets more functions.
    return ucwords(str_replace("_"," ",$text));
}

function getFiles($ext=null,$path="/data/") {
    $return = array();
    $len = strlen($ext) + 1;
    foreach (scandir(APATH.$path) as $file) {
        if ($file != "." && $file != "..") {
            if (empty($ext)) {
                $return[] = $file;
            } elseif (substr($file,0-$len,$len) == '.'.$ext) {
                $return[] = substr($file,0,0-$len);
            }
        }
    }
    return $return;
}