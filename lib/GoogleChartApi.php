<?php

/** @file
 * This file is part of GoogleChart PHP library.
 *
 * Copyright (c) 2010 Rémi Lanvin <remi@cloudconnected.fr>
 *
 * Licensed under the MIT license.
 *
 * For the full copyright and license information, please view the LICENSE file.
 */
 
/**
 * Basic feature to query the API.
 *
 * This class implement basic features to query Google Chart API using GET or
 * POST, as well as a simple way to set/get parameters.
 */
class GoogleChartApi
{
	/**
	 * Google Chart API base url.
	 */
	const BASE_URL = 'http://chart.apis.google.com/chart';

	const GET = 0;
	const POST = 1;

	protected $parameters = array();

	protected $query_method = null;

	public function __set($name, $value)
	{
		$this->parameters[$name] = $value;
	}

	public function __get($name)
	{
		return isset($this->parameters[$name]) ? $this->parameters[$name] : null;
	}

	public function __unset($name)
	{
		unset($this->parameters[$name]);
	}

	/**
	 * Compute the whole query as an array.
	 * @internal
	 */
	protected function computeQuery()
	{
		return $this->parameters;
	}


/**
 * @name Function to query Google Chart API
 */
//@{

	/**
	 * Set wether you want the class to use GET or POST for queriing the API.
	 * Default method is POST.
	 *
	 * @param $method One of the following:
	 * - GoogleChart::GET
	 * - GoogleChart::POST
	 */
	public function setQueryMethod($method)
	{
		if ( $method !== self::POST && $method !== self::GET )
			throw new Exception(sprintf(
				'Query method must be either POST or GET, "%s" given.',
				$method
			));
		
		$this->query_method = $method;
		return $this;
	}

	/**
	 * Returns the full URL.
	 *
	 * Use this method if you need to link Google's URL directly, or if you
	 * prefer to use your own library to GET the chart.
	 */
	public function getUrl()
	{
		$q = $this->computeQuery();
		$url = self::BASE_URL.'?'.http_build_query($q);
		return $url;
	}

	/**
	 * Returns the query parameters as an array.
	 *
	 * Use this method if you want to do the POST yourself.
	 */
	public function getQuery()
	{
		return $this->computeQuery();
	}

	/**
	 * Return an HTML img tag with Google's URL.
	 * Use this for debbuging or rapid application development.
	 * @return string
	 */
	public function toHtml()
	{
		$str = sprintf(
			'<img src="%s" width="%s" height="%s" alt="" />',
			$this->getUrl(),
			$this->width,
			$this->height
		);
		return $str;
	}

	/**
	 * Query Google Chart and returns the image.
	 *
	 * @see setQueryMethod
	 */
	public function getImage()
	{
		$image = null;

		switch ( $this->query_method ) {
			case self::GET:
				$url = $this->getUrl();
				$image = file_get_contents($url);
				break;
			case self::POST:
				$image = self::post($this->computeQuery());
				break;
		}

		return $image;
	}

	/**
	 * Shortcut for getImage().
	 *
	 */
	public function __toString()
	{
		try {
			return $this->getImage();
		} catch (Exception $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
		}
	}
//@}

	/**
	 * Performs a POST.
	 */
	static public function post(array $q = array())
	{
		$context = stream_context_create(array(
			'http' => array(
				'method' => 'POST',
				'header'  => 'Content-type: application/x-www-form-urlencoded',
				'content' => http_build_query($q)
			)
		));

		return file_get_contents(self::BASE_URL, false, $context);
	}

	/**
	 * Check if a color is valid RRGGBB format.
	 *
	 * @param $color (string)
	 * @return bool
	 */
	static public function validColor($color)
	{
		return preg_match('/^[0-9A-F]{6}$/i', $color);
	}

/* --------------------------------------------------------------------------
 * Debug
 * -------------------------------------------------------------------------- */
 
	public function getValidationUrl()
	{
		$q = $this->computeQuery();
		$q['chof'] = 'validate';
		$url = self::BASE_URL.'?'.http_build_query($q);
		return $url;
	}

	public function validate()
	{
		$q = $this->computeQuery();
		$q['chof'] = 'validate';
		return self::post($q);
	}
}
