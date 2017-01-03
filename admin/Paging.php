<?php

namespace Admin;

use Core\Orm;
use Core\View;

class Paging
{
	/**
	 * @var string Object class name
	 */
	private $_class;

	/**
	 * @var int current page
	 */
	private $_curPage;
	/**
	 * @var int count of items on one page
	 */
	private $_onPage;

	/**
	 * @var array paging params
	 */
	private $_paging = [];

	/**
	 * @var array collection of fetched objects for one page
	 */
	private $_collection = [];

	/**
	 * @var array filter collection
	 */
	private $_filters;

	/**
	 * @var array ordering params
	 */
	private $_order;

	private function __construct($className, $currentPage, $onPage, $filters, $order)
	{
		$this->_order = $order;
		$this->_class = $className;
		$this->_filters = $filters;
		$this->_curPage = (int)$currentPage;
		$this->_onPage = (int)$onPage;
	}

	/**
	 * Return paging object
	 * @param $className
	 * @param array $params
	 * @return static
	 */
	public static function create($className, $params = [])
	{
		if (!isset($params['params'])) {
			$params['params'] = [[], []];
		}

		if (!isset($params['order'])) {
			$params['order'] = false;
		}

		$paging = new static($className, $params['current_page'], $params['page_size'], $params['params'], $params['order']);
		$paging->_calculate();

		return $paging;
	}

	/**
	 * Requests objects from database
	 * Calculates limit, offset, count
	 */
	private function _calculate()
	{
		$this->_paging['offset'] = ($this->_curPage - 1) * $this->_onPage;
		$this->_paging['limit'] = $this->_onPage;

		if ($this->_order) {
			$this->_paging['sort'] = $this->_order;
		}

		$this->_collection = Orm::find($this->_class, $this->_filters[0], $this->_filters[1], $this->_paging);

		$this->_paging['total'] = Orm::count($this->_class, $this->_filters[0], $this->_filters[1]);
		$this->_paging['items'] = $this->_collection->getCount();

		$data = [];
		$data['page'] = $this->_curPage;
		$data['onpage'] = $this->_onPage;
		$data['previous'] = $data['page'] - 1;
		$data['next'] = $data['page'] + 1;

		$this->_paging = array_merge($this->_paging, $data);
	}

	/**
	 * Creates new view with paging data
	 * @return string rendered paging template
	 */
	public function getPaging()
	{
		$view = new View();
		$view->setDefaultPath('public/admin');

		$view->paging = $this;
		return $view->render('templates/common/paging.phtml', $this->_paging);
	}

	/**
	 * Checks if collection requires paginating
	 * @return bool
	 */
	public function needsPaging()
	{
		return $this->_paging['total'] > $this->_paging['items'];
	}

	/**
	 * Returns number of first item on the page
	 * @return int
	 */
	public function firstItemOnPage()
	{
		$offset = ($this->_paging['offset'] > 0)
			? $this->_onPage
			: ($this->_paging['total'] > 0 ? 1 : 0);

		$page = ($this->_paging['page'] != 1) ? $this->_paging['page'] - 1 : 1;
		return $page * $offset;
	}

	/**
	 * Returns number of last item on the page
	 * @return int
	 */
	public function lastItemOnPage()
	{
		return $this->_paging['items'] + $this->_paging['onpage'] * ($this->_paging['page'] - 1);
	}

	/**
	 * Returns true if the page is first
	 * @return bool
	 */
	public function isFirstPage()
	{
		return $this->_paging['page'] == 1;
	}

	/**
	 * Returns true if the page is last
	 * @return bool
	 */
	public function isLastPage()
	{
		return $this->_paging['page'] * $this->_paging['onpage'] >= $this->_paging['total'];
	}

	/**
	 * Returns array of fetched objects from database
	 * required for concrete page
	 * @param $raw Boolean configures returning object or associative array
	 * @return array
	 */
	public function getObjects($raw = false)
	{
		return $raw ? $this->_collection->getCollection() : $this->_collection->getData();
	}
}
