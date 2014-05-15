<?php

namespace K2\UploadExcelBundle\Config;

use K2\UploadExcelBundle\Config\AbtractConfig;

class Config extends AbstractConfig
{

    protected $columnNames;
    protected $requiredColumns;
    protected $columnAlias;
    protected $headersPosition;
    protected $rowClass;

    public function __construct()
    {
        $this->setHeadersPosition();
    }

    public function setColumnNames(array $culumnNames)
    {
        $this->columnNames = $culumnNames;
        return $this;
    }

    public function getColumnNames()
    {
        return (array) $this->columnNames;
    }

    public function getColumnAlias()
    {
        return (array) $this->columnAlias;
    }

    public function setColumnAlias(array $columnAlias)
    {
        $this->columnAlias = $columnAlias;
        return $this;
    }

    public function getHeadersPosition()
    {
        return $this->headersPosition;
    }

    public function setHeadersPosition($column = 'A', $row = 1)
    {
        $this->headersPosition = array($column, $row);
        return $this;
    }

    public function getRowClass()
    {
        return $this->rowClass;
    }

    public function setRowClass($rowClass)
    {
        $this->rowClass = $rowClass;
        return $this;
    }

    public function getRequiredColumns()
    {
        return $this->requiredColumns;
    }

    public function setRequiredColumns($requiredColumns)
    {
        $this->requiredColumns = $requiredColumns;
    }

}
