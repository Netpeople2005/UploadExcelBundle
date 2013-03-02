<?php

namespace K2\UploadExcelBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FormPass implements CompilerPassInterface
{

    public function process(ContainerBuilder $container)
    {
        $resources = $container->getParameter('twig.form.resources');

//        foreach (array('div', 'jquery', 'stylesheet') as $template) {
//            $resources[] = 'GenemuFormBundle:Form:' . $template . '_layout.html.twig';
//        }
        $resources[] = 'UploadExcelBundle:Form:excel_form_layout.html.twig';

        $container->setParameter('twig.form.resources', $resources);
    }

}