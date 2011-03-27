<?php

require '../../lib/GoogleChart.php';

$chart = new GoogleChart('lc', 500, 200);

echo $chart->toHtml();
