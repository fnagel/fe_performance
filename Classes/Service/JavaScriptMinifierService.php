<?php

namespace TYPO3\FePerformance\Service;

/**
 * This file is part of the "fe_performance" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Service for JavaScriptMinifier as used by Wikimedia.
 */
class JavaScriptMinifierService extends AbstractMinifyService
{
    /**
     * Constructor.
     *
     * @todo Use autoloading classes instead of require once!
     */
    public function __construct()
    {
        $filepath = ExtensionManagementUtility::extPath($this->extKey).'Resources/Private/Php/JavaScriptMinifier.php';
        GeneralUtility::requireOnce($filepath);
    }

    /**
     * {@inheritdoc}
     */
    public function minify($sourcecode)
    {
        return \JavaScriptMinifier::minify($sourcecode);
    }
}
