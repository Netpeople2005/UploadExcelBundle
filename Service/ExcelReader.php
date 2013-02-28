<?php

namespace K2\UploadExcelBundle\Service;

use K2\UploadExcelBundle\Config\ConfigInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormFactoryInterface;
use K2\UploadExcelBundle\Form\Type\ColumnsType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ExcelReader
{

    /**
     *
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     *
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;
    protected $rootDir;

    /**
     *
     * @var Form
     */
    protected $form;

    /**
     *
     * @var ConfigInterface
     */
    protected $config;

    function __construct(FormFactoryInterface $formFactory, EventDispatcherInterface $eventDispatcher, $rootDir)
    {
        $this->formFactory = $formFactory;
        $this->eventDispatcher = $eventDispatcher;
        $this->rootDir = $rootDir;
    }

    public function createForm(ConfigInterface $config, FormTypeInterface $form = null, array $options = array())
    {
        if (null === $form) {
            $form = new ColumnsType();
        }

        return $this->form = $this->formFactory->create($form, $config, $options);
    }

    public function proccessMatch(Request $request)
    {
        $this->form->bind($request);
    }

    public function execute()
    {
        
    }

    protected function readColumnsExcel()
    {
        \PHPExcel_IOFactory::createReaderForFile($this->rootDir . 'files/excel.xls');
    }

}