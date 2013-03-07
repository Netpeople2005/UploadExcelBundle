<?php

namespace K2\UploadExcelBundle;

use K2\UploadExcelBundle\ExcelRow;
use Symfony\Component\Validator\Constraints as Assert;

class Ejemplo extends ExcelRow
{

    protected $nombres;
    protected $apellidos;
    protected $edad;
    /**
     *
     * @var type 
     * @Assert\Email()
     */
    protected $email;

    public function getNombres()
    {
        return $this->nombres;
    }

    public function setNombres($nombres)
    {
        $this->nombres = $nombres;
    }

    public function getApellidos()
    {
        return $this->apellidos;
    }

    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
    }

    public function getEdad()
    {
        return $this->edad;
    }

    public function setEdad($edad)
    {
        $this->edad = $edad;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

}