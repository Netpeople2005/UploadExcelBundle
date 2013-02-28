<?php

namespace K2\UploadExcelBundle\Config;

use K2\UploadExcelBundle\Config\ConfigInterface;
use K2\UploadExcelBundle\ExcelColumn;

class Config implements ConfigInterface
{

    protected $columnNames;
    protected $excelColumns;
    protected $columnsAssociation;

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
        $this->columnsAssociation = array();
        foreach ($columnsAssociation as $columnName => $excelColumIndex) {
            $this->columnsAssociation[$columnName] = $this->excelColumns[$excelColumIndex];
        }
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

}