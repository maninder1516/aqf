<?php
// src/AppBundle/Utils/CommonFunctions.php 

namespace AppBundle\Utils;

use Symfony\Component\HttpFoundation\Request;

class CommonFunctions {
	/*
     *  Check if user is Logged in.
     */
    public static function isLoggedIn($session) {
        $isloginval = $session->get('isLogin');
        if ($isloginval != "Y") {
            return false;
        }
        return true;
    }   
}