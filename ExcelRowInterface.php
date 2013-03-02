<?php

namespace K2\UploadExcelBundle;

use Symfony\Component\Validator\ConstraintViolationList;

interface ExcelRowInterface
{

    public function setRow($row);
    public function getRow();
    public function setErrors(ConstraintViolationList $list);
    public function getErrors();
    
}