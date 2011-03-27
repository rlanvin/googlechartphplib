<?php

require '../../lib/GoogleBarChart.php';

$chart = new GoogleBarChart('bvs', 180, 150);

$chart->addData(array(10,15,25,30,45,55,58));

$chart->setTitle("Site visitors by month\nJanuary to July", '336699', 18);

echo $chart->toHtml();
