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
 * Service for JSMinPlus.
 */
class JSMinPlusService extends AbstractMinifyService
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $filepath = ExtensionManagementUtility::extPath($this->extKey).'Resources/Private/Php/jsminplus.php';
        GeneralUtility::requireOnce($filepath);
    }

    /**
     * {@inheritdoc}
     */
    public function minify($sourcecode)
    {
        return \JSMinPlus::minify($sourcecode);
    }
}
