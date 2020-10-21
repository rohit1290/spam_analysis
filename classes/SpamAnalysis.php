<?php

use Elgg\DefaultPluginBootstrap;

class SpamAnalysis extends DefaultPluginBootstrap {
	
	/**
	 * {@inheritDoc}
	 * @see \Elgg\DefaultPluginBootstrap::init()
	 */
	public function init() {
		
    // register hooks
  	elgg_register_plugin_hook_handler("action:validate", "register", function(\Elgg\Hook $hook) {
    
      if(elgg_is_active_plugin('spam_login_filter')) {
				// error_log("action:validate called");
				$email = get_input('email');
				$ip = get_ip();
        if (!\Spam\LoginFilter\check_spammer($email, $ip)) {
					// error_log("action:validate check_spammer called");
          save_spam_log_to_txt($email, $ip, "action:validate-register");
        }
      }

      return $hook->getValue();

    });
    
		/*
    elgg_register_plugin_hook_handler('register', 'user', function(\Elgg\Hook $hook) {

      if(elgg_is_active_plugin('spam_login_filter')) {
				// error_log("register:user called");
        $p = $hook->getParams();
        $email = $p['user']->email;
        $ip = get_ip();
        if (!\Spam\LoginFilter\check_spammer($email, $ip)) {
					// error_log("register:user check_spammer called");
          save_spam_log_to_txt($email, $ip, "action:validate-register");
        }
      }
      
      return $hook->getValue();
    });
		*/
		
		elgg_register_plugin_hook_handler('cron', 'daily', 'remove_old_log_files');

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