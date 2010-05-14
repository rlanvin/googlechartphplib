<?php

require '../lib/icons/GoogleChartIconNote.php';

$chart = new GoogleChartIconNote('Hello world');
$chart->setTitle('Example');
$chart->setTextColor('D01F3C');

header('Content-Type: image/png');
echo $chart;
