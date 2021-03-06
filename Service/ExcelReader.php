<?php

namespace K2\UploadExcelBundle\Service;

use K2\UploadExcelBundle\Config\ConfigInterface;
use K2\UploadExcelBundle\Event\ExcelReadEvent;
use K2\UploadExcelBundle\UploadExcelEvents;
use K2\UploadExcelBundle\Form\Type\ColumnsType;
use K2\UploadExcelBundle\Result;
use K2\UploadExcelBundle\Service\Validator;
use PHPExcel;
use PHPExcel_CachedObjectStorageFactory;
use PHPExcel_IOFactory;
use PHPExcel_Settings;
use ReflectionClass;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use UnexpectedValueException;

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

    /**
     *
     * @var Validator
     */
    protected $validator;

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
     * @var PHPExcel
     */
    protected $excel;

    function __construct(FormFactoryInterface $formFactory, EventDispatcherInterface $eventDispatcher)
    {
        $this->formFactory = $formFactory;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * 
     * @param ConfigInterface $config
     * @param FormTypeInterface $form
     * @param array $options
     * @return FormInterface
     */
    public function createForm(ConfigInterface $config, FormTypeInterface $form = null, array $options = array())
    {
        $this->config = $config;

        if (null === $form) {
            $form = new ColumnsType();
        }

        $this->readHeadersExcel();

        return $this->form = $this->formFactory->create($form, $config, $options);
    }

    /**
     * 
     * @param Request $request
     * @return Result el resultado con la data y validado
     */
    public function execute(Request $request = null, $eventName = null)
    {
        if (!$this->form->isSubmitted() and $request) {
            $this->form->submit($request); //por ahora, más adelante se quitará
        }

        $data = $this->excel->getActiveSheet()->toArray(null, true, false, true);
        $this->excel->disconnectWorksheets();

        list($columnHeader, $rowHeader) = $this->config->getHeadersPosition();

        unset($data[$rowHeader]);
        
        $event = new ExcelReadEvent($data);
        unset($data);

        $name = sprintf(UploadExcelEvents::PRE_CREATE_RESULT, $this->resolveEventName($eventName));
        $this->eventDispatcher->dispatch($name, $event);

        $event->setRows($this->createResult($event->getRows()));
        
        $name = sprintf(UploadExcelEvents::POST_CREATE_RESULT, $this->resolveEventName($eventName));
        $this->eventDispatcher->dispatch($name, $event);

        $this->validator->validate($this->config, $event->getRows()
                , $this->resolveEventName($eventName));

        return $event->getRows();
    }

    protected function readHeadersExcel()
    {
        $excelFile = $this->config->getFilename();

        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array(' memoryCacheSize ' => '8MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);

        $reader = PHPExcel_IOFactory::createReaderForFile($excelFile);
        $sheets = $reader->listWorksheetNames($excelFile);
        $reader->setLoadSheetsOnly($sheets[0]);
        $reader->setReadDataOnly(true);
        $this->excel = $reader->load($excelFile);
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

    /**
     * 
     * @param array $excelData
     * @return Result
     * @throws UnexpectedValueException
     */
    public function createResult(array $excelData)
    {
        $rowClass = $this->config->getRowClass();

        if (is_object($rowClass)) {
            $rowClass = get_class($rowClass);
        }

        if (!is_string($rowClass) || empty($rowClass)) {
            throw new UnexpectedValueException(sprintf("El método 'getConfig' de la clase '%s' debe devolver un string con el nombre de una clase válida ó una instancia", get_class($this->config)));
        }

        $reflection = new ReflectionClass($rowClass);

        if (!$reflection->isSubclassOf('K2\\UploadExcelBundle\\ExcelRowInterface')) {
            throw new UnexpectedValueException(sprintf("la clase %s debe implementar la interfaz K2\\UploadExcelBundle\\ExcelRowInterface", $rowClass));
        }

        unset($reflection);

        $normalizer = new GetSetMethodNormalizer();
        $result = new Result();

        $columnsName = array_flip($this->config->getColumnsAssociation());

        foreach ($excelData as $rowIndex => $rowData) {
            if (0 === count(array_filter($rowData))) {
                break;
            }
            foreach ($rowData as $column => $value) {
                unset($excelData[$rowIndex][$column]);
                if (array_key_exists($column, $columnsName)) {
                    $excelData[$rowIndex][$columnsName[$column]] = $value;
                }
            }
            $rowObject = $normalizer->denormalize($excelData[$rowIndex], new $rowClass());
            $rowObject->setNumRow($rowIndex);
            $result->addRow($rowObject);
        }

        return $result;
    }

    public function getValidator()
    {
        return $this->validator;
    }

    public function setValidator(Validator $validator)
    {
        $this->validator = $validator;
    }

    private function resolveEventName($name = null)
    {
        return $name ? : $this->config->getName();
    }

}
