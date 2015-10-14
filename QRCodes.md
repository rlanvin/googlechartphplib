# Example #

![http://chart.apis.google.com/chart?cht=qr&chs=150x150&chl=Hello+world&nonsense=foo.png](http://chart.apis.google.com/chart?cht=qr&chs=150x150&chl=Hello+world&nonsense=foo.png)

```
<?php
require 'lib/GoogleQRCode.php';

$chart = new GoogleQRCode(150, 150);

$chart->setData('Hello world');

header('Content-Type: image/png');
echo $chart;
```


# API Documentation #

See http://code.google.com/apis/chart/docs/gallery/qr_codes.html