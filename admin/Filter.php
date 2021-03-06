<?php

namespace Admin;

use \Core\Session;

class Filter
{
	/**
	 * @var string $screen
	 * Controller name, action name, or other alias
	 */
	private $_screen;
	private static $_instance;

	public function __construct($screen)
	{
		$this->_screen = $screen . '_filter';
	}

	/**
	 * @param $screen
	 * Static method to get class instance
	 * @return Filter
	 */
	public static function init($screen)
	{
		if (!static::$_instance) {
			static::$_instance = new self($screen);
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
		$filters = Session::get($this->_screen);
		$filters = json_decode($filters, true);
		$filters = $filters ?: [];
		$filters[$key] = $value;

		Session::set($this->_screen, json_encode($filters));
	}

	/**
	 * @param $data array
	 * @return null
	 * Sets bulk filters
	 */
	public function setFilters($data)
	{
		foreach ($data as $key => $val) {
			$this->setFilter($key, $val);
		}
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
		$filters = Session::get($this->_screen);
		return json_decode($filters, true);
	}
}
