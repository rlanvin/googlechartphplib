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
 * An Axis.
 */
class GoogleChartAxis
{
	private $labels = null;
	private $name = '';
	private $range = null;

	public function __construct($name)
	{
		$this->name = $name;
	}

	public function getName()
	{
		return $this->name;
	}

	/**
	 * Custom axis labels (chxl).
	 *
	 * @see http://code.google.com/apis/chart/docs/chart_params.html#axis_labels
	 */
	public function setLabels(array $labels)
	{
		$this->labels = $labels;
		return $this;
	}
	
	public function getLabels($raw_value = false)
	{
		if ( $raw_value ) {
			return $this->labels;
		}
		
		if ( $this->labels === null )
			return null;

		return '%d:|'.implode('|',$this->labels);
	}

	/**
	 * Axis ranges (chxr).
	 *
	 * Specify the range of values that appear.
	 *
	 * @see http://code.google.com/apis/chart/docs/chart_params.html#axis_range
	 */
	public function setRange($start_val, $end_val, $step = null)
	{
		$this->range = array(
			'start_val' => $start_val,
			'end_val' => $end_val,
			'step' => $step
		);
		return $this;
	}

	public function getRange($raw_value = false)
	{
		if ( $raw_value )
			return $this->range;
		
		if ( $this->range === null )
			return null;

		$str = '%d,'.$this->range['start_val'].','.$this->range['end_val'];
		if ( $this->range['step'] )
			$str .= ','.$this->range['step'];
		return $str;
	}
}
