<?php
namespace TYPO3\FePerformance\Resource;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010-2011 Steffen Gebert <steffen@steffen-gebert.de>
 *  (c) 2011 Kai Vogel <kai.vogel@speedprogs.de>
 *  (c) 2013 Felix Nagel <info@felixnagel.com>
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

use TYPO3\CMS\Core\Utility\PathUtility;

/**
 * Compressor (taken from sysext core)
 * Added JavaScript minification and a pending patch
 *
 * @package fe_performance
 * @author 	Felix Nagel <info@felixnagel.com>
 */
class ResourceCompressor extends \TYPO3\CMS\Core\Resource\ResourceCompressor {

	/**
	 * @var \TYPO3\FePerformance\Service\MinifyService
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
		$filenameAbsolute = \TYPO3\CMS\Core\Utility\GeneralUtility::resolveBackPath($this->rootPath . $this->getFilenameFromMainDir($filename));
		$unique = $filenameAbsolute . filemtime($filenameAbsolute) . filesize($filenameAbsolute);
		$pathinfo = PathUtility::pathinfo($filename);
		$targetFile = $this->targetDirectory . $pathinfo['filename'] . '-' . md5($unique) . '.min.js';

		// only create it, if it doesn't exist, yet
		if (!file_exists((PATH_site . $targetFile)) || $this->createGzipped && !file_exists((PATH_site . $targetFile . '.gzip'))) {
			$contents = \TYPO3\CMS\Core\Utility\GeneralUtility::getUrl($filenameAbsolute);
			$minifiedContents = $this->minifyJsCode($contents, $filename);

			$this->writeFileAndCompressed($targetFile, $minifiedContents);
		}

		return $this->relativePath . $this->returnFileReference($targetFile);
	}

	/**
	 * Process minification
	 *
	 * @param string $script Script to minfiy
	 * @param string $filename Filename or key for code block
	 *
	 * @return string Minified code block
	 */
	public function minifyJsCode($contents, $filename = "") {
		return $this->getMinifier()->processJavaScript($contents, $filename);
	}

	/**
	 * Returns instance of t3lib_Compressor
	 *
	 * @return \TYPO3\CMS\Core\Resource\ResourceCompressor Instance of t3lib_Compressor
	 */
	protected function getMinifier() {
		if ($this->minifier === NULL) {
			$this->minifier = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\FePerformance\\Service\\MinifyService');
		}

		return $this->minifier;
	}
}


?>