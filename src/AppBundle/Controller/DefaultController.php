<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
   
    public function indexAction()
    {
        // Redirect to the Login Page
        return $this->render('AppBundle:Security:login.html.twig');
    }
}
