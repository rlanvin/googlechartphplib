<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__).'/../lib/GoogleChart.php';

/**
 * Test class for GoogleChart.
 *
 */
class GoogleChartTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var GoogleChart
	 */
	protected $chart;

	protected function setUp()
	{
		$this->chart = new GoogleChart('lc',200,200);
		
	}

	protected function tearDown()
	{
	}

	public function testAddDataSetIndex()
	{
		$data = new GoogleChartData(array());
		$this->chart->addData($data);
		$index = $data->getIndex();
		$this->assertEquals($index, 0);
	}
	
	/**
	 * @expectedException LogicException
	 */
	public function testCannotAddDataTwice()
	{
		$data = new GoogleChartData(array());
		$this->chart->addData($data);
		$this->chart->addData($data);
	}
}
