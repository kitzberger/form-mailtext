<?php
$EM_CONF[$_EXTKEY] = [
	'title' => 'Form: Mailtexts via plugin',
	'description' => 'This extension enhances the Email finishers of EXT:form by a new field "Mail text" (message) that allows the editor to define the mail text within the form plugin in the backend.',
	'category' => 'system',
	'state' => 'stable',
	'author' => 'Philipp Kitzberger',
	'author_email' => 'typo3@kitze.net',
	'author_company' => '',
	'version' => '2.1.4',
	'constraints' => [
		'depends' => [
			'typo3' => '10.4.11-12.4.99',
			'form' => '10.4.11-12.4.99',
		],
		'conflicts' => [],
		'suggests' => [],
	],
];
