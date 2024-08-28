<?php

namespace src;
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Excel {
    private $file;
    private $type;
    private $worksheet;
    private $xls;


    public function __construct($file, $type) {
        $this->file = $file;
        $this->type = $type;
        
    }

    public function readFile () {

        if('AIB' == $this->type) {
            $this->AIBFile();
        } else {
            $this->RevolutFile();
        }
    }


    public function AIBFile()
    {
        $csv = IOFactory::load($this->file);
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


        echo '<table>' . PHP_EOL;
        foreach ($worksheet->getRowIterator() as $row) {
            echo '<tr>' . PHP_EOL;
            $cellIterator = $row->getCellIterator();
            foreach ($cellIterator as $key =>$cell) {
                echo '<td>' .
                    $key . "=" .$cell->getValue() .
                    '</td>' . PHP_EOL;
            }
            echo '</tr>' . PHP_EOL;
        }
    }

    public function RevolutFile()
    {
        $csv = IOFactory::load($this->file);
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
        $writer = new Csv($csv);
        $writer->save($this->file);
    }
}