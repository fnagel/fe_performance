<?php
namespace TYPO3\FePerformance\Service;

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Felix Nagel <f.nagel@paints.de>
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
 * ************************************************************* */

/**
 * Service for providing minifier classes
 *
 * @author Felix Nagel (info@felixnagel.com)
 * @package fe_performance
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class MinifyService implements \TYPO3\CMS\Core\SingletonInterface {

	/**
	 * @var string
	 */
	protected $extKey = 'fe_performance';

	/**
	 * Constructor
	 *
	 */
	public function __construct() {
		$filepath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($this->extKey) . "Resources/Private/Php/jsminplus.php";
		\TYPO3\CMS\Core\Utility\GeneralUtility::requireOnce($filepath);
	}

	/**
	 * Loads module data for user settings or returns a fresh object initially
	 *
	 * @param string $script Script to minfiy
	 * @param string $filename Filename or key for code block
	 * @return string
	 */
	public function processJavaScript($script, $filename = '') {
		return \JSMinPlus::minify($script, $filename);
	}

}

?>