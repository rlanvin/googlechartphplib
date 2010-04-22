<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__).'/../lib/GoogleChartAxis.php';

/**
 * Test class for GoogleChart.
 *
 */
class GoogleChartAxisTest extends PHPUnit_Framework_TestCase
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

	public function testValidName()
	{
		$axis = new GoogleChartAxis('x');
		$axis = new GoogleChartAxis('y');
		$axis = new GoogleChartAxis('t');
		$axis = new GoogleChartAxis('r');
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testInvalidName()
	{
		$axis = new GoogleChartAxis('v');
	}
	
	public function testLabel()
	{
		$axis = new GoogleChartAxis('x');
		$axis->setLabels(array('A','B','C'));
		$this->assertEquals($axis->getLabels(), '%d:|A|B|C');
	}
}

