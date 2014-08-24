<?php
if (!defined("ENTRY")) exit("Invalid Entry Point");

empty($_REQUEST['tab'])?$tab = "":$tab=$_REQUEST['tab'];
($_REQUEST['nr'] > 1 && $_REQUEST['nr'] < 51)?$nr=$_REQUEST['nr']:$nr=1;

$files = scandir(APATH."/data/");
$options = "";
foreach ($files as $file) {
    if (substr($file,0,1) != ".") {
        $f = substr($file,0,strpos($file,"."));
        $options .= '<option value="'.$f.'"'.(($tab == $f)?' selected="selected"':'').'>'.us2uc($f).'</option>';
    }
}

echo '
    <div class="form">
        <form action="" method="get">
            Table:
            <select name="tab">
                <option value="">Choose Table</option>
                '.$options.'
            </select><br/>
            How many:
            <input type="number" id="nr" name="nr" value="'.$nr.'" min="1" max="50"/>
            <input type="submit" name="nr" value="1"/>
            <input type="submit" name="nr" value="2"/>
            <input type="submit" name="nr" value="3"/>
            <input type="submit" name="nr" value="4"/>
            <input type="submit" name="nr" value="5"/>
            <input type="submit" name="nr" value="10"/>


            <br/>
            <input type="submit" value="Generate"/>
            <!-- <input type="submit" name="pdf" value="Generate PDF"/> -->
        </form>
    </div>
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

    for ($i=0;$i<$nr;$i++) {
        echo '
            <div class="record">
                '.nl2br($parser->generate()).'
            </div>
            ';
    }
}