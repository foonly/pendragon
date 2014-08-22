<?php
if (!defined("ENTRY")) exit("Invalid Entry Point");

empty($_REQUEST['tab'])?$tab = "":$tab=$_REQUEST['tab'];

$files = scandir(APATH."/data/");
$options = "";
foreach ($files as $file) {
    if (substr($file,0,1) != ".") {
        $f = substr($file,0,strpos($file,"."));
        $options .= '<option value="'.$f.'"'.(($tab == $f)?' selected="selected"':'').'>'.ucfirst($f).'</option>';
    }
}

echo '
    <form action="" method="get">
        <select name="tab">
            <option value="">Choose Table</option>
            '.$options.'
        </select>
        <input type="submit" value="Generate"/>
    </form>
    ';

if (file_exists(APATH."/data/{$tab}.dat")) {
    $data = file_get_contents(APATH."/data/{$tab}.dat");
    $parser->populate($data,$tab);

    while ($inc = $parser->popInclude()) {
        if (!$parser->isLoaded($inc) && file_exists(APATH."/data/{$inc}.dat")) {
            $data = file_get_contents(APATH."/data/{$inc}.dat");
            $parser->populate($data);
        }
    }

    $table = nl2br($parser->generate());
    echo '
        <div>
            '.$table.'
        </div>
        ';
}