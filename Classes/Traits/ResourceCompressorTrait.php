<?php

namespace FelixNagel\FePerformance\Traits;

/**
 * This file is part of the "fe_performance" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use FelixNagel\FePerformance\Resource\ResourceCompressor;
use TYPO3\CMS\Core\Utility\GeneralUtility;

trait ResourceCompressorTrait
{
    protected ?ResourceCompressor $compressor = null;

    protected function getCompressor(): ResourceCompressor
    {
        if ($this->compressor === null) {
            $this->compressor = GeneralUtility::makeInstance(ResourceCompressor::class);
        }

        return $this->compressor;
    }
}
