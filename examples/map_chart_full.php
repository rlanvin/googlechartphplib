<?php

require '../lib/GoogleMapChart.php';

$chart = new GoogleMapChart(300,150);
$chart->setArea('europe');
$chart->setColors('00ff00', array('000000','ffffff'));
$chart->setFill('99ccff');
$chart->setTitle('Countries');

$chart->addData(new GoogleChartData(array(
	'FR' => 10,
	'FI' => 20,
	'GB' => 30,
	'DE' => 40,
)));

if ( isset($_GET['debug']) ) {
	var_dump($chart->getQuery());
	echo $chart->validate();
	echo $chart->toHtml();
}
else{
	header('Content-Type: image/png');
	echo $chart;
}

