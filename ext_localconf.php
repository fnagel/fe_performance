<?php

use FelixNagel\FePerformance\Utility\ExtensionConfigurationUtility;
use FelixNagel\FePerformance\Hook\JavaScriptCompressHandlerHook;
use FelixNagel\FePerformance\Hook\RenderPreProcessHook;

defined('TYPO3') || die();

$emConfig = ExtensionConfigurationUtility::get();

if ($emConfig['minifyJavaScript']) {
    // Add hook for minification
    $GLOBALS['TYPO3_CONF_VARS']['FE']['jsCompressHandler'] =
        JavaScriptCompressHandlerHook::class . '->process';

    // Make sure page JS is not minified before
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_div.php']['minifyJavaScript'] = null;
}

if ($emConfig['excludeInlineJsFromConcatenation'] || $emConfig['moveInlineJsToFooter']) {
    // Move and do not merge per page added inline JS
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][] =
        RenderPreProcessHook::class . '->process';
}

