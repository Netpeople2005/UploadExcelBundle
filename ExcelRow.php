<?php

namespace K2\UploadExcelBundle;

use K2\UploadExcelBundle\ExcelRowInterface;
use \Symfony\Component\Validator\ConstraintViolationList;

class ExcelRow implements ExcelRowInterface
{

    private $row;
    private $errors;

    public function getRow()
    {
        return $this->row;
    }

    public function setRow($row)
    {
        $this->row = $row;
        return $this;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function setErrors(ConstraintViolationList $list)
    {
        $this->errors = $list;
        return $this;
    }

}