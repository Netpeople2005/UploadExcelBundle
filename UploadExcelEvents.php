<?php

/*
 * This file is part of the Manuel Aguirre Project.
 *
 * (c) Manuel Aguirre <programador.manuel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace K2\UploadExcelBundle;
/**
 * Description of Events
 *
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 */
final class UploadExcelEvents
{
    const PRE_CREATE_RESULT = 'upload.pre_create_result.%s';
    const POST_CREATE_RESULT= 'upload.post_create_result.%s';
    const VALIDATE = 'upload.validate.%s';
}
