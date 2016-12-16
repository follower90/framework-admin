<?php

namespace App\Controller;

use Core\Orm;

class Photos extends Controller
{
	public function methodIndex($args)
	{
		if (!$args['url'] || $args['url'] === 'all') {
			$albumId = null;
			$content = $this->view->render('templates/photos/album_list.phtml', [
				'breadcrumbs' => $this->getBreadcrumbs(),
				'albums' => \Admin\Object\Photo_Album::where(['active' => 1])->getData()
			]);
			return $this->render(['content' => $content]);
		} else {
			$album = \Admin\Object\Photo_Album::findBy(['url' => $args['url']]);
			if (!$album) $this->render404();
			$albumId = $album->getId();


			$photos = Orm::find('Photo', ['albumId'], [$albumId]);

			$content = $this->view->render('templates/photos/album.phtml', [
				'breadcrumbs' => $this->getBreadcrumbs($albumId),
				'album' => $album->getValues(),
				'photos' => $photos->getData()
			]);

			return $this->render(['content' => $content]);
		}
	}

	private function getBreadcrumbs($albumId = null)
	{
		$data = [
			['url' => '/photos/', 'name' => __('Photos')]
		];

		if (!$albumId) {
			array_push($data, ['name' => __('All')]);
		} else {
			$photoAlbum = Orm::load('Photo_Album', $albumId);
			array_push($data, ['name' => $photoAlbum->getValue('name')]);
		}

		return $this->renderBreadCrumbs($data);
	}
}
