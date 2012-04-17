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
 
require_once 'GoogleChart.php';

/**
 * Venn Diagram
 *
 * Note that with Venn diagrams, all values are proportionate, not absolute.
 * This means that a chart with values 10,20,30 will look the same as a chart
 * with values 100,200,300 (if your encoding type accepts those values).
 */
class GoogleVennDiagram extends GoogleChart
{
	protected $_multiple_legends = true;

	protected $intersect_ab = 0;
	protected $intersect_ac = 0;
	protected $intersect_bc = 0;
	protected $intersect_abc = 0;

	public function __construct($width, $height)
	{
		$this->type = 'v';
		$this->width = $width;
		$this->height = $height;
	}

	/**
	 * The size of the intersection of A and B.
	 */
	public function setIntersectAB($n)
	{
		$this->intersect_ab = $n;
	}

	/**
	 * The size of the intersection of A and C. For a chart with only two circles, do not specify a value here.
	 */
	public function setIntersectAC($n)
	{
		$this->intersect_ac = $n;
	}
	
	/**
	 * The size of the intersection of B and C. For a chart with only two circles, do not specify a value here.
	 */
	public function setIntersectBC($n)
	{
		$this->intersect_bc = $n;
	}
	
	/**
	 * The size of the common intersection of A, B, and C. For a chart with only two circles, do not specify a value here.
	 */
	public function setIntersectABC($n)
	{
		$this->intersect_abc = $n;
	}
	
	protected function compute(array & $q)
	{
		if ( ! $this->data[0] ) {
			throw new Exception('Venn diagram needs one data series with 2 or 3 circles');
		}
		
		$values = $this->data[0]->getValues();
		if ( ! isset($values[2]) ) { // only 2 circles
			$values[2] = 0;
		}

		$values[] = $this->intersect_ab;
		
		if ( $values[2] != 0 ) {
			$values[] = $this->intersect_ac;
			$values[] = $this->intersect_bc;
			$values[] = $this->intersect_abc;
		}

		$this->data[0]->setValues($values);

		parent::compute($q);
		
		if ( isset($q['chco']) ) {
			$q['chco'] = str_replace('|',',',$q['chco']);
		}
	}
}
