<?php
require_once __DIR__ . '/libs/functions.php';

return [
	'bootstrap' => SpamAnalysis::class,
	'views' => [
		'default' => [
			'datatables/' => __DIR__ . '/vendor/datatables',
		],
	],
];
