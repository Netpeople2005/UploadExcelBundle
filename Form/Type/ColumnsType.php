<?php

namespace K2\UploadExcelBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use K2\UploadExcelBundle\Config\ConfigInterface;

class ColumnsType extends AbstractType
{

    public function getName()
    {
        return "columns";
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (!isset($options['data']) || $options['data'] instanceof ConfigInterface) {
            //excepcion
        }

        $associations = $builder->create("columnsAssociation", "form", array(
            'by_reference' => false,
                ));
        foreach ($options['data']->getColumnNames() as $name) {
            $associations->add($name, 'choice', array(
                'label' => $name,
                'empty_value' => '--select--',
                'choices' => $options['data']->getExcelColumns(),
                'data' => $options['data']->getDefaultMatch($name),
            ));
        }
        $builder->add($associations);
    }

}