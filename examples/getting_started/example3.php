<?php

// don't forget to update the path here
require '../../lib/GoogleChart.php';

$chart = new GoogleChart('lc', 500, 200);

// manually forcing the scale to [0,100]
$chart->setScale(0,100);

// add one line
$data = new GoogleChartData(array(49,74,78,71,40,39,35,20,50,61,45));
$chart->addData($data);

// customize y axis
$y_axis = new GoogleChartAxis('y');
$y_axis->setDrawTickMarks(false)->setLabels(array(0,50,100));
$chart->addAxis($y_axis);

// customize x axis
$x_axis = new GoogleChartAxis('x');
$x_axis->setTickMarks(5);
$chart->addAxis($x_axis);

header('Content-Type: image/png');
echo $chart;
