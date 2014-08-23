<?php
if (!defined("ENTRY")) exit("Invalid Entry Point");

header ("Content-Type: text/html; charset=UTF-8");

define("APATH",getcwd());

require "randomtable/randomtable.class.php";

$parser = new randomTable();
