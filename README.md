# TYPO3 fe_performance

This extension helps to improve frontend performance in TYPO3 CMS.
It adds JS minification and some tweaks to the JS handling in general.
It's possible to minify all generated HTML.


## Features

TYPO3 does gzip compression but no minification of JS files. This extension adds
JavaScript minification to files and inline scripts by using the
jsCompressHandler hook. Usage: config.compressJs needs to be enabled, gzip
compression works as before.

When using "config.removeDefaultJS = external" TYPO3 generates temp JavaScript
files with all per page inline JS and some default JS. This way users need to
download code from statc files multiple times, just because its merged with per
page inline JS. You could exclude these files from concatenation with static
files (includeJS and includeJSFooter) by enabling excludeInlineJsFromConcatenation
in extension manager.

When using includeJSFooter to add JS files it's a little annoying the only
remaining JS file in header is the default one. You could use option
moveInlineJsToFooter in EM to move the file to the footer section.


### JavaScript minifiers

Choose the one best fitting for your needs. Configure this in the EM.


**JSMin+**
Widely used JS compressor. A PHP port of Brendan Eich's Narcissus original implementation.
http://crisp.tweakblogs.net/blog/6861/jsmin%2B-version-14.html

**JavaScriptMinifier**
Used by the Wikimedia Foundation for different projects incl. Wikipedia.
Considered the most robust, stable and fastest one. Under active development.
https://github.com/wikimedia/mediawiki-core/blob/master/includes/libs/JavaScriptMinifier.php


## Upgrade

Clear cache via install tool.


## Feedback

Feel free to add bug reports via GitHub issues or send PRs.


## Links

* GitHub:		https://github.com/fnagel/fe_performance
* Changelog:	https://github.com/fnagel/fe_performance/commits