<?php

namespace App\Controller;

use App\Routes\App;

class User extends Controller
{
	public function methodIndex()
	{
		return $this->methodProfile();
	}

	public function methodLogin($args)
	{
		if ($args['login'] && $args['password']) {
			$this->authorize($args['login'], $args['password']);
			\Core\Router::redirect('/');
		}

		$data['content'] = $this->view->render('templates/user/login.phtml');
		return $this->render($data);
	}

	public function methodLogout()
	{
		$authorizer = new \Core\Authorize('User');
		$authorizer->logout();

		\Core\Router::redirect('/');
	}

	public function methodRegister($args)
	{
		if ($args['login'] && $args['password']) {
			$user = \Core\Object\User::create();
			$user->login = $args['login'];
			$user->password = $this->hashFunc($args['password']);
			$user->save();

			$this->authorize($user->login, $user->password);
			$data['content'] = $this->view->render('templates/user/register_success.phtml');
		} else {
			$data['content'] = $this->view->render('templates/user/register.phtml');
		}

		return $this->render($data);
	}

	public function methodProfile()
	{
		if (!$user = \Core\App::get()->getUser()) {
			$this->render404();
		}

		$data['content'] = $this->view->render('templates/user/profile.phtml', ['user' => $user->getValues()]);
		return $this->render($data);
	}

	private function authorize($login, $password)
	{
		$authorizer = new \Core\Authorize('User');
		$authorizer->login($login, $password, function ($pass) {
			return $this->hashFunc($pass);
		});

		if (!$authorizer->getUser()) {
			throw new \Core\Exception\Exception('Invalid login or password');
		}
	}

	private function hashFunc($pass)
	{
		return md5($pass);
	}
}
