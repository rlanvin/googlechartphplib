<?php

// don't forget to update the path here
require '../../lib/GoogleChart.php';
require '../../lib/markers/GoogleChartShapeMarker.php';
require '../../lib/markers/GoogleChartTextMarker.php';

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

// add a shape marker with a border
$shape_marker = new GoogleChartShapeMarker(GoogleChartShapeMarker::CIRCLE);
$shape_marker->setSize(6);
$shape_marker->setBorder(2);
$shape_marker->setData($data);
$chart->addMarker($shape_marker);

// add a value marker
$value_marker = new GoogleChartTextMarker(GoogleChartTextMarker::VALUE);
$value_marker->setData($data);
$chart->addMarker($value_marker);

header('Content-Type: image/png');
echo $chart;
