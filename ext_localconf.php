<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$emConfig = unserialize($_EXTCONF);

if ($emConfig['minifyJavaScript']) {
	// add hook for minification
	$GLOBALS['TYPO3_CONF_VARS']['FE']['jsCompressHandler'] =
		'TYPO3\\FePerformance\\Hook\\JavaScriptCompressHandlerHook->process';

	// make sure page JS is not minified before
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_div.php']['minifyJavaScript'] = NULL;
}

if ($emConfig['excludeInlineJsFromConcatenation'] || $emConfig['moveInlineJsToFooter']) {
	// do not merge per page added inline JS
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][] =
		'TYPO3\\FePerformance\\Hook\\RenderPreProcessHook->process';
}


if ($emConfig['minifyHtml']) {
	// Minify HTML output
	$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-output']['tx_felixnagelcom'] =
		'TYPO3\\FePerformance\\Hook\\ContentPostProcOutput->process';
}
