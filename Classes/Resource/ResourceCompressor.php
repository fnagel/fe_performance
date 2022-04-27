<?php

namespace FelixNagel\FePerformance\Resource;

/**
 * This file is part of the "fe_performance" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use FelixNagel\FePerformance\Service\MinifyServiceInterface;
use FelixNagel\FePerformance\Utility\ExtensionConfigurationUtility;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Compressor (taken from sysext core)
 *
 * Added JavaScript minification.
 */
class ResourceCompressor extends \TYPO3\CMS\Core\Resource\ResourceCompressor
{
    protected ?MinifyServiceInterface $minifier = null;

    /**
     * Minification and gzip compression of a javascript file.
     *
     * @inheritDoc
     */
    public function compressJsFile($filename)
    {
        // generate the unique name of the file
        $filenameAbsolute = GeneralUtility::resolveBackPath($this->rootPath . $this->getFilenameFromMainDir($filename));

        if (@file_exists($filenameAbsolute)) {
            $fileStatus = stat($filenameAbsolute);
            $unique = $filenameAbsolute . $fileStatus['mtime'] . $fileStatus['size'];
        } else {
            $unique = $filenameAbsolute;
        }

        $pathinfo = PathUtility::pathinfo($filename);
        $targetFile = $this->targetDirectory . $pathinfo['filename'] . '-' . md5($unique) . '.min.js';

		// only create it, if it doesn't exist, yet
		if (!file_exists(Environment::getPublicPath() . '/' . $targetFile) || $this->createGzipped && !file_exists(Environment::getPublicPath() . '/' . $targetFile . '.gzip')) {
			$contents = (string)file_get_contents($filenameAbsolute);
            $minifiedContents = $this->minifyJsCode($contents);

            $this->writeFileAndCompressed($targetFile, $minifiedContents);
        }

        return $this->returnFileReference($targetFile);
	}

    public function minifyJsCode(string $script): string
    {
        return $this->getMinifier()->minify($script);
    }

    protected function getMinifier(): MinifyServiceInterface
    {
        if ($this->minifier === null) {
            $minifier = GeneralUtility::makeInstance(ExtensionConfigurationUtility::get('minifier'));

            if (!$minifier instanceof MinifyServiceInterface) {
                throw new \Exception('Minifier must implement interface MinifyServiceInterface', 1299088927);
            }

            $this->minifier = $minifier;
        }

        return $this->minifier;
    }
}
