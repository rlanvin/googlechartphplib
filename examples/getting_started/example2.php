<?php

// don't forget to update the path here
require '../../lib/GoogleChart.php';

$chart = new GoogleChart('lc', 500, 200);

// add one line
$data = new GoogleChartData(array(49,74,78,71,40,39,35,20,50,61,45));
$chart->addData($data);

// we generate the image directly as a PNG
header('Content-Type: image/png');
echo $chart;
