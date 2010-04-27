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

include_once dirname(__FILE__).'/../GoogleChartMarker.php';

/**
 * A Line marker.
 */
class GoogleChartLineMarker extends GoogleChartMarker
{
	protected $size = '2';
	protected $points = null;

	public function __construct()
	{
		
	}

	public function setSize($size)
	{
		$this->size = $size;
	}

	public function setPoints($start = null, $stop = null)
	{
		if ( $start === null && $stop === null ) {
			$this->points = null;
		}
		else {
			$this->points = array(
				'start' => $start,
				'stop' => $stop
			);
		}
		return $this;
	}

	public function compute($index)
	{
		$points = 0;
		if ( is_array($this->points) ) {
			$points = $this->points['start'].':'.$this->points['stop'];
		}

		$str = sprintf(
			'D,%s,%d,%s,%d',
			$this->color,
			$index,
			$points,
			$this->	size
		);
		
		if ( $this->z_order !== null )
			$str .= ','.$this->z_order;

		return $str;
	}
}
