<?php

namespace App\Api;

class Comments extends \Core\Api
{
	public function methodList($args)
	{
		$view = new \Core\View();
		$view->setDefaultPath('public/fashion');

		$comments = \App\Service\Comments::load($args['type'], $args['id'])->getComments($args['limit']);
		return ['comments' => $view->render('templates/comments/list.phtml', ['comments' => $comments])];
	}

	public function methodPost($args)
	{
		$service = \App\Service\Comments::load($args['type'], $args['id']);
		$comment = $service->addComment($args['name'], $args['text'], $args['rating']);

		$view = new \Core\View();
		$view->setDefaultPath('public/fashion');
		$data = $comment->getValues();

		return ['comment' => $view->render('templates/comments/comment.phtml', ['comment' => $data])];
	}
}
