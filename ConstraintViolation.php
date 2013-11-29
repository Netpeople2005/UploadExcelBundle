<?php

namespace K2\UploadExcelBundle;

use Symfony\Component\Validator\ConstraintViolation as Base;

/**
 * Description of ConstraintViolation
 *
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 */
class ConstraintViolation extends Base
{

    public function __construct($message, $propertyPath = null, array $messageParameters = array())
    {
        parent::__construct($message, $message, $messageParameters, null, $propertyPath, null, null, null);
    }

}
