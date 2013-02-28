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

    public function getValidations();

    public function setExcelColumns(array $columns);

    public function getExcelColumns();

    public function getHeadersPosition();

    public function getColumnsAssociation();

    public function setColumnsAssociation($columnsAssociation);
}

