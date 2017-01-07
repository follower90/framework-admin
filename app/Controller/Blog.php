<?php

namespace App\Controller;

use \Admin\Object\Blog as _Blog;
use \App\Service\Page_View as PageViewService;

class Blog extends Controller
{
	public function methodIndex($args)
	{
		if (!$args['url'] || $args['url'] === 'all') {
			$data = [
				'breadcrumbs' => $this->getBreadcrumbs(),
				'blogs' => _Blog::active()->getData()
			];

			$content = $this->view->render('templates/blog/list.phtml', $data);
		} else {
			$blog = _Blog::active()->findFirstBy('url', $args['url']);
			if (!$blog) $this->render404();

			$data = [
				'breadcrumbs' => $this->getBreadcrumbs($blog->id),
				'blog' => $blog->getValues(),
				'views' => PageViewService::view($blog->id, 'blog')
			];

			$content = $this->view->render('templates/blog/entry.phtml', $data);
		}

		return $this->render(['content' => $content]);
	}

	private function getBreadcrumbs($blogId = null)
	{
		$data = [
			['url' => '/blog/', 'name' => __('Blog')]
		];

		if (!$blogId) {
			array_push($data, ['name' => __('All')]);
		} else {
			$blog = _Blog::find($blogId);
			array_push($data, ['name' => $blog->name]);
		}

		return $this->renderBreadCrumbs($data);
	}
}
