

# Legends #

There are 2 different ways of internally handling legends.

For charts where one data series is a set of values (an array of ints), like line charts and bar charts, the legend is stored into `GoogleChartData` instance (`$legend` protected variable), and accessed by `setLegend` and `getLegend` methods (please note the singular). The `chdl` parameter is processed when calling `GoogleChart::computeData`. Each legend is collected into an array, and if at least one data series has a custom legend set, then the parameter will be included.

For charts with only one data series (like Pie chart) the legends are store as an array into the `GoogleChartData::$legends` protected variable, and accessed by `setLegends` and `getLegends` (please note the plural). The special variable `GoogleChart::$_multiple_legends` is set to true, and the processing is then made by `GoogleChartData::ComputeChdl`. That is, the data series itself holds all the legends, and will calculate the parameter itself.

Scatter charts use a special emulation for multiple data series, and internally handles the legends with its first data series (`$series_x`), like a Pie Chart with the `GoogleChart::$_multiple_legends` parameter.
