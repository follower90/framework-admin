<?php

namespace App\Service;

use Core\Orm;

class Comments
{
	private static $_instance;

	private $_entity;
	private $_id;

	public static function load($entity, $id)
	{
		if (!static::$_instance) {
			static::$_instance = new static($entity, $id);
		}

		return static::$_instance;
	}

	private function __construct($entity, $id)
	{
		$this->_entity = $entity;
		$this->_id = $id;
	}

	public function getComments($limit = false)
	{
		$params = [];

		if ($limit) {
			$params = ['limit' => (int)$limit];
		}

		$data = Orm::find('Comment', ['entity', 'entityId'], [$this->_entity, $this->_id], $params)->getData();

		return array_map(function(&$comment) {
			$comment['user'] = Orm::load('User', $comment['userId'])->getValue('login');
			return $comment;
		}, $data);
	}

	public function addComment($text, $replyToCommentId = null)
	{
		$user = \Core\App::getUser();
		$comment = Orm::create('Comment');
		$comment->setValues([
			'userId' => $user->getId(),
			'entity' => $this->_entity,
			'entityId' => $this->_id,
			'parentId' => $replyToCommentId,
			'text' => $text
		]);

		$comment->save();
	}
}
