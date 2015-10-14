## Latest news ##

### 2012-04-23 - Google Chart Image Tools is now [officially deprecated by Google](http://googledevelopers.blogspot.com/2012/04/changes-to-deprecation-policies-and-api.html), so I'm not sure what will be the future of this library. ###
### 2011-03-27 - Version 0.6 released [Read more »](Release06.md), [Download »](http://code.google.com/p/googlechartphplib/downloads/list) ###
### 2011-02-15 - Google Chart PHP Library is now supported by Developer's Helsinki. http://www.developers.fi ###
### 2010-06-01 - Check out the project homepage: http://googlechartphplib.cloudconnected.fr/ ###


---


The goal of Google Chart PHP Library is to create a powerful and easy-to-use charting library to generate all kind of charts, with Google Chart API as a backend.

## Requirements ##

Google Chart PHP library works with PHP 5.2 (maybe works with other version as well), and **doesn't require any additional library**.

## Status ##

This is the status of the current trunk.

| **Feature** | **Supported?** | **Comment** |
|:------------|:---------------|:------------|
| Base API    | <font color='green'><b>Yes</b></font> | Missing HTTPS |
| Bar Charts  | <font color='green'><b>Yes</b></font> |             |
| Box Charts  | <font color='red'><b>No</b></font> |             |
| Candlestick Charts | <font color='red'><b>No</b></font> |             |
| Compound Charts | <font color='green'><b>Yes</b></font> |             |
| Dynamic Icons | <font color='orange'><b>Partial</b></font> |             |
| Formulas    | <font color='red'><b>No</b></font> |             |
| Google-O-Meter Charts | <font color='red'><b>No</b></font> |             |
| GraphViz Charts | <font color='red'><b>No</b></font> |             |
| Line Charts | <font color='green'><b>Yes</b></font> |             |
| Map Charts  | <font color='green'><b>Yes</b></font> |             |
| Pie Charts  | <font color='orange'><b>Partial</b></font> |             |
| QR Codes    | <font color='green'><b>Yes</b></font> |             |
| Radar Charts | <font color='red'><b>No</b></font> |             |
| Scatter Charts | <font color='orange'><b>Partial</b></font> | in 0.7      |
| Venn Charts | <font color='green'><b>Yes</b></font> | in 0.7      |

## Examples ##

![http://chart.apis.google.com/chart?cht=lc&chs=800x154&chg=0,50,3,2&chma=5,5,5,5&chd=t:34,18,21,70,53,39,39,30,13,15,4,8,5,8,4,8,44,16,16,3,10,7,5,20,20,28,44,_|_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,44,34&chco=000000,000000&chls=3|3,4,2&chds=0,70&chm=B,eeeeee,0,0,0|B,eeeeee,1,0,0|o,ffffff,0,-1,9|o,000000,0,-1,7|o,000000,1,-1::,8|o,ffffff,1,-1::,4&chxt=y,x&chxl=0:||35|70|1:|27+apr|04+may|11+may|18+may&chxtc=0,5|1,5&chxs=0,666666,9,1,_,ffffff|1,666666,9,0,t&chxp=1,0,25.8,51.8,77.6&flickr.png](http://chart.apis.google.com/chart?cht=lc&chs=800x154&chg=0,50,3,2&chma=5,5,5,5&chd=t:34,18,21,70,53,39,39,30,13,15,4,8,5,8,4,8,44,16,16,3,10,7,5,20,20,28,44,_|_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,44,34&chco=000000,000000&chls=3|3,4,2&chds=0,70&chm=B,eeeeee,0,0,0|B,eeeeee,1,0,0|o,ffffff,0,-1,9|o,000000,0,-1,7|o,000000,1,-1::,8|o,ffffff,1,-1::,4&chxt=y,x&chxl=0:||35|70|1:|27+apr|04+may|11+may|18+may&chxtc=0,5|1,5&chxs=0,666666,9,1,_,ffffff|1,666666,9,0,t&chxp=1,0,25.8,51.8,77.6&flickr.png)

![http://chart.apis.google.com/chart?cht=p&chs=130x100&chp=0.628&chd=s:x_&chco=f9f900,ffffff&chdl=|O+O+O&chdlp=rs&pacman.png](http://chart.apis.google.com/chart?cht=p&chs=130x100&chp=0.628&chd=s:x_&chco=f9f900,ffffff&chdl=|O+O+O&chdlp=rs&pacman.png)