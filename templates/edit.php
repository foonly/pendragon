<?php
if (!defined("ENTRY")) exit("Invalid Entry Point");

empty($_REQUEST['tab'])?$tab = "":$tab=$_REQUEST['tab'];

if (!include "include/secret.php") return false;

// This will be my dirty little secret, but it would be silly to create a framework for saving one file.
if (!empty($_POST['save']) || !empty($_POST['delconf'])) {
    include "include/savetable.php";
}

$files = scandir(APATH."/data/");
$options = "";
foreach ($files as $file) {
    if (substr($file,0,1) != ".") {
        $f = substr($file,0,strpos($file,"."));
        $options .= '<option value="'.$f.'"'.(($tab == $f)?' selected="selected"':'').'>'.us2uc($f).'</option>';
    }
}

echo '
    <script src="header/edit.js"></script>
    <div class="form">
        <form id="selector" action="" method="get">
            Table:
            <select id="tab" name="tab">
                <option value="">Choose Table</option>
                <option value="newtable">New Table</option>
                <option value="">------------</option>
                '.$options.'
            </select>
            <input type="submit" id="editbutton" value="Edit"/>
        </form>
    </div>
    ';

if (file_exists(APATH."/data/{$tab}.dat") || $tab == "newtable") {
    if ($tab == "newtable") $tab = "";
    if (empty($tab)) $data = ""; else $data = file_get_contents(APATH."/data/{$tab}.dat");
    echo '
        <div class="edit">
            <form id="editform" action="" method="post">
                <input type="hidden" id="oldtab" name="tab" value="'.$tab.'"/>
                <input type="hidden" name="delconf" value=""/>
                <input type="text" id="name" name="tablename" value="'.us2uc($tab).'" placeholder="Table Name"/>
                <textarea id="body" name="tablebody" cols="80" rows="18">'.$data.'</textarea>
                <div id="message"></div>
                <input type="submit" name="save" value="Save"/>
                <input type="submit" name="save" value="Save &amp; Preview"/>
                <input type="button" id="del" name="del" value="Delete Table"/>
            </form>
        </div>
        ';

    if (!empty($_POST['save']) && $_POST['save'] != "Save") {
        $parser->populate($data,$tab);

        while ($inc = $parser->popInclude()) {
            if (!$parser->isLoaded($inc) && file_exists(APATH."/data/{$inc}.dat")) {
                $data = file_get_contents(APATH."/data/{$inc}.dat");
                $parser->populate($data);
            }
        }
        echo '
            <div class="record">
                '.nl2br($parser->generate()).'
            </div>
            ';
    }

}
