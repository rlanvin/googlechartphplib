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
	
	public function testChxs()
	{
		$axis = new GoogleChartAxis('x');
		$this->assertEquals($axis->getChxs(1), null);
		
		$axis->setLabelColor('ff0000');
		$this->assertEquals($axis->getChxs(1), '1,ff0000');

		$axis->setFontSize(12);
		$this->assertEquals($axis->getChxs(1), '1,ff0000,12');
		
		$axis->setLabelAlignment(-1);
		$this->assertEquals($axis->getChxs(1), '1,ff0000,12,-1');

		$axis->setDrawLine(false);
		$this->assertEquals($axis->getChxs(1), '1,ff0000,12,-1,t');

		$axis->setDrawTickMarks(false);
		$this->assertEquals($axis->getChxs(1), '1,ff0000,12,-1,_');
		
		$axis->setTickColor('00ff00');
		$this->assertEquals($axis->getChxs(1), '1,ff0000,12,-1,_,00ff00');
	}
}

