<?php

use FelixNagel\FePerformance\Middleware\HtmlMinifyMiddleware;

return [
    'frontend' => [
        'felixnagel/fePerformance/minify-html' => [
            'target' => HtmlMinifyMiddleware::class,
            'before' => [
                'typo3/cms-frontend/content-length-headers',
                'typo3/cms-frontend/output-compression',
            ],
        ],
    ],
];
