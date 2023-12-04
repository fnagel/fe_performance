# TYPO3 fe_performance

This TYPO3 CMS extension improves your frontend performance.
Adds HTML and JavaScript minification.
Comes with some useful tweaks to improve asset rendering.

Supports JS added by TypoScript, PageRenderer or AssetCollector.


## Features

* JS added by TypoScript or PageRenderer
  * Minification of JS (files and inline)
  * Exclude per page inline JS from concatenation

* JS added by AssetCollector (BETA!)
  * Enable minify and gzip for JS files

* Minify all generated HTML


## What it does

TYPO3 does gzip compression but no minification of JS files. This extension adds
JavaScript minification to files and inline scripts by using the
`jsCompressHandler` hook and `BeforeJavaScriptsRenderingEvent` event.
Usage: `config.compressJs` needs to be enabled, gzip compression works as before.

When using `config.removeDefaultJS = external` TYPO3 generates temp JavaScript
files with all per page inline JS and some default JS. This way users need to
download code from static files multiple times, just because its merged with per
page inline JS. You could exclude these files from concatenation with static
files (includeJS and includeJSFooter) by enabling `excludeInlineJsFromConcatenation`
option in extension manager.


### JavaScript minifiers

Choose the one best fitting for your needs. Configure this in the EM.


**JSMin+**
Widely used JS compressor. A PHP port of Brendan Eich's Narcissus original implementation.
http://crisp.tweakblogs.net/blog/6861/jsmin%2B-version-14.html

**JavaScriptMinifier**
Used by the Wikimedia Foundation for different projects incl. Wikipedia.
Considered the most robust, stable and fastest one. Under active development.
https://github.com/wikimedia/mediawiki/blob/REL1_35/includes/libs/JavaScriptMinifier.php


## Upgrade


### Version 2.2.0

Use "Flush TYPO3 and PHP Cache" in the "Admin Tools -> Maintenance" BE module.

Removed obsolete `moveInlineJsToFooter` option. Since TYPO3 v11 the asset collector is used
for inline JS and adds the default JS to the footer without any tweaks.


### Version 2.0.0

Use "Flush TYPO3 and PHP Cache" in the "Admin Tools -> Maintenance" BE module.`


### Version 1.0.0

Use "Clear all caches including PHP opcode cache" and "Dump Autoload Information"
in the install tool (if needed for your setup).

Please update the `minifier` configuration in the Extension Manager as the class names have changed.


## Feedback

Feel free to add bug reports via GitHub issues or send PRs.


## Links

* GitHub:		https://github.com/fnagel/fe_performance
* Bugtracker:	https://github.com/fnagel/fe_performance/issues
* Changelog:	https://github.com/fnagel/fe_performance/commits
