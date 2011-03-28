<?php


require '../lib/GoogleScatterChart.php';

$chart = new GoogleScatterChart(300, 150);
//~ $chart->setScale(0,100);
$chart->setDataFormat(GoogleChart::EXTENDED_ENCODING);

//~ $data = new GoogleChartData(array(10,15,25,30,45,55,58));
//~ $data->setLegend('Foobar');
//~ $chart->addData($data);

$data = array();
for ( $x = 2; $x < 4; $x++ ) {
	for ( $y = 1; $y < 4; $y++ ) {
		$data[] = array($x,$y,rand(10,100));
		//~ $data[] = array(rand(1,100),rand(1,100),rand(1,100));
	}
}
//~ var_dump($data);

// no legend for this data serie
$data = new GoogleChartData($data);
$data->setColor('FF0000');
$data->setLegend('Dog');
$chart->addData($data);

var_dump($chart->getQuery());
printf('<iframe src="%s" width="500" height="500"></iframe>',$chart->getValidationUrl());
echo $chart->toHtml();
//~ header('Content-Type:image/png');
//~ echo $chart;


$data = array();
for ( $x = 0; $x < 3; $x++ ) {
	for ( $y = 0; $y < 2; $y++ ) {
		$data[] = array($x,$y,rand(10,100));
		//~ $data[] = array(rand(1,100),rand(1,100),rand(1,100));
	}
}
//~ var_dump($data);

$data = new GoogleChartData($data);
$data->setColor('0000FF');
$data->setLegend('Cats');
$chart->addData($data);

var_dump($chart->getQuery());
printf('<iframe src="%s" width="500" height="500"></iframe>',$chart->getValidationUrl());
echo $chart->toHtml();
