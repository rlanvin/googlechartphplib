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
	
	/**
	 * Line style
	 */
	public function testChls()
	{
		$data = new GoogleChartData(array());
		$this->assertEquals($data->computeChls(), $data->getThickness());

		$data->setThickness(5);
		$this->assertEquals($data->getThickness(), '5');
		$this->assertEquals($data->computeChls(), '5');

		$data->setDash(2);
		$this->assertEquals($data->computeChls(), '5,2');
		
		$data->setDash(2,3);
		$this->assertEquals($data->computeChls(), '5,2,3');
		
		$data->setDash(null, 3);
		$this->assertEquals($data->computeChls(), '5');

		$data = new GoogleChartData(array());
		$data->setDash(2,3);
		$this->assertEquals($data->computeChls(), '2,2,3');
	}
	
	/**
	 * Label
	 */
	public function testChl()
	{
		$data = new GoogleChartData(array(10,20,30));
		$this->assertEquals($data->computeChl(), '||');
		
		$data->setLabels(array('Foo','Bar','?'));
		$this->assertEquals($data->computeChl(), 'Foo|Bar|?');
	}
}

