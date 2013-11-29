<?php

namespace K2\UploadExcelBundle;

use K2\UploadExcelBundle\ExcelRowInterface;

/**
 *
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 */
interface RowValidatorInterface
{

    public function validate(ExcelRowInterface $row);
}
