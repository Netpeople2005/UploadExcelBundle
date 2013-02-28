<?php

namespace K2\UploadExcelBundle;

class Result
{

    protected $data;
    protected $valids;
    protected $invalids;
    protected $headers;

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function getValids()
    {
        return $this->valids;
    }

    public function setValids($valids)
    {
        $this->valids = $valids;
    }

    public function getInvalids()
    {
        return $this->invalids;
    }

    public function setInvalids($invalids)
    {
        $this->invalids = $invalids;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

}