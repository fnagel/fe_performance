<?php

namespace FelixNagel\FePerformance\EventListener;

/**
 * This file is part of the "fe_performance" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use FelixNagel\FePerformance\Traits\ResourceCompressorTrait;
use FelixNagel\FePerformance\Utility\ExtensionConfigurationUtility;
use TYPO3\CMS\Core\Page\Event\BeforeJavaScriptsRenderingEvent as Event;

class MinifyJavaScript
{
    use ResourceCompressorTrait;

    public function __invoke(Event $event): void
    {
        if (!ExtensionConfigurationUtility::get('minifyJavaScript')) {
            return;
        }

        if ($event->isInline()) {
            // @todo Test and implement minification for inline JS!
            return;
        }

        if (ExtensionConfigurationUtility::get('assetCollectorMinifyJavaScriptFiles')) {
            $this->processFiles(
                $event,
                $event->getAssetCollector()->getJavaScripts($event->isPriority())
            );
        }
    }

    protected function processFiles(Event $event, array $assets): void
    {
        foreach ($assets as $asset => $config) {
            // Skip already processed files
            if (substr($config['source'], 7) === '.min.js' || substr($config['source'], 12) === '.min.js.gzip') {
                continue;
            }

            $event->getAssetCollector()->removeJavaScript($asset);
            $event->getAssetCollector()->addJavaScript(
                $asset,
                $this->getCompressor()->compressJsFile($config['source']),
                $config['attributes'],
                $config['options']
            );
        }
    }
}
