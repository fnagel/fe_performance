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

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Frontend Performance',
	'description' => 'This extension improves the TYPO3 frontend performance. Adds JS and HTML minification and some minor improvements. See readme.',
	'category' => 'be',
	'author' => 'Felix Nagel',
	'author_email' => 'info@felixnagel.com',
	'author_company' => '',
	'shy' => '',
	'priority' => '',
	'module' => '',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => '0',
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'version' => '0.6.0-dev',
	'dependencies' => '',
	'conflicts' => '',
	'constraints' => array(
		'depends' => array(
			'php' => '5.5.0-7.0.99',
			'typo3' => '7.0.0-7.6.99',
		),
		'conflicts' => array(
			'scriptmerger' => '',
		),
		'suggests' => array(),
	),
);
