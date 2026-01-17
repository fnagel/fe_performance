<?php

use FelixNagel\FePerformance\Utility\ExtensionConfigurationUtility;
use FelixNagel\FePerformance\Hook\RenderPreProcessHook;

defined('TYPO3') || die();

$emConfig = ExtensionConfigurationUtility::get();

if ($emConfig['excludeInlineJsFromConcatenation']) {
    // Move and do not merge per page added inline JS
    // https://docs.typo3.org/c/typo3/cms-core/main/en-us/Changelog/14.0/Breaking-108055-RemovedPageRendererRelatedHooksAndMethods.html
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][] =
        RenderPreProcessHook::class . '->process';
}

