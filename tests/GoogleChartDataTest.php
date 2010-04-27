<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__).'/../lib/GoogleChartData.php';

/**
 * Test class for GoogleChart.
 *
 */
class GoogleChartDataTest extends PHPUnit_Framework_TestCase
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

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testIndexIsInt()
	{
		$data = new GoogleChartData(array());
		$data->setIndex('abc');
	}
}

