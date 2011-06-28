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
 * A Bar Chart.
 *
 * This class is specifically dedicated to Bar Chart. While it is technically
 * possible to create a Bar Chart with the default GoogleChart class, this class
 * takes care of all the Bar Chart specifities for you.
 *
 * @include bar_chart.php
 *
 * @see http://code.google.com/apis/chart/docs/gallery/bar_charts.html
 */
class GoogleBarChart extends GoogleChart
{
	protected $bar_width = 'a';
	protected $bar_spacing = null;
	protected $group_spacing = null;
	protected $chbh = false;

	public function setBarWidth($width)
	{
		$this->bar_width = $width;
		return $this;
	}

	/**
	 * @since 0.7
	 */
	public function setBarSpacing($space_between_bars, $space_between_groups = 4, $relative = null)
	{
		$this->chbh = true;

		$this->bar_spacing = $space_between_bars;
		$this->group_spacing = $space_between_groups;

		if ( is_bool($relative) ) {
			$this->bar_width = $relative ? 'r' : 'a';
		}

		return $this;
	}

	public function computeChbh()
	{
		$str = $this->bar_width;

		if ( $this->chbh ) {
			$str .= ','.$this->bar_spacing;
			$str .= ','.$this->group_spacing;
		}
	

		return $str;
	}
	
	protected function compute(array & $q)
	{
		$q['chbh'] = $this->computeChbh();

		parent::compute($q);
	}
}
