<?php


require '../lib/GoogleVennDiagram.php';

//~ $chart = new GoogleVennDiagram(300, 150);

//~ $data = new GoogleChartData(array(10,10));
//~ $data->setColor(array('FF0000', '00FF00'));
//~ $data->setLegends(array('A','B'));
//~ $chart->addData($data);

//~ $chart->setIntersectAB(1);

//~ var_dump($chart->getQuery());
//~ printf('<iframe src="%s" width="500" height="500"></iframe>',$chart->getValidationUrl());
//~ echo $chart->toHtml();

//~ unset($chart);

$chart = new GoogleVennDiagram(300, 150);

$data = new GoogleChartData(array(10,20,30));
$data->setColor(array('FF0000', '00FF00', '0000FF'));
$data->setLegends(array('A','B','C'));
$data->setLabels(array('A','B','C'));
$chart->addData($data);

$chart->setIntersectAB(1);
$chart->setIntersectAC(2);
$chart->setIntersectBC(3);


var_dump($chart->getQuery());
printf('<iframe src="%s" width="500" height="500"></iframe>',$chart->getValidationUrl());
echo $chart->toHtml();
//~ echo $chart;
