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
    'description' => 'This TYPO3 CMS extension improves your frontend performance. Adds JavaScript and HTML minification. Comes with some useful tweaks to improve asset rendering. See readme for more info.',
    'category' => 'fe',
    'author' => 'Felix Nagel',
    'author_email' => 'info@felixnagel.com',
    'author_company' => '',
    'state' => 'stable',
    'version' => '2.3.0',
    'constraints' => [
        'depends' => [
            'php' => '8.1.0-8.3.99',
            'typo3' => '12.4.0-13.4.99',
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
