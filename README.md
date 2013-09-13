TYPO3 fe_performance
====================

This extension helps to improve frontend performance in TYPO3 6.x


Features
--------
TYPO3 does gzip compression but no minification of JS files. This extension adds 
JavaScript minification to files and inline scripts. It's using JSMinPlus and 
the jsCompressHandler hook. Usage: config.compressJs needs to be enabled, gzip compression 
works as before.

When using "config.removeDefaultJS = external" TYPO3 generates temp JavaScript 
files with all per page inline JS and some default JS. This way users need to 
download code from statc files multiple times, just because its merged with per 
page inline JS. You could exclude these files from concatenation with static 
files (includeJS and includeJSFooter) by enabling excludeInlineJsFromConcatenation 
in extension manager.

When using includeJSFooter to add JS files it's a little annoying the only 
remaining JS file in header is the default one. You could use option 
moveInlineJsToFooter in EM to move the file to the footer section.



Feedback
--------
Please give feedback via twitter (@felixnagel) or email (info @ felixnagel . com).
Feel free to add bug reports via GitHub issues or send PRs.


Links
-----
* GitHub:		https://github.com/fnagel/fe_performance
* JSMinPlus: 	http://crisp.tweakblogs.net/blog/6861/jsmin%2B-version-14.html