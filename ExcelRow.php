<?php

namespace K2\UploadExcelBundle;

use K2\UploadExcelBundle\ExcelRowInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ExcelRow implements ExcelRowInterface
{

    private $numRow;
    private $errors;

    public function getNumRow()
    {
        return $this->numRow;
    }

    public function setNumRow($row)
    {
        $this->numRow = $row;
        return $this;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function setErrors(ConstraintViolationListInterface $list)
    {
        $this->errors = $list;
        return $this;
    }

}