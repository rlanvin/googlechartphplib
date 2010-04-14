<?php

/**
 * This file is part of GoogleChart PHP library.
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
	 *
	 * @param number $start_val A number, defining the low value for this axis.
	 * @param number $end_val A number, defining the high value for this axis.
	 * @param number|null $step [Optional] The count step between ticks on the axis. There is no default step value; the step is calculated to try to show a set of nicely spaced labels.
	 *
	 * @see http://code.google.com/apis/chart/docs/gallery/line_charts.html#axis_range
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

		$range = '%d,'.$this->range['start_val'].','.$this->range['end_val'];
		if ( $this->range['step'] )
			$range .= ','.$this->range['step'];
		return $range;
	}
}
