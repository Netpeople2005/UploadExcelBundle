<?php

namespace K2\UploadExcelBundle\Service;

use K2\UploadExcelBundle\Config\ConfigInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormFactoryInterface;
use K2\UploadExcelBundle\Form\Type\ColumnsType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use K2\UploadExcelBundle\Result;

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

    /**
     *
     * @var \PHPExcel
     */
    protected $excel;

    function __construct(FormFactoryInterface $formFactory, EventDispatcherInterface $eventDispatcher, $rootDir)
    {
        $this->formFactory = $formFactory;
        $this->eventDispatcher = $eventDispatcher;
        $this->rootDir = $rootDir;
    }

    public function createForm(ConfigInterface $config, FormTypeInterface $form = null, array $options = array())
    {
        $this->config = $config;

        if (null === $form) {
            $form = new ColumnsType();
        }

        $this->readHeadersExcel();

        return $this->form = $this->formFactory->create($form, $config, $options);
    }

    public function execute(Request $request)
    {
        $this->form->bind($request);

        $result = new Result();

        $data = $this->excel->getActiveSheet()->toArray(null, true, true, true);

        list($columnHeader, $rowHeader) = $this->config->getHeadersPosition();

        unset($data[$rowHeader]);

        $data = $this->convertIndexesToHeaderNames($data);

        $result->setData($data);

        var_dump($this->config, $result);
    }

    protected function readHeadersExcel()
    {
        $excelFile = dirname($this->rootDir) . '/files/excel.xls';

        $this->excel = \PHPExcel_IOFactory::load($excelFile);
        $sheet = $this->excel->getActiveSheet();

        list($column, $row) = $this->config->getHeadersPosition();

        $headers = array();

        while ($sheet->cellExists("{$column}{$row}")) {
            $headers[$column] = $sheet->getCell("{$column}{$row}")->getValue();
            ++$column;
        }

        if (count($this->config->getColumnNames()) > count($headers)) {
            //excepcion de que están haciendo falta columnas en el excel por leer
        }

        $this->config->setExcelColumns($headers);
    }

    protected function convertIndexesToHeaderNames(array $data)
    {
        $columnsName = array_flip($this->config->getColumnsAssociation());

        foreach ($data as $rowIndex => $rowData) {
            foreach ($rowData as $column => $value) {
                unset($data[$rowIndex][$column]);
                if (array_key_exists($column, $columnsName)) {
                    $data[$rowIndex][$columnsName[$column]] = $value;
                }
            }
        }

        return $data;
    }

}