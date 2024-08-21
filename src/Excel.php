<?php

namespace src;
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Excel {
    private $file;
    private $type;
    private $worksheet;
    private $xls;


    public function __construct($file, $type) {
        $this->file = $file;
        $this->xls = new Xlsx();
        $this->type = $type;
        
    }

    public function readFile () {
        $extension = pathinfo($this->file, PATHINFO_EXTENSION);
        if('csv' == $extension) {
            $this->xls = new Csv();
        } else if('xls' == $extension) {
            $this->xls = new Xls();
}
        $teste =  $this->xls->load($this->file);
        $this->worksheet = $teste->getActiveSheet();


        var_dump( $this->worksheet);
    }
}