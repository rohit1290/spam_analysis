<?php
elgg_load_css('datatables.css');

$log = get_spam_logs();

$tabs = [
	[
		'text' => elgg_echo('Emails'),
		'content' => elgg_view('admin/managespam/segment', [
      'table' => $log['email'],
      'dates' => array_values($log['date']),
      'name' => 'Email',
    ]),
		'selected' => true,
	],
	[
		'text' => elgg_echo('Domains'),
    'content' => elgg_view('admin/managespam/segment', [
      'table' => $log['domain'],
      'dates' => array_values($log['date']),
      'name' => 'Domain',
    ]),
	],
	[
		'text' => elgg_echo('IPs'),
    'content' => elgg_view('admin/managespam/segment', [
      'table' => $log['ip'],
      'dates' => array_values($log['date']),
      'name' => 'IP',
    ]),
	],
];

echo elgg_view('page/components/tabs', [
	'tabs' => $tabs,
]);

elgg_require_js('admin/administer_utilities/managespam');
?>