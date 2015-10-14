

https://developers.google.com/chart/image/docs/gallery/scatter_charts

# Scatter chart specifics #

A scatter chart (or scatter plot) is a set of individual dots on a two-dimensional chart. You can optionally specify the size of the individual dots.

The default API can only accept one data series. Google Chart PHP Library tries to aleviates this limitation by implemeting multiple series simulation.

Each data series must be an array of points (array). Each point has 2 required parameters : x value and y value, and a third optional parameter for the point size (10 by default).

Example:

```
$data = array(
	array(1, 1, 10),
	array(2, 2, 20),
	array(3, 3, 30)
);

$data = new GoogleChartData($data);
$data->setColor('FF0000');
$chart->addData($data);
```