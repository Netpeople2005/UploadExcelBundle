<?php

namespace K2\UploadExcelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use K2\UploadExcelBundle\Config\Config;

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
                ->setFilename($this->container
                        ->getParameter("kernel.root_dir") . '/../files/excel.xls');

        $form = $this->get("excel_reader")->createForm($config);

        $errors = null;

        if ($this->getRequest()->isMethod('POST')) {

            $result = $this->get("excel_reader")->execute($this->getRequest());

            var_dump($result->getData());
            
            if (count($result->getInvalids())) {
                $errors = (string) current($result->getInvalids())->getErrors();
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
