Google Chart API is an awesome and powerful tool, but it can be sometimes cumbersome and error-prone. One of the main source of missunderstanding is how data scaling works. Google Chart PHP Library tries to alleviate this issue with an built-in autoscaling feature. This guide is here to explain everything you need to know about data scaling.

# What is data scaling? #

When you specify a set of values, you expect that they will be scaled to fit into the chart. Think of a bar chart for example, if you specify a data series (10, 20, 30), you might expect the maximum value of your chart to be 30. Another example, if you specify a data series (100, 200, 300), you might except the maximum value to be 300. However, this is not how it works by default with Google Chart API. The values are not scaled to the actual range, but instead to a fixed range, which is different depending on the data format you're using.

  * With Basic Text format (default format in version 0.4), range is (0,100). Values outside this range are truncated.
  * With Simple Encoding format, range is (0, 61). Values outside this range are truncated because they cannot be encoded  with the algorithm.
  * With Extended Encoding format, range is (0, 4095). Values outside this range are truncated because they cannot be encoded with the algorithm.

As soon as you need to specify values outside the defaults ranges, or if you want to customize the scale of your chart to zoom in for example, you need to specify manually how you want to scale your data. This is the data scaling feature.

Note that the range of the Y axis is independant. The default axis range is 0—100, regardless of data values or data scaling.

If you want to know more about the default behavior of Google Chart API, you should read this documentation: http://code.google.com/intl/fr-FR/apis/chart/docs/data_formats.html#scaled_values.

# Global scale for the chart (aka "One scale to rule them all") #

This is the simplest behavior: the chart only has one global scale, and all data series are bound to the same range. This works well if you have only one data series, or if all the data series uses the same scale.

## Autoscaling by values ##

The default behavior of Google Chart PHP Library is to compute a global scale base on the range of all the data series.

For example, if you have a data series (10, 10, 20) and a data series (-10, 20, 50), the global scale will be (-10, 50).

Example:

<table>
<tr>
<td>
<img src='http://chart.apis.google.com/chart?cht=bvg&chs=100x100&chbh=a&chd=t:10,20,30|-10,20,50&chco=ffcc33,336699&chds=-10,50&nonsense=foo.png' />
</td>
<td>
<pre><code>$chart = new GoogleBarChart('bvg', 100, 100);<br>
<br>
$data1 = new GoogleChartData(array(10, 20, 30));<br>
$chart-&gt;addData($data1);<br>
<br>
$data2 = new GoogleChartData(array(-10, 20, 50));<br>
$data2-&gt;setColor('336699');<br>
$chart-&gt;addData($data2);<br>
</code></pre>
</td>
</tr>
</table>

Without autoscaling, the chart would use the default scale (0,100) and look like:

<table>
<tr>
<td>
<img src='http://chart.apis.google.com/chart?cht=bvg&chs=100x100&chbh=a&chd=t:10,20,30|-10,20,50&chco=ffcc33,336699&nonsense=foo.png' />
</td>
<td>
<pre><code>$chart = new GoogleBarChart('bvg', 100, 100);<br>
$chart-&gt;setAutoscale(false);<br>
<br>
$data1 = new GoogleChartData(array(10, 20, 30));<br>
$data1-&gt;setAutoscale(false);<br>
$chart-&gt;addData($data1);<br>
<br>
$data2 = new GoogleChartData(array(-10, 20, 50));<br>
$data2-&gt;setAutoscale(false);<br>
$data2-&gt;setColor('336699');<br>
$chart-&gt;addData($data2);<br>
</code></pre>
</td>
</tr>
</table>


## Manual scaling ##

You can disable autoscaling and manually set a scale. This is useful if you want to have some space on top of the maximum value for example.

To set a global scale for your chart, use the `setScale` method of `GoogleChart`. This method automatically disable autoscaling.

Example:

