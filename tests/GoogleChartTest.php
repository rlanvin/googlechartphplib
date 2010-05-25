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
	
	public function testChtt()
	{
		$this->assertNull($this->chart->computeChtt());

		$this->chart->setTitle('foobar');
		$this->assertEquals($this->chart->computeChtt(), 'foobar');
		
		$this->chart->setTitle("foo\nbar");
		$this->assertEquals($this->chart->computeChtt(), 'foo|bar');
	}
	
	public function testChts()
	{
		$this->assertEquals($this->chart->hasChts(), false);
		$this->assertEquals($this->chart->computeChts(),'000000,12');

		// setTitleColor()
		$this->chart->setTitleColor('00ff00');
		$this->assertEquals($this->chart->computeChts(), '00ff00,12');

		// setTitleSize()
		$this->chart->setTitleSize('20');
		$this->assertEquals($this->chart->computeChts(), '00ff00,20');

		// chts is null if no title
		$q = $this->chart->getQuery();
		$this->assertEquals(isset($q['chts']), false);
		
		// title make chts appears
		$this->chart->setTitle('foobar');
		$q = $this->chart->getQuery();
		$this->assertEquals(isset($q['chts']), true);
		$this->assertEquals($q['chts'], '00ff00,20');
	}
	
	public function testChma()
	{
		$this->assertEquals($this->chart->computeChma(), '');
		$this->assertEquals($this->chart->hasChma(), false);
		
		$this->chart->setLegendSize(500,300);
		$this->assertEquals($this->chart->computeChma(), '|500,300');
	}
}
