<?php
$EM_CONF[$_EXTKEY] = [
	'title' => 'Form: Mailtexts via plugin',
	'description' => '',
	'category' => 'system',
	'state' => 'stable',
	'uploadfolder' => 0,
	'createDirs' => '',
	'clearCacheOnLoad' => 0,
	'author' => 'Philipp Kitzberger',
	'author_email' => 'typo3@kitze.net',
	'author_company' => '',
	'version' => '1.0.1',
	'constraints' => [
		'depends' => [
			'typo3' => '8.7.0-9.5.99',
			'form' => '8.7.0-9.5.99',
		],
		'conflicts' => [],
		'suggests' => [],
	],
];
