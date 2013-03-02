<?php

namespace K2\UploadExcelBundle\Config;

interface ConfigInterface
{

    /**
     * Devuelve un arreglo con los nombres de las columnas que nos interesan
     * del excel.
     * 
     * @return array 
     */
    public function getColumnNames();

    public function getRowClass();

    public function setExcelColumns(array $columns);

    public function getExcelColumns();

    public function getHeadersPosition();

    public function getColumnsAssociation();

    public function setColumnsAssociation($columnsAssociation);

    public function getDefaultMatch($column);

    public function getFilename();

    public function setFilename($filename);
}

