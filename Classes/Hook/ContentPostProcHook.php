<?php

namespace FelixNagel\FePerformance\Hook;

/**
 * This file is part of the "fe_performance" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * Hook within tslib/class.tslib_fe.php.
 *
 * Some parts taken from https://github.com/lochmueller/sourceopt
 */
class ContentPostProcHook
{
    /**
     * @var string
     */
    protected $extKey = 'fe_performance';

    /**
     * Hook for adjusting the HTML <body> output.
     *
     * @param TypoScriptFrontendController $typoScriptFrontend
     */
    protected function process(TypoScriptFrontendController &$typoScriptFrontend)
    {
        if ($typoScriptFrontend->type !== 0) {
            return;
        }

        // @extensionScannerIgnoreLine
        $typoScriptFrontend->content = $this->minifyHtml($typoScriptFrontend->content);
    }

    /**
     * Hook is called before Caching!
     * => for modification of pages on their way in the cache.
     *
     * @param array $parameters
     */
    public function processCachedContent(&$parameters)
    {
        $tsfe = &$parameters['pObj'];

        if ($tsfe instanceof TypoScriptFrontendController) {
            if ($tsfe->isINTincScript() === false) {
                $this->process($tsfe);
            }
        }
    }

    /**
     * Hook is called after Caching!
     * => for modification of pages with COA_/USER_INT objects.
     *
     * @param array $parameters
     */
    public function processUncachedContent(&$parameters)
    {
        $tsfe = &$parameters['pObj'];

        if ($tsfe instanceof TypoScriptFrontendController) {
            if ($tsfe->isINTincScript() === true) {
                $this->process($tsfe);
            }
        }
    }

    /**
     * Minify HTML string.
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
    public function minifyHtml($html)
    {
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

        if ($output === null) {
            return $html;
        }

        return $output;
    }
}
