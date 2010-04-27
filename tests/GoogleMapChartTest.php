<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__).'/../lib/GoogleChart.php';

/**
 * Test class for GoogleChart.
 *
 */
class GoogleMapChartTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var GoogleChart
	 */
	protected $object;

	protected function setUp()
	{
		//~ $this->object = new GoogleChart;
	}

	protected function tearDown()
	{
	}
}
