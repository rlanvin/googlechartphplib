# Sparklines #

Chart type `lfi` produces a line chart with no axis, similar to `ls`, but with a smaller thickness (default is 1 instead of 2).

Found in Mark McLaren's Weblog http://cse-mjmcl.cse.bris.ac.uk/blog/2007/12/23/1198436217875.html

Example:

![http://chart.apis.google.com/chart?cht=lfi&chs=75x30&chco=0077CC&chm=B,E6F2FA,0,0,0&chd=e:vvt1f3iczaycs7vjs6eahxyauuu0znswgdiuzzv8sauimebsc1g9faeggabx8&nonsense=foo.png](http://chart.apis.google.com/chart?cht=lfi&chs=75x30&chco=0077CC&chm=B,E6F2FA,0,0,0&chd=e:vvt1f3iczaycs7vjs6eahxyauuu0znswgdiuzzv8sauimebsc1g9faeggabx8&nonsense=foo.png)

# Embedding a chart inside another chart #

It seems possible to embbed a chart inside another chart using the `chem` parameter (used for dynamic icon markers). But I have no clue how it works.


Example:

http://chart.apis.google.com/chart?chxl=0:|0|1:|0&chts=000000,13.5&chxp=0,0|1,0&chxr=0,-5,100|1,-5,100&chxs=0,000000,13.5,-0.5,l,000000|1,000000,12.5,-0.5,l,000000&chxt=x,y&chs=240x150&cht=lc&chd=s0:PPPPPPP&chls=1&chtt=Location+of+black+ink+in+this+image&chem=y;;[chts'000000,13.5'chxs'0,000000,13'chxt'x'chs'240x150'cht'p3'chco'000000@|FFFFFF'chd's:J0'chp'3.1'chl'Black@|Not+black'chtt'Fraction+of+this+image+which+is'chma'35,35,35,35']ec'\/4'/4'scl'\;;0;0;;-1|y;;[chts'000000,13.5'chxs'0,000000,13'chxt'x'chxr'0,1,6'chbh'r,1'chs'240x150'cht'bvs'chco'000000'chd's:lxS'chtt'Amount+of+black+ink+by+panel']ec'\/4'/4'scl'\;;0;2;;-1|y;;[chxl'0:@|0@|1:@|0'chts'000000,13.5'chxp'0,0@|1,0'chxr'0,-5,100@|1,-5,100'chxs'0,000000,13.5,-0.5,l,000000@|1,000000,12.5,-0.5,l,000000'chxt'x,y'chs'240x150'cht'lc'chd's0:PPPPPPP'chls'1'chtt'Location+of+black+ink+in+this+image']ec'\/4'/4'scl'\;;0;4;;-1|y;;[chs'240x150'cht'p3'chco'000000@|FFFFFF'chd's:J0'chp'3.1'chl'Black@|Not+black'chtt'Fraction+of+this+image+which+is'chma'35,35,35,35']ec'\/16'/16'scl'\;;0;4.1;;-1;of=0,10|y;;[chxr'0,1,6'chxt'x'chts'000000,13.5'chbh'r,1'chs'240x150'cht'bvs'chco'000000'chd's:lxS'chtt'Amount+of+black+ink+by+panel']ec'\/16'/16'scl'\;;0;4.5;;-1;of=0,10|y;;[chxl'0:@|0@|1:@|0'chts'000000,13.5'chxp'0,0@|1,0'chxr'0,-5,100@|1,-5,100'chxs'0,000000,13.5,-0.5,l,000000@|1,000000,12.5,-0.5,l,000000'chxt'x,y'chs'240x150'cht'lc'chd's0:PPPPPPP'chls'1'chtt'Location+of+black+ink+in+this+image']ec'\/16'/16'scl'\;;0;4.9;;-1;of=0,10&nonsense=foo.png

Url:

```
chxl=0:|0|1:|0
chts=000000,13.5
chxp=0,0|1,0
chxr=0,-5,100|1,-5,100
chxs=0,000000,13.5,-0.5,l,000000|1,000000,12.5,-0.5,l,000000
chxt=x,y
chs=240x150
cht=lc
chd=s0:PPPPPPP
chls=1
chtt=Location+of+black+ink+in+this+image
chem=
	y;;[
		chts'000000,13.5'chxs'0,000000,13'chxt'x'chs'240x150'cht'p3'chco'000000@|FFFFFF'chd's:J0'chp'3.1'chl'Black@|Not+black'chtt'Fraction+of+this+image+which+is'chma'35,35,35,35'
	]ec'\/4'/4'scl'\;;0;0;;-1|
	y;;[
		chts'000000,13.5'chxs'0,000000,13'chxt'x'chxr'0,1,6'chbh'r,1'chs'240x150'cht'bvs'chco'000000'chd's:lxS'chtt'Amount+of+black+ink+by+panel'
	]ec'\/4'/4'scl'\;;0;2;;-1|
	y;;[
		chxl'0:@|0@|1:@|0'chts'000000,13.5'chxp'0,0@|1,0'chxr'0,-5,100@|1,-5,100'chxs'0,000000,13.5,-0.5,l,000000@|1,000000,12.5,-0.5,l,000000'chxt'x,y'chs'240x150'cht'lc'chd's0:PPPPPPP'chls'1'chtt'Location+of+black+ink+in+this+image'
	]ec'\/4'/4'scl'\;;0;4;;-1|
	y;;[
		chs'240x150'cht'p3'chco'000000@|FFFFFF'chd's:J0'chp'3.1'chl'Black@|Not+black'chtt'Fraction+of+this+image+which+is'chma'35,35,35,35'
	]ec'\/16'/16'scl'\;;0;4.1;;-1;of=0,10|
	y;;[
		chxr'0,1,6'chxt'x'chts'000000,13.5'chbh'r,1'chs'240x150'cht'bvs'chco'000000'chd's:lxS'chtt'Amount+of+black+ink+by+panel'
	]ec'\/16'/16'scl'\;;0;4.5;;-1;of=0,10|
	y;;[
		chxl'0:@|0@|1:@|0'chts'000000,13.5'chxp'0,0@|1,0'chxr'0,-5,100@|1,-5,100'chxs'0,000000,13.5,-0.5,l,000000@|1,000000,12.5,-0.5,l,000000'chxt'x,y'chs'240x150'cht'lc'chd's0:PPPPPPP'chls'1'chtt'Location+of+black+ink+in+this+image'
	]ec'\/16'/16'scl'\;;0;4.9;;-1;of=0,10
```

Seen in : http://googlecode.blogspot.com/2010/02/announcing-google-chart-tools.html