<?php

/**
 * This file is part of GoogleChart PHP library.
 *
 * Copyright (c) 2010 Rémi Lanvin <remi@cloudconnected.fr>
 *
 * Licensed under the MIT license.
 *
 * For the full copyright and license information, please view the LICENSE file.
 */
 
/**
 * A Map Chart.
 */
class GoogleChartMap extends GoogleChart
{
	const MAX_WIDTH = 440;
	const MAX_HEIGHT = 220;

	protected $area = 'world';
	protected $colors = null;

	public function __construct($width, $height)
	{
		if ( $width > self::MAX_WIDTH )
			throw new InvalidArgumentException(sprintf('Max width for Map Chart is %d.', self::MAX_WIDTH));
		if ( $height > self::MAX_HEIGHT )
			throw new InvalidArgumentException(sprintf('Max height for Map Chart is %d.', self::MAX_HEIGHT));
		
		parent::__construct('t', $width, $height);
	}

	protected function compute(array & $q)
	{
		if ( ! isset($this->data[0]) )
			throw new Exception('Map Chart needs one data serie.');

		$q['chd'] = 't:'.implode(',',$this->data[0]->getValues());
		$q['chld'] = implode('',$this->data[0]->getKeys());
		$q['chtm'] = $this->area;

		if ( $this->background ) {
			$q['chf'] = $this->background;
		}

		if ( $this->colors ) 
			$q['chco'] = $this->getColors();
	}
	
	/**
	 * Geographical Area (chtm). Only for Map charts (type=t)
	 */
	public function setArea($area)
	{
		if ( $this->type !== 't' )
			throw new Exception('setArea is only supported for Map Charts');

		$this->area = $area;
	}

	public function setColors($default_color, array $color_range = null)
	{
		if ( $color_range !== null && ! isset($color_range[1]) )
			throw new Exception('Map Chart color range needs at least two values');
		
		$this->colors = array(
			'default' => $default_color === null ? 'BEBEBE' : $default_color,
			'range' => $color_range === null ? array('0000FF','FF0000') : $color_range
		);
		return $this;
	}
	
	public function getColors($compute = true)
	{
		if ( ! $compute )
			return $this->colors;

		if ( $this->colors === null )
			return null;

		return $this->colors['default'].','.implode(',', $this->colors['range']);
	}
}
