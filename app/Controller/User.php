<?php

namespace App\Controller;

class User extends Controller
{
	public function methodIndex($args)
	{

	}

	public function methodLogin($args)
	{
		$data['content'] = $this->view->render('templates/user/login.phtml');
		return $this->render($data);
	}

	public function methodRegister($args)
	{
		$data['content'] = $this->view->render('templates/user/register.phtml');
		return $this->render($data);
	}

	public function methodProfile($args)
	{
		$data['content'] = $this->view->render('templates/user/profile.phtml');
		return $this->render($data);
	}
}