<table>
<tr>
<td>
<img src='http://chart.apis.google.com/chart?cht=bvg&chs=100x100&chbh=a&chd=t:10,20,30|-10,20,50&chco=ffcc33,336699&chds=-10,70&nonsense=foo.png' />
</td>
<td>
<pre><code>$chart = new GoogleBarChart('bvg', 100, 100);<br>
$chart-&gt;setScale(-10,70);<br>
<br>
$data1 = new GoogleChartData(array(10, 20, 30));<br>
$data1-&gt;setAutoscale(false);<br>
$chart-&gt;addData($data1);<br>
<br>
$data2 = new GoogleChartData(array(-10, 20, 50));<br>
$data2-&gt;setAutoscale(false);<br>
$data2-&gt;setColor('336699');<br>
$chart-&gt;addData($data2);<br>
</code></pre>
</td>
</tr>
</table>

# Per-series scales #

Sometimes you'll need to display multiple data series with very different ranges. Then your need one scale per data series.

## Autoscaling by values ##

The default behavior for Google Chart PHP Library when global autoscaling is disabled is to compute a different scale for each data series.

Example:

<table>
<tr>
<td>
<img src='http://chart.apis.google.com/chart?cht=lc&chs=100x100&chd=t:10,20,30|2000,3000,5000&chco=ffcc33,336699&chds=0,5000&nonsense=foo.png' />
</td>
<td>
<pre><code>$chart = new GoogleChart('lc', 100, 100);<br>
<br>
$data1 = new GoogleChartData(array(10, 20, 30));<br>
$chart-&gt;addData($data1);<br>
<br>
$data2 = new GoogleChartData(array(2000,3000,5000));<br>
$data2-&gt;setColor('336699');<br>
$chart-&gt;addData($data2);<br>
</code></pre>
</td>
</tr>
</table>

You can see in the above example that the yellow line is invisible, because the global scale in (0,5000).

To disable global autoscaling, call `setAutoscale(false)` in `GoogleChart`. It will fall back to per-data autoscaling.

Example:

<table>
<tr>
<td>
<img src='http://chart.apis.google.com/chart?cht=lc&chs=100x100&chd=t:10,20,30|2000,3000,5000&chco=ffcc33,336699&chds=0,30,0,5000&nonsense=foo.png' />
</td>
<td>
<pre><code>$chart = new GoogleChart('lc', 100, 100);<br>
$chart-&gt;setAutoscale(false);<br>
<br>
$data1 = new GoogleChartData(array(10, 20, 30));<br>
$chart-&gt;addData($data1);<br>
<br>
$data2 = new GoogleChartData(array(2000,3000,5000));<br>
$data2-&gt;setColor('336699');<br>
$chart-&gt;addData($data2);<br>
</code></pre>
</td>
</tr>
</table>

Now the chart uses two differents scale : (0,30) for the first data series (yellow line) and (0,5000) for the second (blue line). When using different scale it's a good idea to uses multiple Y axis, or combine a Y axis and a R axis.

## Manual scaling ##

You can also disable per-data autoscaling.

Example:

<table>
<tr>
<td>
<img src='http://chart.apis.google.com/chart?cht=lc&chs=100x100&chd=t:10,20,30|2000,3000,5000&chco=ffcc33,336699&chds=0,50,0,7000&nonsense=foo.png' />
</td>
<td>
<pre><code>$chart = new GoogleChart('lc', 100, 100);<br>
$chart-&gt;setAutoscale(false);<br>
<br>
$data1 = new GoogleChartData(array(10, 20, 30));<br>
$data1-&gt;setScale(0,50);<br>
$chart-&gt;addData($data1);<br>
<br>
$data2 = new GoogleChartData(array(2000,3000,5000));<br>
$data2-&gt;setColor('336699');<br>
$data2-&gt;setScale(0,7000);<br>
$chart-&gt;addData($data2);<br>
</code></pre>
</td>
</tr>
</table>

Note that if you disable both global autoscaling and per-data autoscaling, and if you do no provide any custom scale, it will fallback to the default scale (0,100) for every data format.