<?php

namespace AQF\AQFBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AQFBundle:Default:index.html.twig');
    }
}
