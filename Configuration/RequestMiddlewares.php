<?php

return [
    'frontend' => [
        'felixnagel/fePerformance/minify-html' => [
            'target' => \FelixNagel\FePerformance\Middleware\HtmlMinifyMiddleware::class,
            'before' => [
                'typo3/cms-frontend/content-length-headers',
                'typo3/cms-frontend/output-compression',
            ],
        ],
    ],
];
