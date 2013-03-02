<?php

namespace K2\UploadExcelBundle\Config;

use K2\UploadExcelBundle\Config\ConfigInterface;

class Config implements ConfigInterface
{

    protected $columnNames;
    protected $excelColumns;
    protected $columnsAssociation;
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

    public function getValidations()
    {
        
    }

    public function getColumnsAssociation()
    {
        return (array) $this->columnsAssociation;
    }

    public function setColumnsAssociation($columnsAssociation)
    {
        $this->columnsAssociation = $columnsAssociation;
        return $this;
    }

    public function getExcelColumns()
    {
        return (array) $this->excelColumns;
    }

    public function setExcelColumns(array $columns)
    {
        $this->excelColumns = $columns;
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

    public function getDefaultMatch($column)
    {

        foreach ($this->getExcelColumns() as $index => $name) {
            if (strtoupper($name) === strtoupper($column)) {
                return $index;
            }
        }

        return null;
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

}