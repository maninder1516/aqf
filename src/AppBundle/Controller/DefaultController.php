<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface; // Include logging interface
use AppBundle\Entity\User;

class DefaultController extends Controller
{
   	/**
     *  Get the login page.
     */
    public function indexAction()
    {
        // Redirect to the Login Page
        return $this->render('AppBundle:Security:login.html.twig');
    }

    /**
     *  Login.
     */
    public function loginAction(Request $request)
    {
    	$logger = $this->get('logger');
    	$session = $this->get('session');

    	try {
    		if ($request->getMethod() == 'POST') {
    			$username = $request->request->get('_username');
    			$password = $request->request->get('_password');

    			$criteria = array('username' => $username, 'password' => md5($password));             
                $user = $this->getDoctrine()
                        ->getRepository('AppBundle:User')
                        ->findOneBy($criteria);

                if ($user != NULL) {
                	$session->set('id', $user->getId());
                	$session->set('role', $user->getRole());
                	// Redirects to the "mission" route
    				return $this->redirectToRoute('aqf_homepage');
		    	}
    		} else {
    			// Redirect to the Login Page
        		return $this->render('AppBundle:Security:login.html.twig');
    		}	    		
		} catch (\Exception $ex) {
			$logger->critical('Error while login.', [
    			'cause' => 'ERROR :'.$ex 
    		]);
			// Redirect to the Login Page
        	return $this->render('AppBundle:Security:login.html.twig');
		}
    }
}
