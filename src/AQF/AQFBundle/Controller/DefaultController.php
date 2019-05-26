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
    public function indexAction(Request $request)
    {
    	// Check if user is logged in else redirect to Login page
    	if ($this->isLoggedIn() == false) {
            return $this->redirect($this->generateUrl('welcome'));
        }

        // Get the Logger and Session
    	$logger = $this->get('logger');
    	$session = $this->get('session');
    	try {
    		$userId = $session->get('id');
	    	$role = $session->get('role');
	    	
	    	$em = $this->getDoctrine()->getManager();
	        $query = $em->createQuery("SELECT u FROM AQFBundle:Mission u ");
	        $missions = $query->getResult();

	        // $repository = $this->getDoctrine()->getRepository(Mission::class);
	        // $missions = $repository->findAll();
	        // var_dump($missions);
	     //    echo "hi".$userId.' -- '.$role;
	    	// die;
	    	return $this->render('AQFBundle:Default:index.html.twig', ['missions' => $missions]);

    		// return $this->render('AQFBundle:Default:index.html.twig', array('missions' => $missions ));
    	} catch(\Exception $ex) {
    		$logger->critical('Error :', [
    			'cause' => 'ERROR :'.$ex 
    		]);
    		return $this->render('AQFBundle:Default:index.html.twig');
    	}
    }

    /**
     *  Open a Add -Edit mission page.
     */
    public function addeditAction(Request $request, $mid)
    {
    	// Get the Logger and Session
    	$logger = $this->get('logger');
    	$session = $this->get('session');
    	$userId = $session->get('id');

    	try {
        	$actionLabel = 'Add mission';

        	$mission = new Mission();
        	$mission->setClient($userId);

    	    if($mid > 0) {
	            $mission = $this->getDoctrine()
	                    ->getRepository('AQFBundle:Mission')
	                    ->find($mid);
	            $actionLabel = 'Edit mission';
	        }
	        
        	$form = $this->createForm(new MissionType(), $mission);
        	$form->handleRequest($request);

        	// Save or Update here
        	if('POST' == $request->getMethod()) {
				// $product = $form["productName"]->getData();
            	$em = $this->getDoctrine()->getManager();
                $em->persist($mission);
                $em->flush();

            	return $this->render('AQFBundle:Default:index.html.twig');
        	}

    		return $this->render('AQFBundle:Default:addedit.html.twig', [
                    'form' => $form->createView(), 'mid' => $mid, 'actionLabel' => $actionLabel
                ]);
    	} catch(\Exception $ex) {
    		$logger->critical('Error while Add Edit.', [
    			'cause' => 'ERROR :'.$ex 
    		]);
    		return $this->render('AQFBundle:Default:index.html.twig');
    	}
    }

     /**
     *  Save a mission.
     */
    public function saveAction(Request $request)
    {
    	// Get the Logger and Session
    	$logger = $this->get('logger');
    	$session = $this->get('session');

    	try {
    		if ($request->getMethod() == 'POST') {
            	$form->bindRequest($request);

            	$em = $this->getDoctrine()->getManager();
                $em->persist($dbannouncement);
                $em->flush();

            	echo "hello";
            	die;
        	}

    		return $this->render('AQFBundle:Default:index.html.twig');
    	} catch(\Exception $ex) {
    		$logger->critical('Error while saving data.', [
    			'cause' => 'ERROR :'.$ex 
    		]);
    		// return $this->render('AQFBundle:Default:index.html.twig');
    		return $this->render('AQFBundle:Default:index.html.twig');
    	}
    }

    /**
     *  Delete a mission.
     */
    public function deleteAction($mid)
    {
    	try {
	    	if ($mid > 0) {
	            $mission = $this->getDoctrine()
	                    ->getRepository('AQFBundle:Mission')
	                    ->find($mid);

	            $em = $this->getDoctrine()->getManager();
	            $em->persist($mission);                        
	            $em->remove($mission);
	            $em->flush();
	        }
        	return $this->indexAction();
        } catch(\Exception $ex) {
    		$logger->critical('Error while saving data.', [
    			'cause' => 'ERROR :'.$ex 
    		]);
    		// return $this->render('AQFBundle:Default:index.html.twig');
    		return $this->render('AQFBundle:Default:index.html.twig');
    	}
    }

    /**
     *  Check if user is Logged in.
     */
    private function isLoggedIn() {
        $mySession = $this->get('session');
        $isloginval = $mySession->get('isLogin');
        if ($isloginval != "Y") {
            return false;
        }
        return true;
    }

}
