<?php

/**
 * This file is part of GoogleChart PHP library.
 */

/**
 * A chart.
 */
class GoogleChart
{
	const BASE_URL = 'http://chart.apis.google.com/chart';

	private $parameters = array();
	private $type = '';
	private $width = '';
	private $height = '';
	private $_tainted = true;
	
	private $data = array();
	private $axes = array();

	private $url = '';

	public function __construct($type, $width, $height)
	{
		$this->type = $type;
		$this->width = $width;
		$this->height = $height;
		$this->_tainted = true;
	}
	
	public function __set($name, $value)
	{
		$this->parameters[$name] = $value;
		$this->_tainted = true;
	}

	public function __get($name)
	{
		return $this->parameters[$name];
	}

	public function addData(GoogleChartData $data)
	{
		$this->data[] = $data;
		return $this;
	}

	public function addAxis(GoogleChartAxis $axis)
	{
		$this->axes[] = $axis;
		return $this;
	}

	protected function computeUrl()
	{
		$q = array_merge($this->parameters, array(
			'cht' => $this->type,
			'chs' => $this->width.'x'.$this->height
		));

		$this->computeData($q);
		$this->computeAxes($q);

		$this->url = urldecode(self::BASE_URL.'?'.http_build_query($q));
	}

	protected function computeData(array & $q)
	{
		$data = array();
		$colors = array();
		$styles = array();
		$fills = array();

		$value_max = 0;
		foreach ( $this->data as $i => $d ) {
			$values = $d->getValues();
			$max = max($values);
			if ( $max > $value_max ) {
				$value_max = $max;
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
			$q['chds'] = '0,'.($value_max + round(10*$value_max/100));
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
		}
		if ( isset($axes[0]) ) {
			$q['chxt'] = implode(',',$axes);
			if ( isset($labels[0]) ) {
				$q['chxl'] = implode('|',$labels);
			}
			if ( isset($ranges[0]) ) {
				$q['chxr'] = implode('|', $ranges);
			}
		}

		return $this;
	}

	public function getUrl()
	{
		if ( $this->_tainted ) {
			$this->computeUrl();
			$this->_tainted = false;
		}
		return $this->url;
	}

	public function validate()
	{
		$url = $this->getUrl().'&chof=validate';
		return file_get_contents($url);
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
