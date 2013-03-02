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

    public function validate(Result $dataResult)
    {
        $dataResult->setInvalids(array());
        foreach ($dataResult->getData() as $row) {
            $list = $this->validator->validate($row);
            if ($list->count()) {
                $row->setErrors($list);
                $dataResult->addRowInvalid($row);
            }
        }

        return count($dataResult->getInvalids());
    }

}