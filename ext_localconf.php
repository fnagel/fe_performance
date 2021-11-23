<?php

defined('TYPO3') || die();

$emConfig = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    \TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class
)->get('fe_performance');

if ($emConfig['minifyJavaScript']) {
    // Add hook for minification
    $GLOBALS['TYPO3_CONF_VARS']['FE']['jsCompressHandler'] =
        \FelixNagel\FePerformance\Hook\JavaScriptCompressHandlerHook::class . '->process';

    // Make sure page JS is not minified before
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_div.php']['minifyJavaScript'] = null;
}

if ($emConfig['excludeInlineJsFromConcatenation'] || $emConfig['moveInlineJsToFooter']) {
    // Do not merge per page added inline JS
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][] =
        \FelixNagel\FePerformance\Hook\RenderPreProcessHook::class . '->process';
}

// Add FE hooks for minify the HTML output
if ($emConfig['minifyHtml'] && TYPO3_MODE === 'FE') {
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-output'][] =
            \FelixNagel\FePerformance\Hook\ContentPostProcHook::class . '->processUncachedContent';

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-all'][] =
            \FelixNagel\FePerformance\Hook\ContentPostProcHook::class . '->processCachedContent';
}
