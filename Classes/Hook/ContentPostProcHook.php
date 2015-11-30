<?php

namespace TYPO3\FePerformance\Hook;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014-2015 Felix Nagel <info@felixnagel.com>
 *  (c) 2015 Tim Lochmüller
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

use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * Hook within tslib/class.tslib_fe.php
 *
 * Some parts taken from https://github.com/lochmueller/sourceopt
 *
 * @author Felix Nagel (info@felixnagel.com)
 * @package fe_performance
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ContentPostProcHook {

	/**
	 * @var string
	 */
	protected $extKey = 'fe_performance';

	/**
	 * Hook for adjusting the HTML <body> output
	 *
	 * @param TypoScriptFrontendController $typoScriptFrontend
	 *
	 * @return void
	 */
	protected function process(TypoScriptFrontendController &$typoScriptFrontend) {
		if ($typoScriptFrontend->type !== 0) {
			return;
		}

		$typoScriptFrontend->content = $this->minifyHtml($typoScriptFrontend->content);
	}

	/**
	 * Hook is called before Caching!
	 * => for modification of pages on their way in the cache.
	 *
	 * @param array $parameters
	 *
	 * @return void
	 */
	public function processCachedContent(&$parameters) {
		$tsfe = &$parameters['pObj'];

		if ($tsfe instanceof TypoScriptFrontendController) {
			if ($tsfe->isINTincScript() === FALSE) {
				$this->process($tsfe);
			}
		}
	}

	/**
	 * Hook is called after Caching!
	 * => for modification of pages with COA_/USER_INT objects.
	 *
	 * @param array $parameters
	 *
	 * @return void
	 */
	public function processUncachedContent(&$parameters) {
		$tsfe = &$parameters['pObj'];

		if ($tsfe instanceof TypoScriptFrontendController) {
			if ($tsfe->isINTincScript() === TRUE) {
				$this->process($tsfe);
			}
		}
	}

	/**
	 * Minify HTML string
	 *
	 * Taken from:
	 * http://stackoverflow.com/questions/5312349/minifying-final-html-output-using-regular-expressions-with-codeigniter
	 *
	 * @todo Fix this for hidden inputs
	 *
	 * This does not handle simple <input type="hidden"> elements
	 * which would be needed for textareas with above representation
	 * Example: EXT:form with textarea and confirm view
	 *
	 * @param string $html
	 *
	 * @return string
	 */
	public function minifyHtml($html) {
		$regex = '%# Collapse whitespace everywhere but in blacklisted elements.
			(?>             # Match all whitespaces other than single space.
			  [^\S ]\s*     # Either one [\t\r\n\f\v] and zero or more ws,
			| \s{2,}        # or two or more consecutive-any-whitespace.
			) # Note: The remaining regex consumes no text at all...
			(?=             # Ensure we are not in a blacklist tag.
			  [^<]*+        # Either zero or more non-"<" {normal*}
			  (?:           # Begin {(special normal*)*} construct
				<           # or a < starting a non-blacklist tag.
				(?!/?(?:textarea|pre|code|script)\b)
				[^<]*+      # more non-"<" {normal*}
			  )*+           # Finish "unrolling-the-loop"
			  (?:           # Begin alternation group.
				<           # Either a blacklist start tag.
				(?>textarea|pre|code|script)\b
			  | \z          # or end of file.
			  )             # End alternation group.
			)  # If we made it here, we are not in a blacklist tag.
			%Six';

		$output = preg_replace($regex, ' ', $html);

		if ($output === NULL) {
			return $html;
		}

		return $output;
	}

}
