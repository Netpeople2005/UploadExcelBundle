<?php

namespace K2\UploadExcelBundle\Config;

use K2\UploadExcelBundle\Config\ConfigInterface;

abstract class AbstractConfig implements ConfigInterface
{

    protected $excelColumns;
    protected $columnsAssociation;
    protected $filename;

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

}