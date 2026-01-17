<?php

namespace FelixNagel\FePerformance\Resource;

/**
 * This file is part of the "fe_performance" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use FelixNagel\FePerformance\Service\MinifyServiceInterface;
use FelixNagel\FePerformance\Utility\ExtensionConfigurationUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * JavaScript minification.
 */
class ResourceCompressor
{
    protected ?MinifyServiceInterface $minifier = null;

    public function minifyJsCode(string $script): string
    {
        return $this->getMinifier()->minify($script);
    }

    protected function getMinifier(): MinifyServiceInterface
    {
        if ($this->minifier === null) {
            $minifier = GeneralUtility::makeInstance(ExtensionConfigurationUtility::get('minifier'));

            if (!$minifier instanceof MinifyServiceInterface) {
                throw new \Exception('Minifier must implement interface MinifyServiceInterface', 1299088927);
            }

            $this->minifier = $minifier;
        }

        return $this->minifier;
    }
}
