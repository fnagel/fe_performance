<?php

namespace FelixNagel\FePerformance\Hook;

/**
 * This file is part of the "fe_performance" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use FelixNagel\FePerformance\Traits\ResourceCompressorTrait;

/**
 * Hook within t3lib\class.t3lib_pagerenderer.php
 *
 * http://forge.typo3.org/issues/33370.
 */
class JavaScriptCompressHandlerHook
{
    use ResourceCompressorTrait;

    /**
     * Uses modified ResourceCompressor class to process JS.
     *
     * @see \TYPO3\CMS\Core\Page\PageRenderer jsCompressHandler hook
     */
    public function process(array $params)
    {
        if (count($params['jsInline'])) {
            foreach ($params['jsInline'] as $name => $properties) {
                if ($properties['compress']) {
                    $params['jsInline'][$name]['code'] = $this->getCompressor()->minifyJsCode($properties['code']);
                }
            }
        }

        // This is fine as it is even when the IDE says otherwise
        $params['jsLibs'] = $this->getCompressor()->compressJsFiles($params['jsLibs']);
        $params['jsFiles'] = $this->getCompressor()->compressJsFiles($params['jsFiles']);
        $params['jsFooterFiles'] = $this->getCompressor()->compressJsFiles($params['jsFooterFiles']);
    }
}
