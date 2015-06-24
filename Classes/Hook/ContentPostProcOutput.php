<?php

namespace TYPO3\FePerformance\Hook;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Felix Nagel <info@felixnagel.com>
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
 * Hook within tslib/class.tslib_fe.php
 *
 * @author Felix Nagel (info@felixnagel.com)
 * @package fe_performance
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ContentPostProcOutput {

	/**
	 * @var string
	 */
	protected $extKey = 'fe_performance';

	/**
	 * Hook function for cleaning output XHTML
	 *
	 * @see tslib/class.tslib_fe.php
	 *
	 * @param array $feObj Hook parameters
	 * @param object $ref Reference to parent object (TSFE-obj)
	 *
	 * @return      void
	 */
	public function process(&$feObj, $ref) {
		if ($GLOBALS['TSFE']->type !== 0) {
			return;
		}

		// taken from
		// http://stackoverflow.com/questions/5312349/minifying-final-html-output-using-regular-expressions-with-codeigniter
		$regex = '%# Collapse whitespace everywhere but in blacklisted elements.
			(?>             # Match all whitespans other than single space.
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

		$ref->content = preg_replace($regex, ' ', $ref->content);
	}

}
