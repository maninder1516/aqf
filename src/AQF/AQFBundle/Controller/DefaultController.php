<?php

namespace AQF\AQFBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface; // Include logging interface
use AQF\AQFBundle\Entity\Mission;
use AQF\AQFBundle\Form\MissionType;
use AppBundle\Utils\CommonFunctions as CFs;
use AQF\AQFBundle\Messages;

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
	    	// Get page limit from config.yml
	    	$pageSize = $this->getParameter('page_limit'); 

	    	// Get the entity manager to query
	    	$em = $this->getDoctrine()->getManager();

	        if($role == 1)
	        {
	            $query = $em->createQuery('SELECT u FROM AQFBundle:Mission u ORDER BY u.serviceDate DESC');
	        } else {
	            $query = $em->createQuery('SELECT u FROM AQFBundle:Mission u WHERE u.client = :CLIENT ORDER BY u.serviceDate DESC')
                    ->setParameters(['CLIENT'=> $userId]);
	        }

	    	$currPage = 1;
	    	if(isset($_GET["page"])){
	    		$currPage = $_GET["page"];
	    	}

	        $paginator  = $this->get('knp_paginator');
		    $pagination = $paginator->paginate(
		        $query, /* query NOT result */
		        $currPage,
		        // $request->query->getInt('page', 1), /*page number*/
		        $pageSize /*limit per page*/
		    );

		    $query = $em->createQuery("SELECT u.id, u.username  FROM AppBundle:User u ");
   			$users = $query->getResult();
   			$usersArray = [];
   			foreach ($users as $user) {
   				$usersArray[$user['id']]=$user['username'];
   			}

	    	return $this->render('AQFBundle:Default:index.html.twig', ['missions' => $pagination, 'role'=> $role, 'users'=>$usersArray ]);
    	} catch(\Exception $ex) {
    		$logger->error('Error occured in ' . __METHOD__ . " in " . __FILE__ . " at " . __LINE__ . "\n  Error details are : " . $ex);
    		return $this->redirect($this->generateUrl("welcome"));
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

	            // Redirect to Error403, if record is not cretaed by logged in user
	            if($mission->getClient() != $userId) {
	            	return $this->redirect($this->generateUrl("error403"));
	            }
	            // Redirect to Error404, if record is not found
	            if (!$mission) {
				    return $this->redirect($this->generateUrl("error404"));
			    }
	        }
	        
        	$form = $this->createForm(MissionType::class, $mission);
        	$form->handleRequest($request);

        	// Save or Update here
        	if('POST' == $request->getMethod()) {
            	$em = $this->getDoctrine()->getManager();
                $em->persist($mission);
                $em->flush();

                $this->addFlash('notice', Messages::MSG_MISSION_SAVE_SUCCESS);
                return $this->redirect('/aqf/view/' . $mission->getId());
        	}

    		return $this->render('AQFBundle:Default:addedit.html.twig', [
                    'form' => $form->createView(), 'id' => $id, 'actionLabel' => $actionLabel
                ]);
    	} catch(\Exception $ex) {
    		$logger->error('Error occured in ' . __METHOD__ . " in " . __FILE__ . " at " . __LINE__ . "\n  Error details are : " . $ex);
    		return $this->render('AQFBundle:Default:index.html.twig');
    	}
    }

    /**
     *  Delete a mission.
     */
    public function viewAction($id)
    {	
    	// Get the Logger and Session
    	$logger = $this->get('logger');
    	$session = $this->get('session');
    	$userId = $session->get('id');

    	try {
	    	if ($id > 0) {
	            $mission = $this->getDoctrine()
	                    ->getRepository('AQFBundle:Mission')
	                    ->find($id);

	            // Redirect to Error403, if record is not cretaed by logged in user
	            if($mission->getClient() != $userId) {
	            	return $this->redirect($this->generateUrl("error403"));
	            }
	            // Redirect to Error404, if record is not found
	            if (!$mission) {
				    return $this->redirect($this->generateUrl("error404"));
			    }

	     		return $this->render('AQFBundle:Default:view.html.twig',
					    ['mission'=> $mission]);
	        }else{
	        	return $this->indexAction();
	        }
        } catch(\Exception $ex) {
    		$logger->error('Error occured in ' . __METHOD__ . " in " . __FILE__ . " at " . __LINE__ . "\n  Error details are : " . $ex);
    		// return $this->render('AQFBundle:Default:index.html.twig');
    		return $this->render('AQFBundle:Default:index.html.twig');
    	}
    }

    /**
     *  Delete a mission.
     */
    public function deleteAction($id)
    {
    	// Get the Logger and Session
    	$logger = $this->get('logger');
    	$session = $this->get('session');
    	$userId = $session->get('id');

    	try {
	    	if ($id > 0) {
	            $mission = $this->getDoctrine()
	                    ->getRepository('AQFBundle:Mission')
	                    ->find($id);

	            // Redirect to Error403, if record is not cretaed by logged in user
	            if($mission->getClient() != $userId) {
	            	return $this->redirect($this->generateUrl("error403"));
	            }
	            // Redirect to Error404, if record is not found
	            if (!$mission) {
				    return $this->redirect($this->generateUrl("error404"));
			    }

	            $em = $this->getDoctrine()->getManager();
	            $em->persist($mission);                        
	            $em->remove($mission);
	            $em->flush();

	            $this->addFlash('notice', Messages::MSG_MISSION_DELETE_SUCCESS);
	            return $this->redirect($this->generateUrl("aqf_homepage"));
	        } else {
	        	return $this->indexAction();
	        }
        } catch(\Exception $ex) {
    		$logger->error('Error occured in ' . __METHOD__ . " in " . __FILE__ . " at " . __LINE__ . "\n  Error details are : " . $ex);
    		// return $this->render('AQFBundle:Default:index.html.twig');
    		return $this->render('AQFBundle:Default:index.html.twig');
    	}
    }
}
