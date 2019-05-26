<?php

namespace AQF\AQFBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface; // Include logging interface
use AQF\AQFBundle\Entity\Mission;
use AQF\AQFBundle\Form\MissionType;

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
     *  Open a Add -Edit mission page.
     */
    public function addeditAction(Request $request, $mid)
    {
    	// Get the Logger and Session
    	$logger = $this->get('logger');
    	$session = $this->get('session');

    	try {
    		$request = $this->getRequest();
        	$actionLabel = 'Add mission';

        	$mission = new Mission();

    	    // if($mid > 0) {
	        //     $mission = $this->getDoctrine()
	        //             ->getRepository('AQFBundle:Mission')
	        //             ->find($mid);
	        //     $actionLabel = 'Edit mission';
	        // }
	        // 
        	$form = $this->createForm(new MissionType(), $mission);


    		return $this->render('AQFBundle:Default:addedit.html.twig', array(
                    'form' => $form->createView(), 'mid' => $mid, 'actionLabel' => $actionLabel
                ));
    	} catch(\Exception $ex) {
    		$logger->critical('Error while Add Edit.', [
    			'cause' => 'ERROR :'.$ex 
    		]);
    		// return $this->render('AQFBundle:Default:index.html.twig');
    		return $this->render('AQFBundle:Default:addedit.html.twig');
    	}
    }

    /**
     *  Delete a mission.
     */
    public function deleteAction()
    {
    	
        return $this->render('AQFBundle:Default:index.html.twig');
    }

}
