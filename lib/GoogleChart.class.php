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
 * A chart.
 *
 * You can override any parameter by setting its value in the class.
 * For example, to specify the background, use:
 * <code>
 * $chart->chf = 'b,s,cccccc';
 * </code>
 *
 * You can use this method for working with features that are
 * not implemented in the library.
 */
class GoogleChart
{
	const BASE_URL = 'http://chart.apis.google.com/chart';

	private $type = '';
	private $width = '';
	private $height = '';
	
	private $data = array();
	private $axes = array();
	private $grid_lines = null;
	private $parameters = array();

	private $autoscale_axis = null;

	private $url = '';

	/**
	 * Create a new chart.
	 *
	 * @param string $type Google chart type.
	 * @param int $width
	 * @param int $height
	 *
	 * @see http://code.google.com/apis/chart/docs/gallery/chart_gall.html
	 */
	public function __construct($type, $width, $height)
	{
		$this->type = $type;
		$this->width = $width;
		$this->height = $height;
		//~ $this->_tainted = true;
	}

	public function __set($name, $value)
	{
		$this->parameters[$name] = $value;
	}

	public function __get($name)
	{
		return isset($this->parameters[$name]) ? $this->parameters[$name] : null;
	}

	public function __unset($name)
	{
		unset($this->parameters[$name]);
	}

	/**
	 * Add a data serie.
	 *
	 * @see GoogleChartData
	 */
	public function addData(GoogleChartData $data)
	{
		$this->data[] = $data;
		return $this;
	}

	/**
	 * Add a visible axis.
	 *
	 * @see GoogleChartAxis
	 */
	public function addAxis(GoogleChartAxis $axis)
	{
		$this->axes[] = $axis;

		// by default, we auto-scale data on the first y axis
		if ( $axis->getName() == 'y' && $this->autoscale_axis === null )
			$this->autoscale_axis = $axis;

		return $this;
	}

	/**
	 * Specify solid or dotted grid lines on the chart. (chg)
	 *
	 * @see http://code.google.com/apis/chart/docs/chart_params.html#gcharts_grid_lines
	 */
	public function setGridLines($x_axis_step_size, $y_axis_step_size, $dash_length = false,
	                             $space_length = false, $x_offset = false, $y_offset = false)
	{
		$this->grid_lines = array(
			'x_axis_step_size' => $x_axis_step_size,
			'y_axis_step_size' => $y_axis_step_size,
			'dash_length' => $dash_length,
			'space_length' => $space_length,
			'x_offset' => $x_offset,
			'y_offset' => $y_offset
		);
		return $this;
	}

	public function getGridLines($compute = true)
	{
		if ( ! $compute )
			return $this->grid_lines;

		if ( $this->grid_lines === null )
			return null;

		$str = $this->grid_lines['x_axis_step_size'].','.$this->grid_lines['y_axis_step_size'];
		if ( $this->grid_lines['dash_length'] !== false ) {
			$str .= ','.$this->grid_lines['dash_length'];
			if ( $this->grid_lines['space_length'] !== false ) {
				$str .= ','.$this->grid_lines['space_length'];
				if ( $this->grid_lines['x_offset'] !== false ) {
					$str .= ','.$this->grid_lines['x_offset'];
					if ( $this->grid_lines['y_offset'] !== false ) {
						$str .= ','.$this->grid_lines['y_offset'];
					}
				}
			}
		}
		return $str;
	}

/* --------------------------------------------------------------------------
 * URL Computation
 * -------------------------------------------------------------------------- */

	protected function computeQuery()
	{
		$q = array(
			'cht' => $this->type,
			'chs' => $this->width.'x'.$this->height
		);

		if ( $this->grid_lines ) {
			$q['chg'] = $this->getGridLines();
		}

		$this->computeData($q);
		$this->computeAxes($q);

		$q = array_merge($q, $this->parameters);

		//~ return urldecode(self::BASE_URL.'?'.http_build_query($q));
		return $q;
	}

