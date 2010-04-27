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
 * A Shape Marker.
 */
class GoogleChartShapeMarker extends GoogleChartMarker
{
	const ARROW = 'a';
	const CROSS = 'c';
	//~ const RECTANGLE = 'C';
	const DIAMOND = 'd';
	//~ const ERROR_BAR = 'E';
	const CIRCLE = 'o';
	const SQUARE = 's';
	const X = 'x';

	protected $shape = null;

	public function __construct($shape = self::CIRCLE)
	{
		$this->shape = $shape;
	}

	public function compute($index)
	{
		$str = sprintf(
			'%s,%s,%d,-1,5',
			$this->shape,
			$this->color,
			$index
		);

		return $str;
	}
}
