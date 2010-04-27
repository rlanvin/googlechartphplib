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
 * A Text marker.
 *
 * This class implement Text and Data Value Markers feature (@c chm).
 *
 * @par Example
 * @include marker_text.php
 *
 * @see GoogleChartMarker
 * @see http://code.google.com/apis/chart/docs/chart_params.html#gcharts_data_point_labels
 */
class GoogleChartTextMarker extends GoogleChartMarker
{
	const FLAG = 'f';
	const TEXT = 't';
	const ANNOTATION = 'A';
	const VALUE = 'N';

	public function __construct($marker_type = self::VALUE)
	{
		
	}

	/**
	 * Compute the parameter value.
	 *
	 * @note For internal use only.
	 * @param $index (int) index of the data serie.
	 * @return string
	 */
	public function compute($index)
	{
		if ( $index === null )
			throw new LogicException('Text marker requires one data serie.');

		$str = 'N';

		$str .= ','.$this->color.','.$index.',-1,10';
		
		return $str;
	}
}
