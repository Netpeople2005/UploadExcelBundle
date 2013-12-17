<?php

namespace K2\UploadExcelBundle;

use K2\UploadExcelBundle\DependencyInjection\Compiler\UploadPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class UploadExcelBundle extends Bundle
{
    
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new UploadPass());
    }

}
