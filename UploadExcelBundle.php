<?php

namespace K2\UploadExcelBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use K2\UploadExcelBundle\DependencyInjection\Compiler\FormPass;

class UploadExcelBundle extends Bundle
{
    
    public function build(\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        $container->addCompilerPass(new FormPass());
    }

}
