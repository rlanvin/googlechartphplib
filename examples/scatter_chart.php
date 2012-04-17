<?php


require '../lib/GoogleScatterChart.php';

$chart = new GoogleScatterChart(300, 150);

$x_axis = new GoogleChartAxis('x');
$chart->addAxis($x_axis);

$y_axis = new GoogleChartAxis('y');
$chart->addAxis($y_axis);
//~ $chart->setScale(0,100);
//~ $chart->setDataFormat(GoogleChart::EXTENDED_ENCODING);

$data = array(
	array(12, 98, 84),
	array(75, 27, 69),
	array(23, 56, 47),
	array(68, 58, 60),
	array(34, 18, 64),
);

$data = new GoogleChartData($data);
$data->setColor('FF0000');
$data->setLegend('Cats');
$chart->addData($data);

//~ var_dump($chart->getQuery());
//~ printf('<iframe src="%s" width="500" height="500"></iframe>',$chart->getValidationUrl());
//~ echo $chart->toHtml();


$data = array(
	array(87, 60, 23),
	array(41, 34, 81),
	array(96, 79, 94),
	array(71, 74, 93),
	array(9, 76, 54),
);

$data = new GoogleChartData($data);
$data->setColor('0000FF');
$data->setLegend('Dogs');
$chart->addData($data);

//~ var_dump($chart->getQuery());
//~ printf('<iframe src="%s" width="500" height="500"></iframe>',$chart->getValidationUrl());
//~ echo $chart->toHtml();
echo $chart;
