<?php

namespace FelixNagel\FePerformance\Utility;

/**
 * This file is part of the "fe_performance" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ExtensionConfigurationUtility implements SingletonInterface
{
    public static function get(?string $key = null): array|string|null
    {
        $config = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('fe_performance');

        if ($key === null) {
            return $config;
        }

        if (is_string($key) && array_key_exists($key, $config)) {
            return $config[$key];
        }

        return null;
    }
}
