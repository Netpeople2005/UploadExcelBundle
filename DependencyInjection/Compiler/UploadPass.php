<?php

namespace K2\UploadExcelBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class UploadPass implements CompilerPassInterface
{

    public function process(ContainerBuilder $container)
    {
        $resources = $container->getParameter('twig.form.resources');

        $resources[] = 'UploadExcelBundle:Form:excel_form_layout.html.twig';

        $container->setParameter('twig.form.resources', $resources);
    }

}