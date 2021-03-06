<?php

namespace PhpBlogBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecurityController extends Controller
{
	/**
	 * @Route("/security/login", name="security_login")
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function login()
	{
		return $this->render("security/login.html.twig");
	}

	/**
	 * @Route("/security/logout", name="security_logout")
	 * @return int
	 */
	public function logout()
	{
		// It... works?
		return 1;
	}
}
