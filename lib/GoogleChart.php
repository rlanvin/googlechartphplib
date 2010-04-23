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

include_once 'GoogleChartData.php';
include_once 'GoogleChartAxis.php';

/**
 * This class represents a chart.
 *
 * When creating a new chart, you need to specify 3 things:
 * - type of the chart (see http://code.google.com/apis/chart/docs/gallery/chart_gall.html)
 * - width
 * - height
 *
 * Then you need to add data to that chart using GoogleChartData class.
 *
 * Depending on the type of chart, you can also add one or more axis using GoogleChartAxis class.
 *
 * \par Work around for unimplemented features
 *
 * You can override any parameter by setting its value in the class.
 * For example, to following code will override the background:
 *
 * \code
 *   $chart = new GoogleChart('lc', 500, 200);
 *   $chart->chf = 'b,s,cccccc';
 *   var_dump($chart->getQuery());
 * \endcode
 *
 * You can use this method for working with features that are currently
 * not implemented in the library (or buggy).
 */
class GoogleChart
{
	const BASE_URL = 'http://chart.apis.google.com/chart';

	const AUTOSCALE_OFF = 0;
	const AUTOSCALE_Y_AXIS = 1;
	const AUTOSCALE_VALUES = 2;

	const GET = 0;
	const POST = 1;

	const BACKGROUND = 'bg';
	const CHART_AREA = 'c';

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

	protected $fills = null;

	protected $query_method = null;

	/**
	 * Create a new chart.
	 *
	 * @param $type (string)
	 *   Google chart type.
	 * @param $width (int)
	 * @param $height (int)
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
	 * Add a data serie to the chart.
	 *
	 * @param $data (GoogleChartData)
	 * @see GoogleChartData
	 */
	public function addData(GoogleChartData $data)
	{
		$this->data[] = $data;
		return $this;
	}

	/**
	 * Add a visible axis to the chart.
	 *
	 * @param $axis (GoogleChartAxis)
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

	/**
	 * Set autoscaling mode.
	 *
	 *
	 */
	public function setAutoscale($autoscale)
	{
		if ( ! ($autoscale === self::AUTOSCALE_OFF || $autoscale === self::AUTOSCALE_Y_AXIS || $autoscale === self::AUTOSCALE_VALUES) ) {
			throw new InvalidArgumentException('Invalid autoscale mode.');
		}
	
		$this->autoscale = $autoscale;
		return $this;
	}


/** 
 * @name Chart Legend Text and Style (chdl, chdlp)
 */
//@{

	/**
	 * Set position of the legend box (@c chdlp).
	 *
	 * The parameter is not checked so you can pass whatever you want. This way,
	 * if the Google Chart API evolves, this library will still works. However,
	 * be warned that you chart may not be displayed as expected if you pass wrong
	 * parameter.
	 *
	 * @see http://code.google.com/apis/chart/docs/chart_params.html#gcharts_legend
	 *
	 * @param $position (string)
	 *   One of the following: 'b', 'bv', 't', 'tv', 'r', 'l'
	 *   (read Google Chart Documentation for details).
	 * @return $this
	 */
	public function setLegendPosition($position)
	{
		$this->legend_position = $position;
		return $this;
	}
	
	/**
	 * Set labels order inside the legend box (chdlp).
	 *
	 * The parameter is not checked so you can pass whatever you want. This way,
	 * if the Google Chart API evolves, this library will still works. However,
	 * be warned that you chart may not be displayed as expected if you pass wrong
	 * parameter.
	 *
	 * @see http://code.google.com/apis/chart/docs/chart_params.html#gcharts_legend
	 *
	 * @param $label_order (string)
	 *   One of the following: 'l', 'r', 'a', or a list of numbers
	 *   separated by commas (read Google Chart Documentation for details).
	 * @return $this
	 */
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

//@}

