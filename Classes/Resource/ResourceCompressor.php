<?php

namespace FelixNagel\FePerformance\Resource;

/**
 * This file is part of the "fe_performance" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use FelixNagel\FePerformance\Service\MinifyServiceInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Compressor (taken from sysext core)
 *
 * Added JavaScript minification.
 *
 */
class ResourceCompressor extends \TYPO3\CMS\Core\Resource\ResourceCompressor
{
    /**
     * @var \FelixNagel\FePerformance\Service\MinifyServiceInterface
     */
    protected $minifier;

    /**
     * Minification and gzip compression of a javascript file.
     *
     * @param string $filename Source filename, relative to requested page
     *
     * @return string Filename of the compressed file, relative to requested page
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
        if (!file_exists(($this->getPublicPath().$targetFile)) || $this->createGzipped && !file_exists(($this->getPublicPath().$targetFile.'.gzip'))) {
            $contents = file_get_contents($filenameAbsolute);
            $minifiedContents = $this->minifyJsCode($contents);

            $this->writeFileAndCompressed($targetFile, $minifiedContents);
        }

        return $this->returnFileReference($targetFile);
    }

    /**
     * @todo Remove this when TYPO3 8.x is no longer supported!
     *
     * @return bool
     */
    protected function getPublicPath()
    {
        if (version_compare(TYPO3_branch, '9.2', '<')) {
            return PATH_site;
        } else {
            return \TYPO3\CMS\Core\Core\Environment::getPublicPath().'/';
        }
    }

    /**
     * Process minification.
     *
     * @param string $script Script to minfiy
     *
     * @return string Minified code block
     */
    public function minifyJsCode($script)
    {
        return $this->getMinifier()->minify($script);
    }

    /**
     * Returns our minifier instance.
     *
     * @return \FelixNagel\FePerformance\Service\MinifyServiceInterface
     *
     * @throws \Exception
     */
    protected function getMinifier()
    {
        if ($this->minifier === null) {
            $extensionManagerConfiguration = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('fe_performance');

            $minifier = GeneralUtility::makeInstance($extensionManagerConfiguration['minifier']);

            if (!$minifier instanceof MinifyServiceInterface) {
                throw new \Exception('Minifier must implement interface MinifyServiceInterface', 1299088927);
            }

            $this->minifier = $minifier;
        }

        return $this->minifier;
    }
}
