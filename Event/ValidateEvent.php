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

use K2\UploadExcelBundle\Result;
use Symfony\Component\EventDispatcher\Event;

/**
 * Description of ValidateEvent
 *
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 */
class ValidateEvent extends Event
{

    /**
     *
     * @var Result
     */
    protected $result;

    function __construct(Result $result)
    {
        $this->result = $result;
    }

    public function getResult()
    {
        return $this->result;
    }

}
