<?php

namespace src;

class AibExcel
{
    private $worksheet;

    public function __construct($worksheet) {
        $this->worksheet = $worksheet;
    }

    public function manipulateAib () {
        $this->worksheet->removeColumn('A');
        $this->worksheet->save($this->worksheet);
        var_dump($this->worksheet);
    }

}