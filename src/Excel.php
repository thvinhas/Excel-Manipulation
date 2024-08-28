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
            $test = IOFactory::load($this->file);
            $worksheet = $test->getActiveSheet();
            $worksheet->removeColumn('A');
            $writer =  new Csv($test);
            $writer->save($this->file);
        } else if('xls' == $extension) {
            $test = IOFactory::load($this->file);
            $worksheet = $test->getActiveSheet();
            $worksheet->removeColumn('A');
            $writer = new Xlsx($test);
            $writer->save($this->file);

        }
//        $file =  $this->xls->load($this->file);

//        if ($this->type === "AIB") {
//            $aib = new AibExcel($file);
//            $aib->manipulateAib();
//        }
    }
}