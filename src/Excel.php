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
        $extension = pathinfo($this->file, PATHINFO_EXTENSION);
        if('csv' == $extension) {
            $csv = IOFactory::load($this->file);
            $worksheet = $csv->getActiveSheet();
            $worksheet->removeColumn('A');
            $worksheet->removeColumn('E');
            $worksheet->insertNewColumnBefore('C', 1) ->setCellValue('C0', "Valor");

            foreach ($worksheet->getRowIterator() as $row) {
                $i = 1;
                $cellIterator = $row->getCellIterator();
                foreach ($cellIterator as $key =>$cell) {
                        if ($key == "C") {
                           if(!empty($worksheet->getCell("D". $i)->getValue())){
                               $worksheet->setCellValue("c".$i, "-".$worksheet->getCell("D". $i)->getValue());
                           }else {
                               $worksheet->setCellValue("c".$i, "".$worksheet->getCell("E". $i)->getValue());
                           }
                        }
                }
                $i++;
            }


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
            echo '</table>' . PHP_EOL;
            $writer =  new Csv($csv);
            $writer->save($this->file);
        } else if('xls' == $extension) {


        }
//        $file =  $this->xls->load($this->file);

//        if ($this->type === "AIB") {
//            $aib = new AibExcel($file);
//            $aib->manipulateAib();
//        }
    }
}