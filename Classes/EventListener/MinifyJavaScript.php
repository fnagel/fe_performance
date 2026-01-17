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

/**
 * Processes JS managed by asset collector
 */
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
    }
}
