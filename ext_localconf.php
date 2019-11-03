<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$emConfig = unserialize($_EXTCONF);

if ($emConfig['minifyJavaScript']) {
    // Add hook for minification
    $GLOBALS['TYPO3_CONF_VARS']['FE']['jsCompressHandler'] =
        'FelixNagel\\FePerformance\\Hook\\JavaScriptCompressHandlerHook->process';

    // Make sure page JS is not minified before
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_div.php']['minifyJavaScript'] = null;
}

if ($emConfig['excludeInlineJsFromConcatenation'] || $emConfig['moveInlineJsToFooter']) {
    // Do not merge per page added inline JS
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][] =
        'FelixNagel\\FePerformance\\Hook\\RenderPreProcessHook->process';
}

if ($emConfig['minifyHtml']) {
    // Add FE hooks for minify the HTML output
    if (TYPO3_MODE === 'FE') {
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-output'][] =
            'FelixNagel\FePerformance\Hook\ContentPostProcHook->processUncachedContent';

        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-all'][] =
            'FelixNagel\FePerformance\Hook\ContentPostProcHook->processCachedContent';
    }
}
