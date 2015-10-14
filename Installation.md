# Installing from an archive #

This is the simplest, and the recommended way for the majority of cases. However, if you want to try bleeding edge features or if you might want to try out [SVN installation](Installation#SVN_installation.md)

  * Download the last stable version in the [Downloads section](http://code.google.com/p/googlechartphplib/downloads/list).
  * Extract the archive
  * Copy the content of `lib` folder inside your project. For example, you can create a directory `googlechartlibphp` and copy all the files from the `lib` folder inside it.

## Autoloading ##

The library is compatible with autoloading features provided by popular frameworks such as Symfony or Zend Framework, as it doesn't override the autoload function.

If you don't use autoloading, you'll have to manually `require` class files prior usage.

# Installing from SVN #

You can use the `svn:externals` property to automatically fetch the last revision inside a directory of your project.

For example, if your include folder is `lib`, do:

```
$ svn pe svn:externals lib
```

Then specify a folder name, for example `googlechartphplib` and the URL of the repository. Read more about [externals definitions in the SVN Book](http://svnbook.red-bean.com/en/1.0/ch07s03.html).

Note: On Windows, you can use the excellent client [TortoiseSVN](http://tortoisesvn.net/downloads) to avoid using command line.

If you want to tie your project to a specific release, use a the URL of a branche. Example:

```
http://googlechartphplib.googlecode.com/svn/branches/0.6
```

You can also synchronize with the trunk with the URL:

```
http://googlechartphplib.googlecode.com/svn/trunk
```