<?php

namespace src;
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Excel {

    public function AIBFile($file)
    {
        $csv = IOFactory::load($file);
        $worksheet = $csv->getActiveSheet();
        $worksheet->removeColumn('h');
        $worksheet->removeColumn('G');
        $worksheet->removeColumn('F');
        $worksheet->insertNewColumnBefore('D', 1) ->setCellValue('D1', "Valor");

        foreach ($worksheet->getRowIterator() as $key_row => $row) {
            $cellIterator = $row->getCellIterator();
            foreach ($cellIterator as $key =>$cell) {
                if ($key == "C" && $key_row >1) {
                    if(!empty($worksheet->getCell("E". $key_row)->getValue())){
                        $worksheet->setCellValue("D".$key_row, "-". $worksheet->getCell("E". $key_row)->getValue());
                    }else {
                        $worksheet->setCellValue("D".$key_row, "". $worksheet->getCell("F". $key_row)->getValue());
                    }
                }
            }
        }
        $worksheet->removeColumn('F');
        $worksheet->removeColumn('E');
        $worksheet->removeColumn('A');
        $writer = new Csv($csv);
        $writer->save($file);
    }

    public function RevolutFile($file)
    {
        $csv = IOFactory::load($file);
        $worksheet = $csv->getActiveSheet();
        $worksheet->removeColumn('J');
        $worksheet->removeColumn('I');
        $worksheet->removeColumn('H');
        $worksheet->removeColumn('G');
        $worksheet->removeColumn('D');
        $worksheet->removeColumn('B');
        $lines = [];
        foreach ($worksheet->getRowIterator() as $key_row => $row) {
            $cellIterator = $row->getCellIterator();
            if ($key_row == 1) {
                continue;
            }
            foreach ($cellIterator as $key => $cell) {
                if ($key == "A" && $cell->getValue() != "CARD_PAYMENT" ) {
                    array_push($lines, $key_row);
                }
            }
        }
        $lines = array_reverse($lines, true);
        foreach ($lines as $line) {
            $worksheet->removeRow($line);
        }
        $worksheet->removeColumn('A');
        $writer = new Csv($csv);
        $writer->save($file);
    }

    public function create_excel($Aib, $revolut)
    {
        $file = "Planilha_modelo_de_importação.xlsx";
        $xls = IOFactory::load($file);
        $worksheet = $xls->getActiveSheet();
        $worksheet->removeRow(2, $worksheet->getHighestRow());
        $Aibcsv = IOFactory::load($Aib);
        $worksheetAib = $xls->getActiveSheet();

        $Revolutcsv = IOFactory::load($revolut);
        $worksheetRevolut = $xls->getActiveSheet();

        echo '<table>' . PHP_EOL;
        foreach ($worksheet->getRowIterator() as $key_row => $row) {
            echo '<tr>' . PHP_EOL;
            echo '<td>' . $key_row . '</td>' . PHP_EOL;
            $cellIterator = $row->getCellIterator();
            foreach ($cellIterator as $key => $cell) {
                echo '<td>' .
                    $key . "=" . $cell->getValue() .
                    '</td>' . PHP_EOL;
            }
            echo '</tr>' . PHP_EOL;
        }
        echo '</table>' . PHP_EOL;

        $writer = new Xlsx($xls);
        $writer->save($file);

    }
}