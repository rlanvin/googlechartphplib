<?php

require '../lib/GoogleChart.php';

$sin = array();
$cos = array();
for ($i = 0; $i <= 360; $i += 10) {
	$sin[] = round(sin($i * M_PI / 180),2);
	$cos[] = round(cos($i * M_PI / 180),2);
}

$chart = new GoogleChart('lc', 500, 200);
$sin = new GoogleChartData($sin);
$chart->addData($sin);

$cos = new GoogleChartData($cos);
$cos->setStyle(2,2,2); // dotted
$chart->addData($cos);

$y_axis = new GoogleChartAxis('y');
$y_axis->setRange(-1,1);
$chart->addAxis($y_axis);

$x_axis = new GoogleChartAxis('x');
$x_axis->setRange(0,360);
$chart->addAxis($x_axis);

header('Content-Type: image/png');
echo $chart;
