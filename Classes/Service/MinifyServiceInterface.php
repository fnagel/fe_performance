<?php

namespace FelixNagel\FePerformance\Service;

/**
 * This file is part of the "fe_performance" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

/**
 * JavaScript minify service interface for providing minifier classes.
 */
interface MinifyServiceInterface
{
    /**
     * Processes the JavaScript code minification.
     *
     * @param string $sourcecode Script to minfiy
     *
     * @return string The minified string
     */
    public function minify($sourcecode);
}
