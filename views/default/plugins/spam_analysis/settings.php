<?php

echo elgg_view_field([
			'#type' => 'number',
      'min' => 1,
			'required' => true,
			'name' => 'params[log_retain_days]',
			'value' => $vars['entity']->log_retain_days,
			'#label' => 'For how many days you want to retain logs for:',
			'#help' => 'Number of days after which the log will be deleted and no longer will be shown in the analysis. Default = 5.',
    ]);

echo elgg_view_field([
			'#type' => 'select',
			'name' => 'params[log_show_days]',
			'options' => [
				0 => 'None',
				1 => '1 Day',
				2 => '2 Day',
				3 => '3 Day',
				4 => '4 Day',
				5 => '5 Day',
				6 => '6 Day',
				7 => '7 Day',
				8 => '8 Day',
				9 => '9 Day',
				10 => '10 Day',
			],
			'value' => $vars['entity']->log_show_days,
      '#label' => 'For how many days you want to show logs in the utility table:',
			'#help' => 'Number of days after which the log will be shown in the analysis. Default = 5.',
		]);
 ?>