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

	public function getComments()
	{
		return Orm::find('Comment', ['entity', 'entityId'], [$this->_entity, $this->_id]);
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

		var_dump($comment->getValues());
		$comment->save();
	}
}
