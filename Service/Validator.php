<?php

namespace K2\UploadExcelBundle\Service;

use K2\UploadExcelBundle\Config\ConfigInterface;
use K2\UploadExcelBundle\Event\ValidateEvent;
use K2\UploadExcelBundle\Result;
use K2\UploadExcelBundle\UploadExcelEvents;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\ValidatorInterface;

class Validator
{

    /**
     *
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     *
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     *
     * @var ContainerInterface
     */
    protected $container;

    function __construct(ValidatorInterface $validator, EventDispatcherInterface $dispatcher, ContainerInterface $container)
    {
        $this->validator = $validator;
        $this->dispatcher = $dispatcher;
        $this->container = $container;
    }

    public function validate(ConfigInterface $config, Result $dataResult)
    {
        $dataResult->setInvalids(array());

        $event = new ValidateEvent($dataResult);

        $name = sprintf(UploadExcelEvents::VALIDATE, $config->getName());
        $this->dispatcher->dispatch($name, $event);

        foreach ($dataResult->getData() as $row) {
            $list = $this->validator->validate($row, $config->getValidationGroups());
            if($row->getErrors() instanceof ConstraintViolationListInterface){
                var_dump($list, $row->getErrors());
                $row->getErrors()->addAll($list);
            }else{
                $row->setErrors($list);                
            }
            //abrimos la posibilidad de validar cualquier cosa en una fila
            foreach ($config->getRowValidators() as $validator) {
                if (is_string($validator)) {
                    $validator = $this->container->get($validator);
                }
                $validator->validate($row);
            }

            if (count($row->getErrors())) {
                $dataResult->addRowInvalid($row);
            }
        }

        return count($dataResult->getInvalids());
    }

}
