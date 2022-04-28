<?php

namespace FelixNagel\FePerformance\Middleware;

/**
 * This file is part of the "fe_performance" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use FelixNagel\FePerformance\Utility\ExtensionConfigurationUtility;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Http\Stream;

class HtmlMinifyMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);

        if (ExtensionConfigurationUtility::get('minifyHtml')) {
            $html = $this->minifyHtml($response->getBody()->__toString());

            $body = new Stream('php://temp', 'rw');
            $body->write($html);

            $response = $response->withBody($body);
        }

        return $response;
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

        return $output ?? $html;
    }
}
