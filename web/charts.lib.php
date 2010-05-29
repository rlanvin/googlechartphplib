<?php

require '../lib/GoogleChart.php';
require '../lib/markers/GoogleChartShapeMarker.php';
require '../lib/markers/GoogleChartTextMarker.php';
require '../lib/GooglePieChart.php';
require '../lib/GoogleMapChart.php';
require '../lib/icons/GoogleChartIconNote.php';

function logo()
{
	$chart = new GoogleChart('ls', 130, 70);
	$chart->setMargin(5);
	$chart->setFill('73A2BD');

	$line = new GoogleChartData(array(10,80,30,60, 30,50,100));
	$line->setThickness(4);
	$line->setFill('86B4CF');
	$chart->addData($line);

	$m = new GoogleChartShapeMarker(GoogleChartShapeMarker::CIRCLE);
	$m->setData($line);
	$m->setColor('ff9900');
	$m->setSize(8);
	$m->setBorder(2, '73A2BD');
	$chart->addMarker($m);

	$x_axis = new GoogleChartAxis('x');
	$x_axis->setLabels(array('08', ' ', ' ','09', ' ', ' ', '10'));
	$x_axis->setLabelColor('ffffff');
	$x_axis->setTickMarks(5, 3, 3);
	$x_axis->setTickColor('ffffff');
	$chart->addAxis($x_axis);
	
	return $chart->getUrl();
}
function flickr()
{
	$chart = new GoogleChart('lc', 500, 154);
	$chart->setAutoscale(GoogleChart::AUTOSCALE_VALUES);
	$chart->setGridLines(0,50, 3,2);
	$chart->setMargin(10);

	$values = array(34,18,21,70,53,39,39,30,13,15,4,8,5,8,4,8,44,16,16,3,10,7,5,20,20,28,44,null);
	$line = new GoogleChartData($values);
	$line->setColor('000000');
	$line->setThickness(3);
	$line->setFill('eeeeee');
	$chart->addData($line);

	$m = new GoogleChartShapeMarker(GoogleChartShapeMarker::CIRCLE);
	$m->setData($line);
	$m->setColor('000000');
	$m->setSize(7);
	$m->setBorder(2);
	$chart->addMarker($m);

	$values = array_fill(0,sizeof($values)-2, null);
	$values[] = 44;
	$values[] = 34;

	$line2 = new GoogleChartData($values);
	$line2->setColor('000000');
	$line2->setThickness(3);
	$line2->setDash(4,2);
	$line2->setFill('eeeeee');
	$chart->addData($line2);

	$m = new GoogleChartShapeMarker(GoogleChartShapeMarker::CIRCLE);
	$m->setData($line2);
	$m->setColor('ffffff');
	$m->setSize(4);
	$m->setBorder(4,'000000');
	$m->setPoints(-1);
	$chart->addMarker($m);

	$y_axis = new GoogleChartAxis('y');
	$y_axis->setDrawLine(false);
	$y_axis->setDrawTickMarks(false);
	$y_axis->setLabels(array(null,35,70));
	$y_axis->setFontSize(9);
	$y_axis->setTickMarks(5);
	$y_axis->setTickColor('ffffff');
	$chart->addAxis($y_axis);

	$x_axis = new GoogleChartAxis('x');
	$x_axis->setDrawLine(false);
	$x_axis->setLabels(array('27 apr','04 may','11 may','18 may'));
	$x_axis->setLabelPositions(0,25.8,51.8,77.6);
	$x_axis->setTickMarks(5);
	$x_axis->setFontSize(9);
	$chart->addAxis($x_axis);
	
	return $chart->getUrl();
}

