<?php

require '../../lib/GoogleBarChart.php';

$chart = new GoogleChart('lc', 180, 150);

$data = new GoogleChartData(array(10,15,25,30,45,55,58));
$data->setLegend('Foobar');
$chart->addData($data);

// no legend for this data serie
$data = new GoogleChartData(array(5,12,28,26,30,34,32));
$data->setColor('FF0000');
$chart->addData($data);

echo $chart->toHtml();

$chart = new GoogleChart('lc', 180, 150);
$chart->setLegendPosition('b');

$data = new GoogleChartData(array(10,15,25,30,45,55,58));
$data->setLegend('Foo');
$chart->addData($data);

$data = new GoogleChartData(array(5,12,28,26,30,34,32));
$data->setLegend('Bar');
$data->setColor('FF0000');
$chart->addData($data);

echo $chart->toHtml();

$chart = new GoogleChart('lc', 180, 150);
$chart->setLegendPosition('t');
$chart->setLegendSize(18);
$chart->setLegendColor('336699');

$data = new GoogleChartData(array(10,15,25,30,45,55,58));
$data->setLegend('Foo');
$chart->addData($data);

$data = new GoogleChartData(array(5,12,28,26,30,34,32));
$data->setLegend('Bar');
$data->setColor('FF0000');
$chart->addData($data);

echo $chart->toHtml();
