<?php

namespace K2\UploadExcelBundle\Twig\Extension;

use Symfony\Component\Form\FormView;
use Symfony\Bridge\Twig\Form\TwigRendererInterface;

class FormExtension extends \Twig_Extension
{

    /**
     *
     * @var TwigRendererInterface
     */
    protected $renderer;

    public function __construct(TwigRendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    public function getFunctions()
    {
        return array(
            'form_javascript' => new \Twig_Function_Method($this, 'renderJavascript'
                    , array('is_safe' => array('html'))),
            'form_stylesheet' => new \Twig_Function_Method($this, 'renderStylesheet'
                    , array('is_safe' => array('html'))),
        );
    }

    public function renderJavascript(FormView $view)
    {
        return $this->renderer->searchAndRenderBlock($view, 'javascript');
    }

    public function renderStylesheet(FormView $view)
    {
        return $this->renderer->searchAndRenderBlock($view, 'stylesheet');
    }

    public function getName()
    {
        return "upload_excel.twig.extension.form";
    }

}