function sin_cos()
{
	$sin = array();
	$cos = array();
	for ($i = 0; $i <= 360; $i += 10) {
		$sin[] = round(sin($i * M_PI / 180),2);
		$cos[] = round(cos($i * M_PI / 180),2);
	}

	$chart = new GoogleChart('lc', 500, 200);
	$chart->setGridLines(25, 50, 1, 1);
	$chart->setMargin(30, 50);
	$chart->setLegendSize(100,10);
	$chart->setFill('333333');
	$chart->setFill('444444', GoogleChart::CHART_AREA);
	$chart->setTitle('Sinus & Cosinus');
	$chart->setTitleColor('FFFFFF');
	$chart->setTitleSize(18);

	$sin = new GoogleChartData($sin);
	$sin->setLegend('Sinus');
	$sin->setThickness(2);
	$sin->setColor('D1F2A5');
	$chart->addData($sin);

	$cos = new GoogleChartData($cos);
	$cos->setLegend('Cosinus');
	$cos->setThickness(2);
	$cos->setColor('F56991');
	$chart->addData($cos);

	$y_axis = new GoogleChartAxis('y');
	$y_axis->setDrawLine(false);
	$y_axis->setRange(-1,1);
	$y_axis->setLabelColor('ffffff');
	$chart->addAxis($y_axis);

	$x_axis = new GoogleChartAxis('x');
	$x_axis->setDrawLine(false);
	$x_axis->setRange(0,360);
	$x_axis->setLabels(array(0, 90, 180, 270, 360));
	$x_axis->setLabelColor('ffffff');
	$chart->addAxis($x_axis);
	
	return $chart->getUrl();
}

function bar()
{
	$values = array(10,20,30,40,50,60,70,60,50,40,30,20,10);

	$chart = new GoogleChart('bvs', 400, 200);
	$chart->setGridLines(100, 20, 1, 1);
	$chart->setFill('9FC2D6', GoogleChart::CHART_AREA);
	$chart->setFill('73A2BD');
	$data = new GoogleChartData($values);
	$chart->addData($data);

	$marker = new GoogleChartTextMarker();
	$marker->setData($data);
	$marker->setColor('ffeaad');
	$marker->setSize(14);
	$marker->setPlacement(GoogleChartTextMarker::CENTER, GoogleChartTextMarker::BAR_BASE, 0, 5);
	$chart->addMarker($marker);

	$y_axis = new GoogleChartAxis('y');
	$chart->addAxis($y_axis);


	return $chart->getUrl();
}

function pie()
{
	$chart = new GooglePieChart('p', 300, 200);
	$chart->setFill('73A2BD');
	$data = new GoogleChartData(array(60,30,10));
	$data->setColor(array('8ae234','73d216','4e9a06'));
	$chart->addData($data);
	$data->setLabels(array('60%','30%', '10%'));
	$chart->setRotationDegree(25);
	
	return $chart->getUrl();
}

function map()
{
	$chart = new GoogleMapChart(440,220);
	$chart->addData(new GoogleChartData(array(
		'FR' => 20,
		'FI' => 30,
		'GB' => 50,
		'DE' => 70,
		'US' => 100
	)));
	$chart->setColors('ffffff', array('ffffff','FF0000'));
	$chart->setFill('86B4CF');

	return $chart->getUrl();
}

function pacman()
{
	$chart = new GooglePieChart('p', 130, 100);
	$data = new GoogleChartData(array(80,-20));
	$data->setColor('f9f900');
	$chart->addData($data);
	$chart->setFill('73A2BD');

	// I pass null to enable the "legend" trick
	$data = new GoogleChartData(null);
	$data->setColor('73A2BD');
	$data->setLegend('O O O');
	$chart->addData($data);

	$chart->setLegendPosition('r');
	$chart->setRotation(0.628);

	return $chart->getUrl();
}

function sparklines()
{
	$values = array(34,18,21,70,53,39,39,30,13,15,24,78,85,88,74,98,44,16,16,33,50,47,55,20,20,28,44);

	$chart = new GoogleChart('ls', 75, 30);
	$chart->setFill('73A2BD');
	$data = new GoogleChartData($values);
	$data->setThickness(1);
	$data->setColor('C02942');
	$data->setFill('D95B43');

	$chart->addData($data);
	return $chart->getUrl();
}

function current_version($version = '0.4')
{
	$text = "Current version\n is ".$version;
	$chart = new GoogleChartIconNote($text);
	$chart->setTitle('Beta');
	$chart->setTextColor('D01F3C');
	return sprintf(
		'<img src="%s" alt="%s" >',
		$chart->getUrl(),
		$text
	);
}
