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
    'description' => 'This extension improves the TYPO3 frontend performance. Adds JS and HTML minification and some minor improvements. See readme.',
    'category' => 'fe',
    'author' => 'Felix Nagel',
    'author_email' => 'info@felixnagel.com',
    'author_company' => '',
    'priority' => '',
    'state' => 'stable',
    'uploadfolder' => '0',
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '0.6.2-dev',
    'constraints' => [
        'depends' => [
            'php' => '5.5.0-7.1.99',
            'typo3' => '7.0.0-8.7.99',
        ],
        'conflicts' => [
            'scriptmerger' => '',
        ],
        'suggests' => [],
    ],
];
