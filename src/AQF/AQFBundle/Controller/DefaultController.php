<?php

namespace AQF\AQFBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface; // Include logging interface
use AQF\AQFBundle\Entity\Mission;
use AQF\AQFBundle\Form\MissionType;
use AppBundle\Utils\CommonFunctions as CFs;

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
    	// Get the Logger and Session
    	$logger = $this->get('logger');
    	$session = $this->get('session');

    	// Check if user is logged in else redirect to Login page
    	$session = $this->get('session');
        if (CFs::isLoggedIn($session) == false) {
            return $this->redirect($this->generateUrl('welcome'));
        }
 
    	try {
    		$userId = $session->get('id');
	    	$role = $session->get('role');
	    	$pageIndex = 1;
	    	// Get page limit from configs
	    	$pageSize = $this->getParameter('page_limit');
	    	$currRec = $pageSize * $pageIndex - $pageSize;   

	    	// Get the entity manager to query
	    	$em = $this->getDoctrine()->getManager();

	        if($role == 1)
	        {
	            $query = $em->createQuery('SELECT u FROM AQFBundle:Mission u ORDER BY u.serviceDate DESC')
	            	->setMaxResults($pageSize)
                  	->setFirstResult($currRec);
	        } else {
	            $query = $em->createQuery('SELECT u FROM AQFBundle:Mission u WHERE u.client = :CLIENT ORDER BY u.serviceDate DESC')
                    ->setParameters(['CLIENT'=> $userId])
                    ->setMaxResults($pageSize)
                  	->setFirstResult($currRec);
	        }
	        $missions = $query->getResult();

	    	return $this->render('AQFBundle:Default:index.html.twig', ['missions' => $missions, 'role'=> $role ]);
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
    public function addeditAction(Request $request, $id)
    {
    	// Get the Logger and Session
    	$logger = $this->get('logger');
    	$session = $this->get('session');
    	$userId = $session->get('id');

    	try {
        	$actionLabel = 'Add mission';

        	$mission = new Mission();
        	$mission->setClient($userId);

    	    if($id > 0) {
	            $mission = $this->getDoctrine()
	                    ->getRepository('AQFBundle:Mission')
	                    ->find($id);
	            $actionLabel = 'Edit mission';
	        }
	        
        	$form = $this->createForm(new MissionType(), $mission);
        	$form->handleRequest($request);

        	// Save or Update here
        	if('POST' == $request->getMethod()) {
            	$em = $this->getDoctrine()->getManager();
                $em->persist($mission);
                $em->flush();

                return $this->redirect('/aqf/view/' . $mission->getId());
        	}

    		return $this->render('AQFBundle:Default:addedit.html.twig', [
                    'form' => $form->createView(), 'id' => $id, 'actionLabel' => $actionLabel
                ]);
    	} catch(\Exception $ex) {
    		$logger->critical('Error while Add Edit.', [
    			'cause' => 'ERROR :'.$ex 
    		]);
    		return $this->render('AQFBundle:Default:index.html.twig');
    	}
    }

    /**
     *  Delete a mission.
     */
    public function viewAction($id)
    {
    	try {
	    	if ($id > 0) {
	            $mission = $this->getDoctrine()
	                    ->getRepository('AQFBundle:Mission')
	                    ->find($id);

                if (!$mission) {
				    throw $this->createNotFoundException(
				    'There are no mission with the following id: ' . $id
				    );
			    }

	     		return $this->render('AQFBundle:Default:view.html.twig',
					    ['mission'=> $mission]);
	        }else{
	        	return $this->indexAction();
	        }
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
    public function deleteAction($id)
    {
    	try {
	    	if ($id > 0) {
	            $mission = $this->getDoctrine()
	                    ->getRepository('AQFBundle:Mission')
	                    ->find($id);

	            if (!$mission) {
				    throw $this->createNotFoundException(
				    'There are no articles with the following id: ' . $id
				    );
			    }

	            $em = $this->getDoctrine()->getManager();
	            $em->persist($mission);                        
	            $em->remove($mission);
	            $em->flush();

	            return $this->redirect($this->generateUrl("aqf_homepage"));
	        } else {
	        	return $this->indexAction();
	        }
        } catch(\Exception $ex) {
    		$logger->critical('Error while saving data.', [
    			'cause' => 'ERROR :'.$ex 
    		]);
    		// return $this->render('AQFBundle:Default:index.html.twig');
    		return $this->render('AQFBundle:Default:index.html.twig');
    	}
    }
}
