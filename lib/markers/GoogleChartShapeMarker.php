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
 *
 * This class implement the Shape Marker feature (@c chm)
 *
 * @par Example
 * @include marker_shape.php
 *
 * @see http://code.google.com/apis/chart/docs/chart_params.html#gcharts_shape_markers
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
	protected $points = null;
	protected $position = null;
	protected $size = '10';

	/**
	 * Constructor.
	 *
	 * @see http://code.google.com/apis/chart/docs/chart_params.html#gcharts_shape_markers
	 * @param $shape You can specify the shape of the marker.
	 */
	public function __construct($shape = self::CIRCLE)
	{
		$this->shape = $shape;
		$this->points = array(
			'start' => null,
			'stop' => null,
			'end' => null
		);
	}

	public function setFixedPosition($x, $y)
	{
		$this->position = array(
			'x' => $x,
			'y' => $y
		);
		return $this;
	}

	public function setPoints($start = null, $end = null, $step = null)
	{
		$this->points = array(
			'start' => $start,
			'end' => $end,
			'step' => $step
		);
		return $this;
	}

	public function setStep($step)
	{
		$this->points['step'] = $step;
		return $this;
	}

	/**
	 * Set the size of the line.
	 *
	 * @param $size (int)
	 * @return $this
	 */
	public function setSize($size)
	{
		$this->size = $size;
		return $this;
	}

	public function compute($index)
	{
		if ( $index === null ) {
			if ( $this->position === null ) {
				throw new LogicException('Shape marker requires one data serie or requires to have a fixed position.');
			}

			// fixed position marker
			$str = '@';
			$points = $this->position['x'].':'.$this->position['y'];
		}
		else {
			$str = '';
			if ( $this->points['start'] === null && $this->points['end'] === null && $this->points['step'] === null ) {
				$points = -1;
			}
			elseif ( $this->points['start'] === null && $this->points['end'] === null ) {
				$points = '-'.$this->points['step'];
			}
			else {
				$points = $this->points['start'].':'.$this->points['end'].':'.$this->points['step'];
			}
		}

		$str .= sprintf(
			'%s,%s,%d,%s,%s',
			$this->shape,
			$this->color,
			$index,
			$points,
			$this->size
		);

		return $str;
	}
}

/** @example marker_shape_fixed_position.php
 * An example of a shape marker with fixed position
 */
