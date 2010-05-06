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
 * A dynamic icon
 */
abstract class GoogleChartIcon extends GoogleChartApi
{
	protected function computeQuery()
	{
		$q = array();
		
		$q['chld'] = $this->computeChld();
		$q['chst'] = $this->computeChst();
		
		$q = array_merge($q, $this->parameters);

		return $q;
	}
}
