<?php

namespace K2\UploadExcelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('UploadExcelBundle:Default:index.html.twig', array('name' => $name));
    }
}
