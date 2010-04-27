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

/**
 * A Marker.
 */
abstract class GoogleChartMarker
{
	protected $data = null;
	protected $type = null;

	protected $color = '336699';
	protected $z_order = null;

	public function setColor($color)
	{
		$this->color = $color;
		return $this;
	}

	public function getColor($color)
	{
		return $this->color;
	}

	public function setZOrder($z_order)
	{
		if ( $z_order < -1 || $z_order > 1 )
			throw new InvalidArgumentException('Invalid Z-order (must be between -1.0 and 1.0)');

		$this->z_order = $z_order;
		return $this;
	}

	public function getZOrder($z_order)
	{
		return $this->z_order;
	}

	public function setData(GoogleChartData $data)
	{
		$this->data = $data;
		return $this;
	}
	
	public function getData()
	{
		return $this->data;
	}
	
	abstract public function compute($index);
}
