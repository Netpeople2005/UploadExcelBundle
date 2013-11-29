<?php

namespace K2\UploadExcelBundle\Controller;

use K2\UploadExcelBundle\Config\Config;
use K2\UploadExcelBundle\MiValidador;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    public function indexAction()
    {

        $config = new Config();

        $config->setColumnNames(array('nombres', 'apellidos', 'edad', 'email'))
                ->setColumnAlias(array(
                    'apellidos' => 'Apelli2',
                    'email' => 'Correo Electronico'
                ))
                ->setExcelColumns(array('mas fino', 'otra columna'))
                ->setRowClass('K2\\UploadExcelBundle\\Ejemplo')
                ->setFilename('F:/excel.xlsx')
                ->addRowValidator(new MiValidador());

        $form = $this->get("excel_reader")->createForm($config);

        $errors = null;

        if ($this->getRequest()->isMethod('POST')) {

            $result = $this->get("excel_reader")->execute($this->getRequest());

            var_dump($result->getData());

            if (count($result->getInvalids())) {
                foreach ($result->getInvalids() as $row) {
                    $errors .= (string) $row->getErrors() . PHP_EOL;
                }
            } else {
                $errors = null;
            }
        }

        return $this->render('UploadExcelBundle:Default:index.html.twig'
                        , array(
                    'form' => $form->createView(),
                    'errors' => $errors,
        ));
    }

}
