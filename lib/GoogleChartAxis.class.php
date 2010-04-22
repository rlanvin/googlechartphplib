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
	const ALIGN_LEFT = -1;
	const ALIGN_CENTER = 0;
	const ALIGN_RIGHT = 1;

	const DRAW_NONE = '_';
	const DRAW_AXIS = 'l';
	const DRAW_TICK = 't';
	const DRAW_BOTH = 'lt';

	private $labels = null;
	private $name = '';
	private $range = null;
	private $tick_marks = null;
	private $style = null;

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
	
	public function getLabels($compute = true)
	{
		if ( ! $compute ) {
			return $this->labels;
		}
		
		if ( $this->labels === null )
			return null;

		return '%d:|'.implode('|',$this->labels);
	}

	public function hasCustomLabels()
	{
		return $this->labels !== null;
	}

	/**
	 * Axis ranges (chxr).
	 *
	 * Specify the range of values that appear.
	 *
	 * @see http://code.google.com/apis/chart/docs/chart_params.html#axis_range
	 */
	public function setRange($start_val, $end_val, $step = false)
	{
		$this->range = array(
			'start_val' => $start_val === null ? 0 : $start_val,
			'end_val' => $end_val === null ? 100 : $end_val,
			'step' => $step === null ? false : $step
		);
		return $this;
	}

	public function getRange($compute = true)
	{
		if ( ! $compute )
			return $this->range;
		
		if ( $this->range === null )
			return null;

		$str = '%d,'.$this->range['start_val'].','.$this->range['end_val'];
		if ( $this->range['step'] !== false )
			$str .= ','.$this->range['step'];
		return $str;
	}
	
	/**
	 * Axis Tick Mark Styles (chxtc)
	 *
	 * @see http://code.google.com/apis/chart/docs/chart_params.html#axis_tick_marks
	 */
	public function setTickMarks()
	{
		$this->tick_marks = func_get_args();
		if ( ! isset($this->tick_marks[0]) )
			$this->tick_marks = null;

		return $this;
	}
	
	public function getTickMarks($compute = true)
	{
		if ( ! $compute )
			return $this->tick_marks;
		
		if ( $this->tick_marks === null )
			return null;
		
		return '%d,'.implode(',',$this->tick_marks);
	}

	/**
	 * Axis Label Styles (chxs)
	 *
	 * @see http://code.google.com/apis/chart/docs/chart_params.html#axis_label_styles
	 */
	public function setStyle($label_color, $font_size = false, $alignment = false, $axis_or_tick = false)
	{
		$this->style = array(
			'label_color' => $label_color === null ? '666666' : $label_color,
			'font_size' => $font_size === null ? '11' : $font_size,
			'alignment' => $alignment,
			'axis_or_tick' => $axis_or_tick
		);
		return $this;
	}

	public function getStyle($compute = true)
	{
		if ( ! $compute )
			return $this->style;
		
		if ( $this->style === null )
			return null;

		$str = '%d'.$this->getLabelFormat().','.$this->style['label_color'];
		if ( $this->style['font_size'] ) {
			$str .= ','.$this->style['font_size'];
			if ( $this->style['alignment'] ) {
				$str .= ','.$this->style['alignment'];
				if ( $this->style['axis_or_tick'] ) {
					$str .= ','.$this->style['axis_or_tick'];
				}
			}
		}
		return $str;
	}
	
	public function setLabelFormat()
	{
		$this->setStyle(null);
	}

	public function getLabelFormat($compute = true)
	{
		
	}
}
