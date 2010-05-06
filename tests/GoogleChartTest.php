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
		$this->assertNull($this->chart->computeChts());
		
		// chts is null if no title
		$this->chart->setTitleColor('00ff00');
		$this->assertNull($this->chart->computeChts());
		
		// title make chts appears
		$this->chart->setTitle('foobar');
		$this->assertEquals($this->chart->computeChts(), '00ff00,12');
		
		$q = $this->chart->getQuery();
		$this->assertEquals($q['chts'], '00ff00,12');

		// setTitleSize()
		$this->chart->setTitleSize('20');
		$this->assertEquals($this->chart->computeChts(), '00ff00,20');
		
		// compute works
		$q = $this->chart->getQuery();
		$this->assertEquals($q['chts'], '00ff00,20');
	}
}
