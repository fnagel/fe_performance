<?php

namespace FelixNagel\FePerformance\Service;

/**
 * This file is part of the "fe_performance" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

/**
 * Service for JavaScriptMinifier as used by Wikimedia.
 */
class JavaScriptMinifierService extends AbstractMinifyService
{
    /**
     * {@inheritdoc}
     */
    public function minify($sourcecode)
    {
        return \JavaScriptMinifier::minify($sourcecode);
    }
}
