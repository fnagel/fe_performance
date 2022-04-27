<?php

defined('TYPO3') || die();

$emConfig = \FelixNagel\FePerformance\Utility\ExtensionConfigurationUtility::get();

if ($emConfig['minifyJavaScript']) {
    // Add hook for minification
    $GLOBALS['TYPO3_CONF_VARS']['FE']['jsCompressHandler'] =
        \FelixNagel\FePerformance\Hook\JavaScriptCompressHandlerHook::class . '->process';

    // Make sure page JS is not minified before
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_div.php']['minifyJavaScript'] = null;
}

if ($emConfig['excludeInlineJsFromConcatenation'] || $emConfig['moveInlineJsToFooter']) {
    // Move and do not merge per page added inline JS
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][] =
        \FelixNagel\FePerformance\Hook\RenderPreProcessHook::class . '->process';
}

