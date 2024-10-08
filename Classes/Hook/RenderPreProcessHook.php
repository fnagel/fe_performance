<?php

namespace FelixNagel\FePerformance\Hook;

/**
 * This file is part of the "fe_performance" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use FelixNagel\FePerformance\Utility\ExtensionConfigurationUtility;
use TYPO3\CMS\Core\Page\PageRenderer;

/**
 * Hook within t3lib\class.t3lib_pagerenderer.php.
 */
class RenderPreProcessHook
{
    /**
     * Exclude files generated by pageRenderer from concatenation
     * We do not want the per page added inline JS to be merged.
     *
     * @see PageRenderer render-preProcess hook
     */
    public function process(array $params, PageRenderer $pageRenderer)
    {
        $emConfig = ExtensionConfigurationUtility::get();

        if (count($params['jsFiles'])) {
            foreach ($params['jsFiles'] as $name => $properties) {
                // Match file pattern for 8.0.0-13.3.0
                // See here (and other places):
                // https://github.com/TYPO3/typo3/blob/57944c8c5add00f0e8a1a5e1d07f30a8f20a8201/typo3/sysext/frontend/Classes/Page/PageGenerator.php#L875
                // https://github.com/TYPO3/typo3/blob/8a455d39c0f1ef1d6b96ad4c7714ebf11317c8df/typo3/sysext/core/Classes/Utility/GeneralUtility.php#L2334
                // https://github.com/TYPO3/typo3/blob/7bd650b7ee1b42c442819529271f05c0691c03af/typo3/sysext/core/Classes/Utility/GeneralUtility.php#L2559
                // https://github.com/TYPO3/typo3/blob/49e625c0a0912162020db6e5b454d6501bd39d4b/typo3/sysext/core/Classes/Utility/GeneralUtility.php#L2090
                if ($emConfig['excludeInlineJsFromConcatenation'] && preg_match('/typo3temp\/assets\/js\/[\d|a-z]+\.js/i', $name)) {
                    $params['jsFiles'][$name]['excludeFromConcatenation'] = 1;
                }
            }
        }
    }
}
