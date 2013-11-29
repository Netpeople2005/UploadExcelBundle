<?php

namespace K2\UploadExcelBundle;

use Symfony\Component\Validator\ConstraintViolationListInterface;

interface ExcelRowInterface
{

    /**
     * @param array $row
     */
    public function setNumRow($row);

    /**
     * @return array
     */
    public function getNumRow();

    public function setErrors(ConstraintViolationListInterface $list);

    /**
     * @return ConstraintViolationListInterface
     */
    public function getErrors();
}
