<?php
if (!defined("ENTRY")) exit("Invalid Entry Point");

$saved = false;

if (!empty($_POST['delconf'])) { // Delete table
    if (!empty($_POST['tab'])) unlink(APATH."/data/{$_POST['tab']}.dat"); // But only if not empty.
    $tab = "";
    return true; // Exit the template.
}

$tablename = strtolower(str_replace(" ","_",$_POST['tablename']));
$tablename = preg_replace('/[^a-z0-9_-]/','',$tablename);
if (!empty($tablename) && file_put_contents(APATH."/data/{$tablename}.dat",$_POST['tablebody'])) {
    $saved = true;
    if ($tablename != $_POST['tab']) { // Name changed, delete old table
        if (!empty($_POST['tab'])) unlink(APATH."/data/{$_POST['tab']}.dat"); // But only if not empty.
        $tab = $tablename; // Display new table
    }
}

