<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface; // Include logging interface
use AppBundle\Entity\User;
use AppBundle\Utils\Messages;

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
                    $session->set('isLogin', true);
                    
                	// Redirects to the "mission" route
                    return $this->redirectToRoute('aqf_homepage', ['searchText' =>'empty']);
		    	} else {
                    $this->addFlash('error', Messages::ERR_CREDENTIAL_NOT_FOUND);
                    return $this->redirect($this->generateUrl('welcome'));
                }
    		} else {
    			// Redirect to the Login Page
        		return $this->render('AppBundle:Security:login.html.twig');
    		}	    		
		} catch (\Exception $ex) {
			$logger->error('Error occured in ' . __METHOD__ . " in " . __FILE__ . " at " . __LINE__ . "\n  Error details are : " . $ex);
			// Redirect to the Login Page
        	return $this->render('AppBundle:Security:login.html.twig');
		}
    }

    /**
     *  Redirect to the home page after log out.
     */
    public function logoutAction(Request $request)
    {
        // Destroy all the session before logout
        $this->get('request')->getSession()->invalidate();
        return $this->render('AppBundle:Security:login.html.twig');
    }

    /**
     *  Redirect to the 403 errorpage.
     */
    public function error403Action()
    {
        return $this->render('AppBundle:Error:error403.html.twig');
    }
    /**
     *  Redirect to the 404 errorpage.
     */
    public function error404Action()
    {
        return $this->render('AppBundle:Error:error404.html.twig');
    }
    /**
     *  Redirect to the 500 errorpage.
     */
    public function error500Action()
    {
        return $this->render('AppBundle:Error:error500.html.twig');
    }
}
