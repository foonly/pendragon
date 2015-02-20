<?php
if (!defined("ENTRY")) exit("Invalid Entry Point");

empty($_REQUEST['tab'])?$tab = "":$tab=$_REQUEST['tab'];

if (!include "include/secret.php") return true;

$data = new dataHandler($tab);

if (!empty($_POST['save'])) {
    $data->setData($_POST['tablebody']);
    $data->setHeader($_POST['header']);
    $data->setFooter($_POST['footer']);
    if (!$data->save($_POST['tablename'])) {
        echo '
            <div class="record">Something went wrong. Check server permissions.</div>
            ';
    }
}
if (!empty($_POST['delconf'])) {
    if (!$data->delete()) {
        echo '
            <div class="record">Something went wrong. Check server permissions.</div>
            ';
    }
}

$options = "";
foreach (getFiles("dat") as $f) {
    $options .= '<option value="'.$f.'"'.(($tab == $f)?' selected="selected"':'').'>'.us2uc($f).'</option>';
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

if ($data->hasFile() || $tab == "newtable") {
    if ($tab == "newtable") $tab = "";

    echo '
        <div class="edit">
            <form id="editform" action="" method="post">
                <input type="hidden" id="oldtab" name="tab" value="'.$tab.'"/>
                <input type="hidden" name="delconf" value=""/>
                <input type="text" id="name" name="tablename" value="'.us2uc($tab).'" placeholder="Table Name"/>
                <textarea id="body" name="tablebody" cols="80" rows="18">'.$data->getData().'</textarea>
                <input type="text" id="header" name="header" value="'.htmlentities($data->getHeader()).'" placeholder="Header"/><br/>
                <input type="text" id="footer" name="footer" value="'.htmlentities($data->getFooter()).'" placeholder="Footer"/><br/>
                <div id="message"></div>
                <input type="submit" name="save" value="Save"/>
                <input type="submit" name="save" value="Save &amp; Preview"/>
                <input type="button" id="del" name="del" value="Delete Table"/>
            </form>
        </div>
        ';

    if (!empty($_POST['save']) && $_POST['save'] != "Save") {
        $parser->populate($data->getdata(),$tab);

        while ($inc = $parser->popInclude()) {
            if (!$parser->isLoaded($inc)) {
                $newData = new dataHandler($inc);
                if ($newData->hasFile()) {
                    $parser->populate($newData->getdata());
                }
            }
        }
        if ($data->hasHeader()) {
            echo '
                <div class="header">
                    '.nl2br($data->getHeader()).'
                </div>
                ';
        }

        echo '
            <div class="record">
                '.nl2br($parser->generate()).'
            </div>
            ';

        if ($data->hasFooter()) {
            echo '
                <div class="footer">
                    '.nl2br($data->getFooter()).'
                </div>
                ';
        }
    }

}
