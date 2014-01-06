<?php

namespace K2\UploadExcelBundle\Service;

use K2\UploadExcelBundle\Result;
use Symfony\Component\Validator\ValidatorInterface;

class Validator
{

    /**
     *
     * @var ValidatorInterface
     */
    protected $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validate(\K2\UploadExcelBundle\Config\ConfigInterface $config, Result $dataResult)
    {
        $dataResult->setInvalids(array());
        foreach ($dataResult->getData() as $row) {
            $list = $this->validator->validate($row, $config->getValidationGroups());
            $row->setErrors($list);
            //abrimos la posibilidad de validar cualquier cosa en una fila
            foreach ($config->getRowValidators() as $validator) {
                $validator->validate($row);
            }
            
            if ($list->count()) {
                $dataResult->addRowInvalid($row);
            }
        }

        return count($dataResult->getInvalids());
    }

}
