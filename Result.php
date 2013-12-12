<?php

namespace K2\UploadExcelBundle;

use K2\UploadExcelBundle\ExcelRowInterface;

class Result implements \IteratorAggregate
{

    protected $data;
    protected $invalids;
    protected $headers;

    function __construct($data = array())
    {
        foreach ($data as $row) {
            $this->addRow($row);
        }
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData(array $data)
    {
        $this->data = $data;
    }

    public function getValids()
    {
        return (array) array_diff_key((array) $this->data, (array) $this->invalids);
    }

    public function getInvalids()
    {
        return (array) $this->invalids;
    }

    public function setInvalids(array $invalids)
    {
        $this->invalids = $invalids;
    }

    public function getHeaders()
    {
        return (array) $this->headers;
    }

    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
    }

    public function addRow(ExcelRowInterface $excelRow)
    {
        $this->data[$excelRow->getNumRow()] = $excelRow;
        return $this;
    }

    public function addRowInvalid(ExcelRowInterface $excelRow)
    {
        $this->invalids[$excelRow->getNumRow()] = $excelRow;
        return $this;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->getData());
    }

}
