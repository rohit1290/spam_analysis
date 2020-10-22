<?php

use Elgg\DefaultPluginBootstrap;

class SpamAnalysis extends DefaultPluginBootstrap {
	
	/**
	 * {@inheritDoc}
	 * @see \Elgg\DefaultPluginBootstrap::init()
	 */
	public function init() {
		
		// register datatable libs
		elgg_require_css('datatables/datatables.min');
		elgg_define_js('datatables/datatables.min', []);

    // register hooks - register
  	elgg_register_plugin_hook_handler("action:validate", "register", function(\Elgg\Hook $hook) {
    
      if(elgg_is_active_plugin('spam_login_filter')) {
				$email = get_input('email');
				$ip = \Spam\LoginFilter\get_ip();
        if (!\Spam\LoginFilter\check_spammer($email, $ip)) {
          save_spam_log_to_txt($email, $ip, "action:validate-register");
        }
      }
      return $hook->getValue();
    });
    
		// register hooks - send_mail
  	elgg_register_plugin_hook_handler("action:validate", "send_mail", function(\Elgg\Hook $hook) {
    
      if(elgg_is_active_plugin('spam_login_filter')) {
				$ip = \Spam\LoginFilter\get_ip();
				$email = get_input('email');
        if (!\Spam\LoginFilter\check_spammer($email, $ip)) {
          save_spam_log_to_txt($email, $ip, "action:validate-send_mail");
        }
      }
      return $hook->getValue();
    });
			
		// plugin hook cron daily
		elgg_register_plugin_hook_handler('cron', 'daily', 'remove_old_log_files');
		
		// Register Ajax view
		elgg_register_ajax_view('managespam/popup');

		// Administer Utilities Menu
  	elgg_register_menu_item('page', [
  		'name' => 'managespam',
  		'href' => 'admin/administer_utilities/managespam',
  		'text' => elgg_echo('admin:administer_utilities:managespam'),
  		'context' => 'admin',
  		'parent_name' => 'administer_utilities',
  		'section' => 'administer',
  	]);
		
  }
}
 ?>