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

include_once 'GoogleChartData.class.php';
include_once 'GoogleChartAxis.class.php';

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

	const AUTOSCALE_OFF = 0;
	const AUTOSCALE_Y_AXIS = 1;
	const AUTOSCALE_VALUES = 2;

	const GET = 0;
	const POST = 1;

	protected $type = '';
	protected $width = '';
	protected $height = '';
	
	protected $data = array();
	protected $axes = array();
	protected $grid_lines = null;
	protected $parameters = array();

	protected $autoscale = null;
	protected $autoscale_axis = null;

	protected $legend_position = null;
	protected $legend_label_order = null;
	protected $legend_skip_empty = true;

	protected $query_method = null;

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

		$this->setAutoscale(self::AUTOSCALE_Y_AXIS);
		$this->setQueryMethod(self::POST);
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

		// auto-scale data on the first y axis
		if ( $axis->getName() == 'y' && $this->autoscale_axis === null )
			$this->autoscale_axis = $axis;

		return $this;
	}

	public function setAutoscale($autoscale)
	{
		$this->autoscale = $autoscale;
		return $this;
	}

	public function setLegendPosition($position)
	{
		$this->legend_position = $position;
		return $this;
	}
	
	public function setLegendLabelOrder($label_order)
	{
		$this->legend_label_order = $label_order;
		return $this;
	}

	public function setLegendSkipEmpty($skip_empty)
	{
		$this->legend_skip_empty = $skip_empty;
		return $this;
	}

	public function getLegendOptions()
	{
		$str = '';
		if ( $this->legend_position !== null ) {
			$str .= $this->legend_position;
		}
		if ( $this->legend_skip_empty === true ) {
			$str .= 's';
		}
		if ( $this->legend_label_order !== null ) {
			$str .= '|'.$this->legend_label_order;
		}
		return $str;
	}

	public function hasCustomLegendOptions()
	{
		return $this->legend_skip_empty === true || $this->legend_position !== null || $this->legend_label_order !== null;
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

		$this->compute($q);

		$q = array_merge($q, $this->parameters);

		return $q;
	}

	protected function compute(array & $q)
	{
		if ( $this->grid_lines ) {
			$q['chg'] = $this->getGridLines();
		}
		$this->computeData($q);
		$this->computeAxes($q);
	}

	protected function computeData(array & $q)
	{
		$data = array();
		$colors = array();
		$styles = array();
		$fills = array();

		$scales = array();
		$scale_needed = false;

		$legends = array();
		$legends_needed = false;

		$value_min = 0;
		$value_max = 0;
		foreach ( $this->data as $i => $d ) {
			$values = $d->getValues();
			if ( $this->autoscale == self::AUTOSCALE_VALUES ) {
				$max = max($values);
				$min = min($values);
				if ( $max > $value_max ) {
					$value_max = $max;
				}
				if ( $min < $value_min ) {
					$value_min = $min;
				}
			}
			elseif ( $this->autoscale == self::AUTOSCALE_OFF ) {
				// register every values, just in case
				$scales[] = $d->getScale();
				// but do not trigger if not needed
				if ( $d->hasCustomScale() ) {
					$scale_needed = true;
				}
			}
			$data[] = implode(',',$values);
			$colors[] = $d->getColor();
			$styles[] = $d->getStyle();
			$tmp = $d->getFill();
			if ( $tmp ) {
				$fills[] = sprintf($tmp, $i);
			}
			
			$legends[] = $d->getLegend();
			if ( $d->hasCustomLegend() ) {
				$legends_needed = true;
			}
		}
		if ( isset($data[0]) ) {
			$q['chd'] = 't:'.implode('|',$data);
			$q['chco'] = implode(',',$colors);
			$q['chls'] = implode('|',$styles);
			
			// autoscale
			switch ( $this->autoscale ) {
				case self::AUTOSCALE_Y_AXIS:
					if ( $this->autoscale_axis !== null ) {
						$range = $this->autoscale_axis->getRange(false);
						if ( $range !== null ) {
							$q['chds'] = $range['start_val'].','.$range['end_val'];
						}
					}
					break;
				case self::AUTOSCALE_VALUES:
					$q['chds'] = $value_min.','.$value_max;
					break;
				// if autoscale if off, then we compute manual scale
				case self::AUTOSCALE_OFF:
					if ( $scale_needed ) {
						$q['chds'] = implode(',', $scales);
					}
			}
			
			// labels
			if ( $legends_needed ) {
				$q['chdl'] = implode('|',$legends);
				if ( $this->hasCustomLegendOptions() ) {
					$q['chdlp'] = $this->getLegendOptions();
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

	public function setQueryMethod($method)
	{
		if ( $method !== self::POST && $method !== self::GET )
			throw new Exception(sprintf(
				'Query method must be either POST or GET, "%s" given.',
				$method
			));
		
		$this->query_method = $method;
		return $this;
	}

	/**
	 * Returns the full URL.
	 *
	 * Use this method if you need to link Google's URL directly, or if you
	 * prefer to use your own library to GET the chart.
	 */
	public function getUrl()
	{
		$q = $this->computeQuery();
		$url = self::BASE_URL.'?'.http_build_query($q);
		return $url;
	}

	/**
	 * Returns the query parameters as an array.
	 *
	 * Use this method if you want to do the POST yourself.
	 */
	public function getQuery()
	{
		return $this->computeQuery();
	}

	public function toHtml()
	{
		$str = sprintf(
			'<img src="%s" width="%d" height="%d" alt="" />',
			$this->getUrl(),
			$this->width,
			$this->height
		);
		return $str;
	}

	/**
	 * Query Google Chart and returns the image.
	 *
	 * @see setQueryMethod
	 */
	public function getImage()
	{
		$image = null;

		switch ( $this->query_method ) {
			case self::GET:
				$url = $this->getUrl();
				$image = file_get_contents($url);
				break;
			case self::POST:
				$image = self::post($this->computeQuery());
				break;
		}

		return $image;
	}

	public function __toString()
	{
		return $this->getImage();
	}

	/**
	 * Utility function. Performs a POST.
	 */
	static private function post(array $q = array())
	{
		$context = stream_context_create(array(
			'http' => array(
				'method' => 'POST',
				'header'  => 'Content-type: application/x-www-form-urlencoded',
				'content' => http_build_query($q)
			)
		));

		return file_get_contents(self::BASE_URL, false, $context);
	}

/* --------------------------------------------------------------------------
 * Debug
 * -------------------------------------------------------------------------- */
 
	public function getValidationUrl()
	{
		$q = $this->computeQuery();
		$q['chof'] = 'validate';
		$url = self::BASE_URL.'?'.http_build_query($q);
		return $url;
	}

	public function validate()
	{
		$q = $this->computeQuery();
		$q['chof'] = 'validate';
		return self::post($q);
	}


}
