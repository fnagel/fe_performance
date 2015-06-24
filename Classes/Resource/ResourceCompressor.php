<?php

namespace TYPO3\FePerformance\Resource;

use TYPO3\FePerformance\Service\MinifyServiceInterface;

use TYPO3\CMS\Core\Utility\PathUtility,
	TYPO3\CMS\Core\Utility\GeneralUtility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010-2011 Steffen Gebert <steffen@steffen-gebert.de>
 *  (c) 2011 Kai Vogel <kai.vogel@speedprogs.de>
 *  (c) 2013-2014 Felix Nagel <info@felixnagel.com>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Compressor (taken from sysext core)
 * Added JavaScript minification and a pending patch
 *
 * @package fe_performance
 * @author 	Felix Nagel <info@felixnagel.com>
 */
class ResourceCompressor extends \TYPO3\CMS\Core\Resource\ResourceCompressor {

	/**
	 * @var string
	 */
	protected $extKey = 'fe_performance';

	/**
	 * @var \TYPO3\FePerformance\Service\MinifyServiceInterface
	 * @inject
	 */
	protected $minifier;


	/**
	 * Minification and gzip compression of a javascript file
	 *
	 * @param string $filename Source filename, relative to requested page
	 *
	 * @return string Filename of the compressed file, relative to requested page
	 */
	public function compressJsFile($filename) {
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
		if (!file_exists((PATH_site . $targetFile)) || $this->createGzipped && !file_exists((PATH_site . $targetFile . '.gzip'))) {
			$contents = GeneralUtility::getUrl($filenameAbsolute);
			$minifiedContents = $this->minifyJsCode($contents);

			$this->writeFileAndCompressed($targetFile, $minifiedContents);
		}

		return $this->relativePath . $this->returnFileReference($targetFile);
	}

	/**
	 * Process minification
	 *
	 * @param string 	$script Script to minfiy
	 *
	 * @return string Minified code block
	 */
	public function minifyJsCode($script) {
		return $this->getMinifier()->minify($script);
	}

	/**
	 * Returns our minifier instance
	 *
	 * @return \TYPO3\FePerformance\Service\MinifyServiceInterface
	 *
	 * @throws \Exception
	 */
	protected function getMinifier() {
		if ($this->minifier === NULL) {
			$extensionManagerConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$this->extKey]);
			$minifier = GeneralUtility::makeInstance($extensionManagerConfiguration['minifier']);

			if (!$minifier instanceof MinifyServiceInterface) {
				throw new \Exception('Minifier must implement interface MinifyServiceInterface', 1299088927);
			}

			$this->minifier = $minifier;
		}

		return $this->minifier;
	}
}


?>