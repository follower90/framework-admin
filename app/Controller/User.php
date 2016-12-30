<?php

namespace App\Controller;

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

			if ($this->user) $this->back();
		}

		$data['content'] = $this->view->render('templates/user/login.phtml');
		$data['breadcrumbs'] = $this->renderBreadCrumbs([['name' => __('Authorization')]]);
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

			$this->authorize($args['login'], $args['password']);

			$siteName = \Admin\Object\Setting::get('sitename');

			$mailTemplate = \Admin\Object\MailTemplate::get('registration_success');
			$body = $this->view->renderInlineTemplate(
				$mailTemplate->getValue('body'),
				[
					'login' => $args['login'],
					'password' => $args['password'],
					'site' => $siteName,
					'name' => $args['info']['firstName'] .' '. $args['info']['lastName'],
				]
			);

			\App\Service\Mail::send($args['info']['email'], $siteName .' - ' . $mailTemplate->getValue('subject'), $body);

			return $this->methodRegistrationSuccess();

		} else {
			$data['content'] = $this->view->render('templates/user/register.phtml');

			$data['breadcrumbs'] = $this->renderBreadCrumbs([['name' => __('Registration')]]);
			return $this->render($data);
		}
	}

	private function methodRegistrationSuccess()
	{
		$info = Orm::findOne('InfoBlock', ['alias'], ['register_success'])->getValues();
		$data['content'] = $this->view->render('templates/page.phtml', $info);
		return $this->render($data);
	}

	public function methodSave($args)
	{
		$user = \Core\App::get()->getUser();
		$info = Orm::findOne('User_Info', ['userId'], [$user->getId()]);

		$password = trim($args['password']);
		if ($password) {
			$user->setValue('password', $this->hashFunc($password));
			$user->save();
		}

		$info->setValues($args['info']);
		$info->save();

		Router::redirect('/user/profile');
	}

	public function methodProfile()
	{
		if (!$user = \Core\App::get()->getUser()) {
			Router::redirect('/user/login');
		}

		$data['content'] = $this->view->render('templates/user/profile.phtml', [
			'user' => $user->getValues(),
			'breadcrumbs' => $this->renderBreadCrumbs([['name' => __('Profile')]])
		]);
		
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