	/**
	 * Specify solid or dotted grid lines on the chart. (chg)
	 *
	 * @see http://code.google.com/apis/chart/docs/chart_params.html#gcharts_grid_lines
	 */
	public function setGridLines($x_axis_step_size, $y_axis_step_size, $dash_length = false,
	                             $space_length = false, $x_offset = false, $y_offset = false)
	{
		$this->grid_lines = $x_axis_step_size.','.$y_axis_step_size;
		if ( $dash_length !== false ) {
			$this->grid_lines .= ','.$dash_length;
			if ( $space_length !== false ) {
				$this->grid_lines .= ','.$space_length;
				if ( $x_offset !== false ) {
					$this->grid_lines .= ','.$x_offset;
					if ( $y_offset !== false ) {
						$this->grid_lines .= ','.$y_offset;
					}
				}
			}
		}
		return $this;
	}

/** 
 * @name Gradient, Solid and Stripped Fills (chf)
 */
//@{
	public function setFill($color, $area = self::BACKGROUND)
	{
		if ( $area != self::BACKGROUND && $area != self::CHART_AREA ) {
			throw new InvalidArgumentException('Invalid fill area.');
		}

		$this->fills[$area] = $area.',s,'.$color;
		return $this;
	}

	public function setOpacity($opacity)
	{
		if ( $opacity < 0 || $opacity > 100 ) {
			throw new InvalidArgumentException('Invalid opacity (must be between 0 and 100).');
		}

		// 100% = 255
		$opacity = str_pad(dechex(round($opacity * 255 / 100)), 8, 0, STR_PAD_LEFT);
		
		// opacity doesn't work with other backgrounds
		$this->fills[self::BACKGROUND] = 'a,s,'.$opacity;
		
		return $this;
	}

	/**
	 * Gradient fill.
	 *
	 * @param $angle (int)
	 *  A number specifying the angle of the gradient
	 *  from 0 (horizontal) to 90 (vertical).
	 * @param $colors (array)
	 *  An array of color of the fill. Each color can be a
	 *  string in RRGGBB hexadecimal format, or an array of two values: RRGGBB
	 *  color, and color centerpoint.
	 *
	 * @see http://code.google.com/apis/chart/docs/chart_params.html#gcharts_gradient_fills
	 */
	public function setGradientFill($angle, array $colors, $area = self::BACKGROUND)
	{
		if ( $angle < 0 || $angle > 90 ) {
			throw new InvalidArgumentException('Invalid angle (must be between 0 and 90).');
		}

		if ( ! isset($colors[1]) ) {
			throw new InvalidArgumentException('You must specify at least 2 colors to create a gradient fill.');
		}

		if ( $area != self::BACKGROUND && $area != self::CHART_AREA ) {
			throw new InvalidArgumentException('Invalid area.');
		}

		$tmp = array();
		$i = 0;
		$n = sizeof($colors);
		for ( $i = 0; $i < $n; $i++ ) {
			$centerpoint = null;
			$color = null;

			if ( is_array($colors[$i]) ) {
				$c = $colors[$i];
				if ( ! isset($c[0]) ) {
					throw new InvalidArgumentException('Each color must be an array of the color code in RRGGBB and the color centerpoint.');
				}
				$color = $c[0];
				if ( isset($c[1]) ) {
					$centerpoint = $c[1];
				}
			}
			else {
				$color = $colors[$i];
			}
			// no color centerpoint, try to calculate a good one:
			if ( ! $centerpoint ) {
				$centerpoint = $i / ($n-1);
			}
			$tmp[] = $color.','.round($centerpoint,2);
		}
		
		$this->fills[$area] = $area.',lg,'.$angle.','.implode(',',$tmp);
	}
	
	public function setStripedFill($angle, array $colors, $area = self::BACKGROUND)
	{
		
	}
//@}

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
			$q['chg'] = $this->grid_lines;
		}
		if ( $this->fills ) {
			$q['chf'] = implode('|',$this->fills);
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
			if ( $a->hasCustomLabels() ) {
				$labels[] = sprintf($a->getLabels(), $i);
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