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
 * A data serie.
 */
class GoogleChartData
{
	/**
	 * @var array An array of the values of the data serie.
	 */
	protected $values = null;
	/**
	 * @var string The name of the data serie to be displayed as legend.
	 */
	protected $legend = null;
	/**
	 * @var mixed Color of the data serie (string or array)
	 */
	protected $color = null;
	/**
	 * @var array Style of the data serie.
	 */
	protected $style = null;
	/**
	 * @var string Line fill values (to fill area below a line).
	 */
	protected $fill = null;
	/**
	 * @var bool Wether to calculate scale automatically or not.
	 */
	protected $autoscale = true;
	/**
	 * @var array The scale, as specified by the user with setScale
	 */
	protected $scale = null;
	
	/**
	 * @var int Holds the index of the data serie in the chart. Null if not added.
	 */
	protected $index = null;

	/**
	 * Create a new data serie.
	 */
	public function __construct(array $values)
	{
		$this->values = $values;
		
		$this->setColor('4D89F9');
		$this->setStyle(2);
	}
	
	/**
	 * Set the index of the data serie in the chart.
	 *
	 * @note For internal use only.
	 * @param $index (int)
	 * @return $this
	 */
	public function setIndex($index)
	{
		if ( ! is_int($index) )
			throw new InvalidArgumentException('Invalid index (must be an integer)');

		$this->index = (int) $index;
		return $this;
	}

	public function getIndex()
	{
		return $this->index;
	}

	public function hasIndex()
	{
		return $this->index !== null;
	}

	public function getValues()
	{
		return $this->values;
	}

	public function getKeys()
	{
		return array_keys($this->values);
	}

	public function setautoscale($autoscale)
	{
		$this->autoscale = $autoscale;
		return $this;
	}

	public function setScale($min, $max)
	{
		$this->scale = array(
			'min' => $min,
			'max' => $max
		);
		return $this;
	}

	public function getScale($compute = true)
	{
		if ( ! $compute )
			return $this->scale;

		if ( $this->autoscale == true ) {
			return min($this->values).','.max($this->values);
		}
		
		if ( $this->scale == null ) {
			return '0,100';
		}
		
		return $this->scale['min'].','.$this->scale['max'];
	}

	public function hasCustomScale()
	{
		return $this->scale !== null;
	}

	/**
	 * Chart Legend (chdl)
	 *
	 */
	public function setLegend($legend)
	{
		$this->legend = $legend;
		return $this;
	}

	public function getLegend()
	{
		return $this->legend;
	}

	public function hasCustomLegend()
	{
		return $this->legend !== null;
	}

	/**
	 * Color (@c chco).
	 *
	 * Set the serie color.
	 * Color can be an array for bar charts.
	 *
	 * http://code.google.com/apis/chart/docs/chart_params.html#gcharts_series_color
	 */
	public function setColor($color)
	{
		$this->color = $color;
		return $this;
	}

	public function getColor()
	{
		if ( is_array($this->color) )
			return implode('|',$this->color);

		return $this->color;
	}

	/**
	 * Line fill (chm)
	 *
	 * @see http://code.google.com/apis/chart/docs/chart_params.html#gcharts_line_fills
	 */
	public function setFill($color)
	{
		$this->fill = array(
			'color' => $color
		);
	}

	public function getFill($compute = true)
	{
		if ( ! $compute )
			return $this->fill;
		
		if ( $this->fill === null )
			return null;

		$fill = 'B,'.$this->fill['color'].',%d,0,0';

		return $fill;
	}

	/**
	 * Line styles (chls).
	 *
	 * @see http://code.google.com/apis/chart/docs/chart_params.html#gcharts_line_styles
	 */
	public function setStyle($thickness, $dash_length = false, $space_length = false)
	{
		$this->style = array(
			'thickness' => $thickness === null ? 2 : $thickness,
			'dash_length' => $dash_length === null ? 1 : $dash_length,
			'space_length' => $space_length === null ? false : $space_length
		);

		return $this;
	}

	public function getStyle($compute = true)
	{
		if ( ! $compute )
			return $this->style;

		$str = $this->style['thickness'];
		if ( $this->style['dash_length'] !== false ) {
			$str .= ','.$this->style['dash_length'];
			if  ( $this->style['space_length'] !== false ) {
				$str .= ','.$this->style['space_length'];
			}
		}
		return $str;
	}

	/**
	 * Value Markers (chm)
	 */
	public function setMarkers()
	{
	
	}
}
