<?php

require('../lib/GoogleChart.class.php');

$values = array();
for ($i = 0; $i <= 100; $i += 1) {
	$values[] = rand(20,80);
}

$chart = new GoogleChart('lc', 500, 200);
$line = new GoogleChartData($values);
$chart->addData($line);

$y_axis = new GoogleChartAxis('y');
$chart->addAxis($y_axis);


$x_axis = new GoogleChartAxis('x');
$chart->addAxis($x_axis);

header('Content-Type: image/png');
echo $chart;
