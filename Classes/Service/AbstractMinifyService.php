<?php

namespace FelixNagel\FePerformance\Service;

/**
 * This file is part of the "fe_performance" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use TYPO3\CMS\Core\SingletonInterface;

/**
 * Abstract class Service for providing minifier classes.
 */
abstract class AbstractMinifyService implements MinifyServiceInterface, SingletonInterface
{
    /**
     * {@inheritdoc}
     */
    abstract public function minify($sourcecode);
}
