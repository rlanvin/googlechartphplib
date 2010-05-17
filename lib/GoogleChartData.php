<?php

/** @file
 * This file is part of Google Chart PHP library.
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
	 *  array An array of the values of the data serie.
	 */
	protected $values = null;
	/**
	 *  string The name of the data serie to be displayed as legend.
	 */
	protected $legend = null;


	/**
	 * Indicate if the color has been overriden.
	 * This variable is used to minimize the request. If no custom color has
	 * been providen, then the @c cho parameter is not triggered.
	 */
	protected $chco = false;
	/**
	 * Color of the data serie (string or array)
	 * Default color by Google Chart API is FF9900
	 */
	protected $color = 'ff9900';


	protected $chls = false;
	protected $thickness = 2;
	protected $dash_length = null;
	protected $space_length = null;

	/**
	 *  string Line fill values (to fill area below a line).
	 */
	protected $fill = null;
	/**
	 *  bool Wether to calculate scale automatically or not.
	 */
	protected $autoscale = true;
	/**
	 *  array The scale, as specified by the user with setScale
	 */
	protected $scale = null;
	
	/**
	 *  int Holds the index of the data serie in the chart. Null if not added.
	 */
	protected $index = null;

	/**
	 * Create a new data serie.
	 */
	public function __construct($values)
	{
		if ( $values !== null && ! is_array($values) )
			throw new InvalidArgumentException('Invalid values (must be an array or null)');

		$this->values = $values;
		
		//~ $this->setColor('4D89F9');
		//~ $this->setStyle(2);
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

	public function setAutoscale($autoscale)
	{
		$this->autoscale = $autoscale;
		return $this;
	}

	public function setScale($min, $max)
	{
		$this->setAutoscale(false);
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
			if ( ! empty($this->values) ) {
				return min($this->values).','.max($this->values);
			}
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
 * @name Data Serie Color (@c chco).
 */
//@{
	/**
	 * Set the serie color.
	 * Color can be an array for bar charts and pie charts.
	 *
	 * @param $color (mixed) a RRGGBB string, or an array for Bar Chart and Pie Chart
	 * @see http://code.google.com/apis/chart/docs/chart_params.html#gcharts_series_color
	 */
	public function setColor($color)
	{
		$this->chco = true;
		$this->color = $color;
		return $this;
	}

	public function getColor()
	{
		return $this->color;
	}
	
	public function computeChco()
	{
		if ( is_array($this->color) )
			return implode('|',$this->color);

		return $this->color;
	}

	public function hasChco()
	{
		return $this->chco;
	}
//@}

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
 * @name Line styles (chls).
 */
// @{

	/**
	 * Set the thickness of the line (Line Chart only).
	 *
	 * @see http://code.google.com/apis/chart/docs/chart_params.html#gcharts_line_styles
	 * @since 0.5
	 */
	public function setThickness($thickness)
	{
		$this->chls = true;

		$this->thickness = $thickness;
		return $this;
	}
	
	/**
	 * @since 0.5
	 */
	public function getThickness()
	{
		return $this->thickness;
	}

	/**
	 * @since 0.5
	 */
	public function setDash($dash_length, $space_length = null)
	{
		$this->chls = true;

		$this->dash_length = $dash_length;
		$this->space_length = $space_length;
		return $this;
	}
	
	/**
	 * @internal
	 * @since 0.5
	 */
	public function computeChls()
	{
		$str = $this->thickness;
		if ( $this->dash_length !== null ) {
			$str .= ','.$this->dash_length;
			if  ( $this->space_length !== null ) {
				$str .= ','.$this->space_length;
			}
		}
		return $str;
	}
	
	/**
	 * @internal
	 * @since 0.5
	 */
	public function hasChls()
	{
		return $this->chls;
	}
//@}
}
