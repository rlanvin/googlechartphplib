

# Introduction #

Google Chart PHP Library is an object oriented library to create charts. It uses [Google Chart API](http://code.google.com/apis/chart/docs/making_charts.html) as a backend, and therefore it is modelled after this API. Though you can use this library without knowing the whole Google Chart API, remember that you'll probably have to look at the Google Chart API documentation in order to understand the most advanced features.

![http://code.google.com/intl/fr/apis/chart/images/chart_elements.gif](http://code.google.com/intl/fr/apis/chart/images/chart_elements.gif)

Here are a few important terms related to Google Chart API you need to know to fully understand how the library works. Some part of the following definitions are directly taken from [Google Chart API documentation](http://code.google.com/intl/fr/apis/chart/docs/making_charts.html#chart_elements).

## Data series (`GoogleChartData` class) ##

A related set of data in a chart. What constitutes a series depends on the chart type: in a line chart, a series is a single line; in a pie chart, each entry is a slice, and all slices together are a series. In a bar chart, a series is all the bars from the same set of data; different series are either grouped side by side or stacked atop each other, depending on the bar chart type. The following chart demonstrates a grouped bar chart with two series, one in dark blue, one in light blue:

![https://chart.googleapis.com/chart?cht=bvg&chs=175x75&chd=t:20,30,40|25,35,45&chco=4D89F9,C6D9FD&chdl=Cats|Dogs&chbh=10,1,6&chxt=x,y&chxl=0:|Jan|Feb|Mar&nonsense=foo.png](https://chart.googleapis.com/chart?cht=bvg&chs=175x75&chd=t:20,30,40|25,35,45&chco=4D89F9,C6D9FD&chdl=Cats|Dogs&chbh=10,1,6&chxt=x,y&chxl=0:|Jan|Feb|Mar&nonsense=foo.png)

## Axis (`GoogleChartAxis` class) ##

Charts like Line Charts and Bar Charts contains 2 to 4 axis (axis are 'x', 'y', 't' (top) or 'r' (right)). Axis can be styled in many different way, and usually display labels. Labels are numeric or text values along each axis. In the previous chart, it would be the labels "Jan," "Feb," "Mar," "0," "50," "100.".

## Compound charts ##

A chart that is a combination of two different chart types: for example, a bar chart with a line, or a line chart with candlestick markers

# Installation #

Download the last version of Google Chart PHP Library, and follow the [installation instructions](#Installation.md). Don't worry, it's very simple.

# Creating your first chart #

Charts are handled by `GoogleChart` class. Line Charts are created directly with this class, while other types of chart have their own specific sub-class (`GoogleMapChart`, `GoogleBarChart`) that offers more options.

When you instanciate a new `GoogleChart`, you need to provide 3 parameters: chart type, width and height.The chart type parameter comes directly from Google Chart API. You can have a look at [Chart Gallery](http://code.google.com/intl/fr-FR/apis/chart/docs/gallery/chart_gall.html) in order to decide which one you want to use. For the moment, let's use `lc` which is a basic [Line Chart](http://code.google.com/intl/fr-FR/apis/chart/docs/gallery/line_charts.html#chart_types) with 2 axis.

Create a PHP file `example.php`:

```
<?php

// path to where you installed the library
require '../../lib/GoogleChart.php';

$chart = new GoogleChart('lc', 500, 200);

echo $chart->toHtml();
```

Now publish it in a PHP environnent, open it in your browser, and you should see:

![http://chart.apis.google.com/chart?cht=lc&chs=500x200&nonsense=foo.png](http://chart.apis.google.com/chart?cht=lc&chs=500x200&nonsense=foo.png)

If you look at the source code of the page that has been generated, you will see the URL to Google Chart API that has been generated:

```
<img src="http://chart.apis.google.com/chart?cht=lc&amp;chs=500x200" alt="" />
```

This is the first way to use Google Chart PHP Library: the library only generate the URL to call Google Chart API.

Ok, now is time to add data, and explore different way of using the library.

# Adding Data #

To add data to your chart, you need to add a data series. You can add as many data series as you want. In a Line Chart, each data series is a line.

To create a data series, you need to use `GoogleChartData` class. This class offers a lot a methods to customize your data serie (color, size, legend, scaling...). You can also take a look a [GoogleChartData class reference](http://googlechartphplib.cloudconnected.fr/doc/classGoogleChartData.html) if you want to know more.

Let's update our example file to create a random data serie of 10 points, with a custom size:

```
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
```

Ok, it should looks a little better now:

![http://chart.apis.google.com/chart?cht=lc&chs=500x200&chd=t%3A49.00%2C74.00%2C78.00%2C71.00%2C40.00%2C39.00%2C35.00%2C20.00%2C50.00%2C61.00%2C45.00&chds=0%2C78&nonsense=foo.png](http://chart.apis.google.com/chart?cht=lc&chs=500x200&chd=t%3A49.00%2C74.00%2C78.00%2C71.00%2C40.00%2C39.00%2C35.00%2C20.00%2C50.00%2C61.00%2C45.00&chds=0%2C78&nonsense=foo.png)

In this example, the library actually queries Google Chart API, and returns the image itself as a PNG image. The advantages of this method is that you can hide the API URL, and you can implement more complex logic: caching, or further processing of the image (with libraries such as GD for example).

Note that the data are scaled: the third point (78) is the maximum value of the chart. This is called [Autoscaling](Autoscaling.md), and is activated by default with the library. We'll this in the next example of to force a scale.

# Customizing Axis #

The axis of our chart looks a little bit empty for the moment. We can customize them using `GoogleChartAxis` class. A chart support 4 types of axis (x, y, r (right) and t (top)), and can have more than one axis of the same type.

The `GoogleChartAxis` class offers many methods to customize your chart. We'll use some of them to:

  * Hide the y axis
  * Display tick marks for the x axis

Let's update our example file:

```
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
```

And now the ouput should look like that:

![http://chart.apis.google.com/chart?cht=lc&chs=500x200&chd=t%3A49.00%2C74.00%2C78.00%2C71.00%2C40.00%2C39.00%2C35.00%2C20.00%2C50.00%2C61.00%2C45.00&chds=0%2C100&chxt=y%2Cx&chxl=0%3A%7C0%7C50%7C100&chxtc=1%2C5&chxs=0%2C666666%2C11%2C1%2Cl&nonsense=foo.png](http://chart.apis.google.com/chart?cht=lc&chs=500x200&chd=t%3A49.00%2C74.00%2C78.00%2C71.00%2C40.00%2C39.00%2C35.00%2C20.00%2C50.00%2C61.00%2C45.00&chds=0%2C100&chxt=y%2Cx&chxl=0%3A%7C0%7C50%7C100&chxtc=1%2C5&chxs=0%2C666666%2C11%2C1%2Cl&nonsense=foo.png)

# Adding markers #

Markers are basically everything that is not a chart option, a data series or an axis. For example, [shape markers](http://code.google.com/intl/fr-FR/apis/chart/docs/chart_params.html#gcharts_shape_markers) allows you to display a shape on each points of a data serie, or only some points, or at a arbitrary fixed position in the chart, etc. [Text markers](http://code.google.com/intl/fr-FR/apis/chart/docs/chart_params.html#gcharts_data_point_labels) allows you to display text on the chart, either fixed text or the data values of a data serie.

Markers are also used in the creation of [Compound chart](http://code.google.com/intl/fr-FR/apis/chart/docs/gallery/compound_charts.html), but this is a more advanced topic, and we only have 15 minutes in our Getting Started tutorial. For the moment, we'll add a basic shape marker to display a dot at each point of the data serie, and a text marker to display the value of each point of the data serie.

To create a marker, you need to use a `GoogleChartMarker` class. Here we'll use `GoogleChartTextMarker` and `GoogleChartShapeMarker`. Markers class have to be loaded separetely, so don't forget to add the corrects `require`. You can take a look a [`GoogleChartMarker` class reference](http://googlechartphplib.cloudconnected.fr/doc/classGoogleChartMarker.html) to know more about the differents subclasses and methods.

We update the example file to:

```
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

//~ header('Content-Type: image/png');
echo $chart->toHtml();
```

Now the chart should looks like:

![http://chart.apis.google.com/chart?cht=lc&chs=500x200&chd=t%3A49.00%2C74.00%2C78.00%2C71.00%2C40.00%2C39.00%2C35.00%2C20.00%2C50.00%2C61.00%2C45.00&chds=0%2C100&chm=o%2Cffffff%2C0%2C-1%2C8%7Co%2C4D89F9%2C0%2C-1%2C6%7CN%2C4D89F9%2C0%2C-1%2C10&chxt=y%2Cx&chxl=0%3A%7C0%7C50%7C100&chxtc=1%2C5&chxs=0%2C666666%2C11%2C1%2Cl&nonsense=foo.png](http://chart.apis.google.com/chart?cht=lc&chs=500x200&chd=t%3A49.00%2C74.00%2C78.00%2C71.00%2C40.00%2C39.00%2C35.00%2C20.00%2C50.00%2C61.00%2C45.00&chds=0%2C100&chm=o%2Cffffff%2C0%2C-1%2C8%7Co%2C4D89F9%2C0%2C-1%2C6%7CN%2C4D89F9%2C0%2C-1%2C10&chxt=y%2Cx&chxl=0%3A%7C0%7C50%7C100&chxtc=1%2C5&chxs=0%2C666666%2C11%2C1%2Cl&nonsense=foo.png)

# Debugging a chart #

What if you chart doesn't displays correctly ? Well, `GoogleChart` provides some method to help you debug a chart. Replace the 2 last lines of your example file by this:

```
if ( isset($_GET['debug']) ) {
	var_dump($chart->getQuery());
	printf('<iframe src="%s" width="500" height="500"></iframe>',$chart->getValidationUrl());
	echo $chart->toHtml();
}
else{
	header('Content-Type: image/png');
	echo $chart;
}
```

Now, add `?debug=true` in the URL to display a debug version of your chart.

# More #

Ok, the 15 minutes are over I guess, this tutorial is now finished. You should have a good overview of how Google Chart PHP Library works now.

To go further, you can:

  * [Read the API Documentation](http://googlechartphplib.cloudconnected.fr/doc) generated by Doxygen. It has plenty examples.
  * [Read Google Chart API official documentation](http://code.google.com/intl/fr-FR/apis/chart/docs/making_charts.html), to understand the main concepts (markers, compound charts, data scaling, ...)
  * Read the examples inside the `examples` directory of the archive (see Downloads section)