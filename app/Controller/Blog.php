<?php

namespace App\Controller;

use Core\Orm;

class Blog extends Controller
{
	public function methodIndex($args)
	{
		if (!$args['url'] || $args['url'] === 'all') {
			$content = $this->view->render('templates/blog/list.phtml', [
				'breadcrumbs' => $this->getBreadcrumbs(),
				'blogs' => \Admin\Object\Blog::where(['active' => 1])->getData()
			]);
			return $this->render(['content' => $content]);
		} else {
			$blog = \Admin\Object\Blog::findBy(['url' => $args['url']]);
			if (!$blog) $this->render404();

			$content = $this->view->render('templates/blog/entry.phtml', [
				'breadcrumbs' => $this->getBreadcrumbs($blog->getId()),
				'blog' => $blog->getValues(),
				'views' =>  \App\Service\Page_View::view($blog->getId(), 'blog')
			]);

			return $this->render(['content' => $content]);
		}
	}

	private function getBreadcrumbs($blogId = null)
	{
		$data = [
			['url' => '/blog/', 'name' => __('Blog')]
		];

		if (!$blogId) {
			array_push($data, ['name' => __('All')]);
		} else {
			$blog = Orm::load('Blog', $blogId);
			array_push($data, ['name' => $blog->getValue('name')]);
		}

		return $this->renderBreadCrumbs($data);
	}
}
