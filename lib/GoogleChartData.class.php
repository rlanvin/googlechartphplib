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
 * A data serie.
 */
class GoogleChartData
{
	private $values = null;
	private $legend = null;
	private $color = null;
	private $style = null;
	private $fill = null;

	private $autoscale = true;
	private $scale = null;

	public function __construct(array $values)
	{
		$this->values = $values;
		
		$this->setColor('336699');
		$this->setStyle(2);
	}
	
	public function getValues()
	{
		return $this->values;
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
	 * Color (chco).
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
		return $this->color;
	}

	/**
	 * Line fill (chm)
	 *
	 * @http://code.google.com/apis/chart/docs/chart_params.html#gcharts_line_fills
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

}
