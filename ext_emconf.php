<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "fe_performance".
 *
 * Auto generated 10-06-2013 22:33
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = [
    'title' => 'Frontend Performance',
    'description' => 'This TYPO3 CMS extension improves your frontend performance. Adds JS and HTML minification and some minor improvements. See readme.',
    'category' => 'fe',
    'author' => 'Felix Nagel',
    'author_email' => 'info@felixnagel.com',
    'author_company' => '',
    'state' => 'stable',
    'uploadfolder' => '0',
    'clearCacheOnLoad' => 0,
    'version' => '1.0.1-dev',
    'constraints' => [
        'depends' => [
            'php' => '7.0.0-7.4.99',
            'typo3' => '8.7.0-9.5.99',
        ],
        'conflicts' => [
            'scriptmerger' => '',
        ],
        'suggests' => [],
    ],
    'autoload' => [
        'psr-4' => [
            'FelixNagel\\FePerformance\\' => 'Classes',
        ],
        'classmap' => [
            "Resources/Private/Php/JavaScriptMinifier.php",
            "Resources/Private/Php/jsminplus.php"
        ],
    ],
];
