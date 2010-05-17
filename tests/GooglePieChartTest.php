<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__).'/../lib/GooglePieChart.php';

/**
 * Test class for GooglePieChart.
 *
 */
class GooglePieChartTest extends PHPUnit_Framework_TestCase
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
	 * Labels are in sync
	 */
	public function testChl()
	{
		$values = array('Success' => 20, 'Failure' => 75, 'Unknow' => 5);

		$chart = new GooglePieChart('pc', 500, 200);
		$chart->addData(new GoogleChartData(array(10,20,30)));

		$data = new GoogleChartData(array(50,50));
		$chart->addData($data);
		
		$q = $chart->getQuery();
		$this->assertFalse(isset($q['chl']));
		
		$data->setLabels(array('Foo','Bar'));
		$q = $chart->getQuery();
		$this->assertTrue(isset($q['chl']));
		$this->assertEquals($q['chl'], '|||Foo|Bar');
		
		$chart->addData(new GoogleChartData(array(10,20,30)));
		$q = $chart->getQuery();
		$this->assertTrue(isset($q['chl']));
		$this->assertEquals($q['chl'], '|||Foo|Bar');
	}
}

