<?php

namespace K2\UploadExcelBundle;

use K2\UploadExcelBundle\ExcelRowInterface;
use K2\UploadExcelBundle\RowValidatorInterface;

/**
 * Description of MiValidador
 *
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 */
class MiValidador implements RowValidatorInterface
{

    public function validate(ExcelRowInterface $row)
    {
        $row->getErrors()->add(new ConstraintViolation('ERROR!!!!', 'todos'));
    }

}
