<?php

require '../lib/GooglePieChart.php';

$values = array(20,80);

$chart = new GooglePieChart('p', 500, 200);
$data = new GoogleChartData($values);
$data->setLegend(array('Success', 'Failure'));

$chart->addData($data);

if ( isset($_GET['debug']) ) {
	var_dump($chart->getQuery());
	echo $chart->validate();
	echo $chart->toHtml();
}
else {
	header('Content-Type: image/png');
	echo $chart;
}
