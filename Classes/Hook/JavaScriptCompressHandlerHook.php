<?php

namespace TYPO3\FePerformance\Hook;

use TYPO3\CMS\Core\Utility\GeneralUtility,
	TYPO3\CMS\Core\Page\PageRenderer;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013-2015 Felix Nagel <info@felixnagel.com>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Hook within t3lib\class.t3lib_pagerenderer.php
 * http://forge.typo3.org/issues/33370
 *
 * @author Felix Nagel (info@felixnagel.com)
 * @package fe_performance
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class JavaScriptCompressHandlerHook {

	/**
	 * @var \TYPO3\FePerformance\Resource\ResourceCompressor
	 */
	protected $compressor;

	/**
	 * Uses modified ResourceCompressor class to process JS
	 *
	 * @param array $params
	 * @return void
	 *
	 * @see \TYPO3\CMS\Core\Page\PageRenderer
	 */
	public function process(array $params) {
		if (count($params['jsInline'])) {
			foreach ($params['jsInline'] as $name => $properties) {
				if ($properties['compress']) {
					$params['jsInline'][$name]['code'] = $this->getCompressor()->minifyJsCode($properties['code'], $name);
				}
			}
		}

		$params['jsLibs'] = $this->getCompressor()->compressJsFiles($params['jsLibs']);
		$params['jsFiles'] = $this->getCompressor()->compressJsFiles($params['jsFiles']);
		$params['jsFooterFiles'] = $this->getCompressor()->compressJsFiles($params['jsFooterFiles']);
	}

	/**
	 * Returns instance of ResourceCompressor
	 *
	 * @return \TYPO3\FePerformance\Resource\ResourceCompressor Instance of ResourceCompressor
	 */
	protected function getCompressor() {
		if ($this->compressor === NULL) {
			$this->compressor = GeneralUtility::makeInstance('TYPO3\\FePerformance\\Resource\\ResourceCompressor');
		}

		return $this->compressor;
	}

}
