<?php
if (!defined("ENTRY")) exit("Invalid Entry Point");

empty($_REQUEST['tab'])?$tab = "":$tab=$_REQUEST['tab'];
($_REQUEST['nr'] > 1 && $_REQUEST['nr'] < 51)?$nr=$_REQUEST['nr']:$nr=1;

$options = "";
foreach (getFiles("dat") as $f) {
    $options .= '<option value="'.$f.'"'.(($tab == $f)?' selected="selected"':'').'>'.us2uc($f).'</option>';
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
            <input type="submit" name="pdf" value="Generate PDF"/>
        </form>
    </div>
    ';

$data = new dataHandler($tab);
if ($data->hasFile()) {
    $parser->populate($data->getData(),$tab);

    while ($inc = $parser->popInclude()) {
        if (!$parser->isLoaded($inc)) {
            $newData = new dataHandler($inc);
            if ($newData->hasFile()) {
                $parser->populate($newData->getdata());
            }
        }
    }

    if (empty($_REQUEST['pdf'])) {
        if ($data->hasHeader()) {
            echo '
                <div class="header">
                    '.nl2br($data->getHeader()).'
                </div>
                ';
        }

        for ($i=0;$i<$nr;$i++) {
            echo '
                <div class="record">
                    '.nl2br($parser->generate()).'
                </div>
                ';
        }

        if ($data->hasFooter()) {
            echo '
                <div class="footer">
                    '.nl2br($data->getFooter()).'
                </div>
                ';
        }
    } else {
        ob_end_clean();
        require_once "tfpdf/tfpdf.php";

        $pdf = new tfpdf('P','mm','a4');
        $pdf->SetAutoPageBreak(true);
        $pdf->SetMargins(5, 5, 5);
        $pdf->SetDrawColor(0,0,0);
//        $pdf->AddFont('Chantelli','','Chantelli_Antiqua-webfont.ttf',true);
        $pdf->AddFont('Chantelli','','DejaVuSerif.ttf',true);

        $pdf->addPage();

        $pdf->SetFont('Chantelli','',14);
        $pdf->MultiCell("0","10",us2uc($tab),"");

        $pdf->SetFont('Chantelli','',10);
        for ($i=0;$i<$nr;$i++) {
            $pdf->MultiCell("0","5","\n".$parser->generate(),"T");
            $pdf->ln();
        }

        // Output and close pdf.
        $pdf->Output("{$tab}.pdf","I");
        $pdf->Close();
        return false;
    }
}
