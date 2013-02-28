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
                ->setHeadersPosition();

        $form = $this->get("excel_reader")->createForm($config);
        
        if($this->getRequest()->isMethod('POST')){
            $this->get("excel_reader")->execute($this->getRequest());
        }

        return $this->render('UploadExcelBundle:Default:index.html.twig'
                        , array(
                    'form' => $form->createView(),
                ));
    }

}
