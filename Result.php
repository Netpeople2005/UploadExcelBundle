<?php

namespace K2\UploadExcelBundle;

use K2\UploadExcelBundle\ExcelRowInterface;

class Result
{

    protected $data;
    protected $invalids;
    protected $headers;

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
        return array_diff((array)$this->data,(array) $this->invalids);
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
        return (array)$this->headers;
    }

    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
    }

    public function addRow(ExcelRowInterface $excelRow)
    {
        $this->data[$excelRow->getRow()] = $excelRow;
        return $this;
    }
    public function addRowInvalid(ExcelRowInterface $excelRow)
    {
        $this->invalids[$excelRow->getRow()] = $excelRow;
        return $this;
    }

}