<?php

namespace App\View;

class Comments
{

	public function setup($entity)
	{
		$commentsData = \App\Service\Comments::load($entity->getClassName(), $entity->getId())->getComments()->getData();
	}

	public function render()
	{

	}
}
