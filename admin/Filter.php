<?php

namespace Admin;

class Filter
{
	/**
	 * @var screen
	 * Controler name, action name, or other alias
	 */
	private $_screen;
	private static $_instance;

	public function __construct($screen)
	{
		$this->_screen = $screen;
	}

	/**
	 * @param $screen
	 * Static method to get class instance
	 * @return Filter
	 */
	public static function init($screen)
	{
		if (!static::$_instance) {
			static::$_instance = new \Admin\Filter($screen);
		}

		return static::$_instance;
	}

	/**
 * @param $key
 * @param $value
 * Sets filtering key=>value
 */
	public function setFilter($key, $value)
	{
		$filters = \Core\Session::get($this->_screen . '_filter');
		$filters = json_decode($filters, true);

		if (!$filters) $filters = [];
		$filters[$key] = $value;

		\Core\Session::set($this->_screen . '_filter', json_encode($filters));
	}

	/**
	 * @return mixed
	 * Sets bulk filters
	 */
	public function setFilters($data)
	{
		foreach ($data as $key => $val) $this->setFilter($key, $val);
	}

	/**
	 * @param $key
	 * @return mixed
	 * Get filter value by key
	 */
	public function getFilter($key)
	{
		$filters = $this->getFilters();
		return $filters[$key];
	}

	/**
	 * @return mixed
	 * Get all filters for screen
	 */
	public function getFilters()
	{
		$filters = \Core\Session::get($this->_screen . '_filter');
		return json_decode($filters, true);
	}
}
