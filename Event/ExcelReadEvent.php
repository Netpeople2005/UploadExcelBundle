<?php

/*
 * This file is part of the Manuel Aguirre Project.
 *
 * (c) Manuel Aguirre <programador.manuel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace K2\UploadExcelBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Description of ExcelReadEvent
 *
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 */
class ExcelReadEvent extends Event
{

    protected $rows;

    function __construct($rows = null)
    {
        $this->rows = $rows;
    }

    public function getRows()
    {
        return $this->rows;
    }

    public function setRows($rows)
    {
        $this->rows = $rows;
    }

}
