<?php

require('../lib/GoogleChart.class.php');
require('../lib/GoogleChartData.class.php');
require('../lib/GoogleChartAxis.class.php');

$chart = new GoogleChart('lc', 500, 200);

$sin = array();
$cos = array();
for ($i = 0; $i <= 360; $i += 10) {
	$sin[] = round(sin($i * M_PI / 180),2);
	$cos[] = round(cos($i * M_PI / 180),2);
}

$sin = new GoogleChartData($sin);
$cos = new GoogleChartData($cos);
$chart->addData($sin);
$chart->addData($cos);

$sin->setColor('4D89F9');
$cos->setColor('C6D9FD');
$cos->setStyle(10,10,2);
$sin->setFill('eeeeee');
$x_axis = new GoogleChartAxis('x');
$y_axis = new GoogleChartAxis('y');
//~ $chart->addAxis($x_axis);
$chart->addAxis($y_axis);
$y_axis->setRange(-1.5, 1.5);
//~ $y_axis->setTickMarks(1,10);
$x_axis->setTickMarks(1,10);
$y_axis->setStyle(null, null, GoogleChartAxis::ALIGN_RIGHT, GoogleChartAxis::DRAW_BOTH);

//~ $chart->chxs = '0,336699,12,1';
//~ $chart->chxs = '1,336699,12,-1';


echo $chart->getUrl().'<br />';
//~ header('Content-Type: image/png');
//~ echo $chart->getChartImage();

echo $chart;

echo $chart->validate();
