<?php

namespace AQF\AQFBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface; // Include logging interface
use AQF\AQFBundle\Mission;

class DefaultController extends Controller
{
	// private	$logger;

	// private	$session;

	// public function __construct()
 //    {
 //        $this->logger = $this->get('logger');
 //        $this->session = $this->get('session');
 //    }

	/**
     *  Get the mission page.
     */
    public function indexAction()
    {
    	$logger = $this->get('logger');
    	$session = $this->get('session');

    	$userId = $session->get('id');
    	$role = $session->get('role');
    	// echo "hi".$userId.' -- '.$role;
    	// die;
        return $this->render('AQFBundle:Default:index.html.twig');
    }

    /**
     *  Create a new mission.
     */
    public function createAction()
    {
    	
        return $this->render('AQFBundle:Default:index.html.twig');
    }

}
