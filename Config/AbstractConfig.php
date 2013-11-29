<?php

namespace K2\UploadExcelBundle\Config;

use K2\UploadExcelBundle\Config\ConfigInterface;
use K2\UploadExcelBundle\RowValidatorInterface;

abstract class AbstractConfig implements ConfigInterface
{

    protected $excelColumns;
    protected $columnsAssociation;
    protected $filename;
    protected $rowValidators = array();

    public function getColumnsAssociation()
    {
        return array_filter((array) $this->columnsAssociation);
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
    
    public function getColumnAlias()
    {
        return array();
    }

        /**
     * 
     * @param string $column columna de la entidad
     * @return null
     */
    public function getDefaultMatch($column)
    {
        $alias = (array) $this->getColumnAlias();

        foreach ($this->getExcelColumns() as $index => $name) {
            //si existe un alias para la columna, devolvemos el indice de la columna
            if (isset($alias[$column]) && (strtoupper($alias[$column]) === strtoupper($name))) {
                return $index;
            }
            if (strtoupper($name) === strtoupper($column)) {
                return $index;
            }
        }

        return null;
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function setFilename($filename)
    {
        $this->filename = $filename;
        return $this;
    }

    public function getHeadersPosition()
    {
        return array('A', 1); //por defecto la columna A y la fila 1
    }
    
    public function getRowValidators()
    {
        return $this->rowValidators;
    }

    public function addRowValidator(RowValidatorInterface $validator)
    {
        $this->rowValidators[] = $validator;
        return $this;
    }



}
