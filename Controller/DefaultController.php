<?php

namespace K2\UploadExcelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use K2\UploadExcelBundle\Form\Type\ColumnsType;
use K2\UploadExcelBundle\Config\Config;

class DefaultController extends Controller
{

    public function indexAction()
    {

        $config = new Config();

        $config->setColumnNames(array('nombres',/* 'apellidos',*/ 'edad','email'))
                ->setExcelColumns(array('mas fino', 'otra columna'))
                ->setRowClass('K2\\UploadExcelBundle\\Ejemplo');

        $form = $this->get("excel_reader")->createForm($config);
        
        if($this->getRequest()->isMethod('POST')){
            $result = $this->get("excel_reader")->execute($this->getRequest());
            
            var_dump($result);
            
            var_dump($this->get("excel_validator")->validate($result));
            var_dump((string)current($result->getInvalids())->getErrors());
            
        }

        return $this->render('UploadExcelBundle:Default:index.html.twig'
                        , array(
                    'form' => $form->createView(),
                ));
    }

}