	protected function computeData(array & $q)
	{
		$data = array();
		$colors = array();
		$styles = array();
		$fills = array();

		$value_min = 0;
		$value_max = 0;
		foreach ( $this->data as $i => $d ) {
			$values = $d->getValues();
			$max = max($values);
			$min = min($values);
			if ( $max > $value_max ) {
				$value_max = $max;
			}
			if ( $min < $value_min ) {
				$value_min = $min;
			}
			$data[] = implode(',',$values);
			$colors[] = $d->getColor();
			$styles[] = $d->getStyle();
			$tmp = $d->getFill();
			if ( $tmp ) {
				$fills[] = sprintf($tmp, $i);
			}
		}
		if ( isset($data[0]) ) {
			$q['chd'] = 't:'.implode('|',$data);
			$q['chco'] = implode(',',$colors);
			$q['chls'] = implode('|',$styles);
			
			// autoscale
			//~ $q['chds'] = $value_min.','.($value_max + round(10*$value_max/100));
			if ( $this->autoscale_axis !== null ) {
				$range = $this->autoscale_axis->getRange(false);
				if ( $range !== null ) {
					$q['chds'] = $range['start_val'].','.$range['end_val'];
				}
			}
		}
		if ( isset($fills[0]) ) {
			$q['chm'] = implode('|',$fills);
		}

		return $this;
	}

	protected function computeAxes(array & $q)
	{
		$axes = array();
		$labels = array();
		$ranges = array();
		$tick_marks = array();
		$styles = array();
		foreach ( $this->axes as $i => $a ) {
			$axes[] = $a->getName();
			$tmp = $a->getLabels();
			if ( $tmp !== null ) {
				$labels[] = sprintf($tmp, $i);
			}

			$tmp = $a->getRange();
			if ( $tmp !== null ) {
				$ranges[] = sprintf($tmp, $i);
			}

			$tmp = $a->getTickMarks();
			if ( $tmp !== null ) {
				$tick_marks[] = sprintf($tmp, $i);
			}
			
			$tmp = $a->getStyle();
			if ( $tmp !== null ) {
				$styles[] = sprintf($tmp, $i);
			}
		}
		if ( isset($axes[0]) ) {
			$q['chxt'] = implode(',',$axes);
			if ( isset($labels[0]) ) {
				$q['chxl'] = implode('|',$labels);
			}
			if ( isset($ranges[0]) ) {
				$q['chxr'] = implode('|', $ranges);
			}
			if ( isset($tick_marks[0]) ) {
				$q['chxtc'] = implode('|', $tick_marks);
			}
			if ( isset($styles[0]) ) {
				$q['chxs'] = implode('|', $styles);
			}
		}

		return $this;
	}

	public function getUrl($use_cache = true)
	{
		if ( ! $this->url || ! $use_cache ) {
			$this->url =  urldecode(self::BASE_URL.'?'.http_build_query($this->computeQuery()));
		}
		return $this->url;
	}

	public function validate()
	{
		$url = $this->getUrl().'&chof=validate';
		return file_get_contents($url);
	}

	public function getChartImage($method = 'post')
	{
		switch ( $method ) {
			case 'get':
				return file_get_contents($this->getUrl(false));
			case 'post':
				$context = stream_context_create(array(
					'http' => array(
						'method' => 'POST',
						'content' => http_build_query($this->computeQuery())
					)
				));
				$image = fpassthru(fopen(self::BASE_URL, 'r', false, $context));
				break;
			default:
				throw new Exception(sprintf('Unknown $method "%s". Must be "get" or "post".', $method));
		}
		return $image;
	}

	public function __toString()
	{
		$str = sprintf(
			'<img src="%s" width="%d" height="%d" alt="" />',
			$this->getUrl(),
			$this->width,
			$this->height
		);
		return $str;
		
		
	}
}
