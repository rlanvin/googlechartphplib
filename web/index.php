<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
	<title>Google Chart PHP Library</title> 
 
	<link rel="stylesheet" href="style.css" type="text/css" media="screen"> 
</head>
<body>
<? require 'charts.lib.php' ?>
<div id="page">
	<div id="header">
		<p class="logo"><img src="<?=logo()?>" alt="Logo powered by Google Chart PHP Library"></p>
		<h1>Google Chart PHP Library</h1>
		<p id="catchphrase">A lightweight object-oriented charting library for PHP 5 built on top of the powerful Google Chart API.</p>
	</div>

	<div id="main">
		<p id="version"><a href="http://code.google.com/p/googlechartphplib/downloads/list" title="This icon is powered by Google Chart PHP Library too."><?=current_version()?></a></p>

		<div id="content">
			<p>Google Chart PHP Library is a <strong>open-source</strong> (MIT License) and <strong>free to use</strong> wrapper for the awesome <a href="http://code.google.com/intl/fr-FR/apis/chart/docs/making_charts.html">Google Chart API</a>, a tool provided by Google to create PNG charts using a simple HTTP request. Google Chart PHP Library aims to to simplify the request generation by offering a <strong>high-level object-oriented PHP interface</strong>.</p>
			
			<h2>What's the difference with other charting libraries?</h2>
			
			<p>The main difference is that Google Chart PHP Library <strong>doesn't generate any image</strong>, but instead generate an HTTP request (GET or POST) to call Google Chart API.</p>
			<ul>
				<li>Generation of the chart is <strong>blazing fast</strong>.</li>
				<li>It doesn't require <strong>any additional PHP modules</strong> (like GD or imagemagick).</li>
				<li>You can use the generated URL in a <code>img</code> HTML tag and <strong>save bandwith</strong>.</li>
				<li>Or, you can fetch the PNG image and <strong>cache it locally</strong>.</li>
			</ul>

			<p>Of course, there is one drawback: you rely on an external tool to generate your charts. Hence you might want to consider other libraries to create charts with <strong>highly confidential data</strong> (<a href="http://code.google.com/intl/fr-FR/apis/chart/faq.html#logging" rel="nofollow">Charts are cached into Google's servers for 2 weeks</a>), or if you create an internal application with no internet access.</p>

			<h2>See it in action!</h2>

			<p class="chart"><img src="<?=sin_cos()?>" alt="Line Chart" title="Line Chart"></p>

			<p class="chart"><img src="<?=bar()?>" alt="Bar Chart" title="Bar Chart"></p>

			<p class="chart"><img src="<?=map()?>" alt="Map Chart" title="Map Chart"></p>

			<p>All examples are powered by Google Chart PHP Library. This is only a small excerpt of all the different charts offered by Google Chart API. If you want to know more, take a look at <a href="http://code.google.com/intl/fr-FR/apis/chart/docs/gallery/chart_gall.html" rel="nofollow">the Chart Gallery from the official documentation</a>.</p>


			<h2>Care to help?</h2>
			<p>Google Chart PHP Library is an open-source project. I've created it originally for <a href="http://eventcharts.cloudconnected.fr/">Last.fm Event Charts</a>, but it's now a project of its own. I'm working on it during my free time, and if you want to help, you're very welcome!</p>
			<p>There is a lot to do. Here are some ideas:</p>
			<ul>
				<li>Use it, test it and <a href="http://code.google.com/p/googlechartphplib/issues/list">open an issue</a> if something is broken.</li>
				<li>Implement missing features and charts (<a href="http://code.google.com/p/googlechartphplib/wiki/Todo">Todo list</a>).</li>
				<li>Implement missing unit tests (with PHPUnit).</li>
				<li>Write/improve examples, tutorials and documentation <a href="http://code.google.com/p/googlechartphplib/downloads/list">on the Wiki</a>.</li>
				<li>Send feedbacks, comments and criticism, you'll make my day. :-)</li>
			</ul>

		</div>

		<div id="sidebar">
			<h3 class="download">Download</h3>
			<ul>
				<li><a href="http://code.google.com/p/googlechartphplib/downloads/list">Grab the latest release</a></li>
				<li><a href="http://code.google.com/p/googlechartphplib/source/checkout">Checkout the SVN</a></li>
			</ul>
			<h3 class="documentation">Learn</h3>
			<ul>
				<li><a href="http://code.google.com/p/googlechartphplib/wiki/GettingStarted">Read the wiki</a></li>
				<li><a href="http://googlechartphplib.cloudconnected.fr/doc">Browse the documentation</a></li>
				<li><a href="http://code.google.com/intl/fr-FR/apis/chart/docs/making_charts.html" rel="nofollow">Check Google Chart API doc</a></li>
			</ul>
			<h3 class="participate">Participate</h3>
			<ul>
				<li><a href="http://code.google.com/p/googlechartphplib/">Project home on Google Code</a></li>
				<li><a href="http://code.google.com/p/googlechartphplib/issues/list">Issue Tracker</a></li>
				<li><code>remi at cloudconnected dot fr</code></li>
			</ul>

		</div>
		<div class="clear"></div>
	</div>
	
	<div id="footer">
		<h3>About</h3>
		<p>I'm Rémi Lanvin, and you can contact me by email at <code>remi at cloudconnected dot fr</code></p>
		<p>Sometimes I have enough free time to write an article <a href="http://cloudconnected.fr">on my dev blog</a>, or something <a href="http://twitter.com/rlanvin">on my Twitter account</a>.</p>
		<p id="pacman"><img src="<?=pacman()?>" alt="Tribute to Pacman with a Pie Chart" title="Tribute to Pacman with a Pie Chart"></p>
	</div>
</div>

<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-11912505-4']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>
