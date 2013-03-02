<?php

namespace K2\UploadExcelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use K2\UploadExcelBundle\Config\Config;

class DefaultController extends Controller
{

    public function indexAction()
    {

        $config = new Config();

        $config->setColumnNames(array('nombres', 'apellidos', 'edad','email'))
                ->setExcelColumns(array('mas fino', 'otra columna'))
                ->setRowClass('K2\\UploadExcelBundle\\Ejemplo')
                ->setFilename($this->container
                        ->getParameter("kernel.root_dir") . '/../files/excel.xls');

        $form = $this->get("excel_reader")->createForm($config);
        
        $errors = null;
        
        if($this->getRequest()->isMethod('POST')){
            
            $result = $this->get("excel_reader")->execute($this->getRequest());
                        
            $errors = (string)current($result->getInvalids())->getErrors();            
        }

        return $this->render('UploadExcelBundle:Default:index.html.twig'
                        , array(
                    'form' => $form->createView(),
                    'errors' => $errors,
                ));
    }

}
