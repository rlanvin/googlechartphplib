<?php

require '../lib/GoogleMapChart.php';

$chart = new GoogleMapChart(440,220);
$chart->addData(new GoogleChartData(array(
	'FR' => 10,
	'FI' => 20,
	'GB' => 30,
	'DE' => 40,
	'US' => 50
)));

header('Content-Type: image/png');
echo $chart;
