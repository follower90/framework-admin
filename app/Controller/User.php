<?php

namespace App\Controller;

use Core\Config;
use Core\Orm;
use Core\Router;

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
		$authorizer = new \Admin\Authorize('User');
		$authorizer->logout();

		\Core\Router::redirect('/');
	}

	public function methodRegister($args)
	{
		if ($args['login'] && $args['password']) {
			$user = \Admin\Object\User::create();
			$info = Orm::create('User_Info');

			$user->setValues([
				'login' => $args['login'],
				'password' => $this->hashFunc($args['password'])
			]);

			$user->save();

			$info->setValues($args['info']);
			$info->setValue('userId', $user->getId());
			$info->save();

			$siteName = \Admin\Object\Setting::get('sitename');
			$body = $this->view->render('templates/mail/' . Config::get('site.language') . '/registration_message.phtml', [
				'login' => $args['login'],
				'password' => $args['password'],
				'site' => $siteName,
				'name' => $args['info']['firstName'] .' '. $args['info']['lastName'],
			]);

			\App\Service\Mail::send($args['info']['email'], $siteName .' - ' . \Admin\Utils::translate('Registration successfull', 'app'), $body);

			$this->authorize($args['login'], $args['password']);
			\Core\Router::redirect('/user/registered');

		} else {
			$data['content'] = $this->view->render('templates/user/register.phtml');
			return $this->render($data);
		}
	}

	public function methodRegistered($args)
	{
		$data['content'] = $this->view->render('templates/user/register_success.phtml');
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
		$authorizer = new \Admin\Authorize('User');
		$authorizer->login($login, $password, function ($pass) {
			return $this->hashFunc($pass);
		});
	}

	private function hashFunc($password)
	{
		return md5($password);
	}
}
