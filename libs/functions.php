<?php

function save_spam_log_to_txt($email, $ip, $call_from) {
  
  $email = str_replace(array("\n", "\r"), '', $email);
  $ip = str_replace(array("\n", "\r"), '', $ip);
  $call_from = str_replace(array("\n", "\r"), '', $call_from);
  
  $filename = date("Ymd");
  $date = date("Y-m-d H:i:s");
  $domain_name = substr(strrchr($email, "@"), 1);
  
  $path = _elgg_config()->dataroot."spam_analysis";
  if(!file_exists($path)) {
  	mkdir($path, 0777, true);
	}
  
  $file_path = "{$path}/{$filename}";

  file_put_contents($file_path, "{$date}|{$call_from}|{$email}|{$domain_name}|{$ip}\n", FILE_APPEND | LOCK_EX);

}

function get_spam_logs() {
  
  $log_show_days = (int)$setting = elgg_get_plugin_setting('log_show_days', 'spam_analysis', 5);
  for ($i = 0; $i < $log_show_days ; $i++) {
    $scope_date[] = date("Y-m-d", strtotime("-{$i} day"));
  }
  
  $lines = get_spam_log_from_txt();
  if(count($lines) > 0 ) {
    foreach ($lines as $linenum => $value) {
      if($value == "") { continue; }
      $elem = explode("|", $value);
      $tmp_date = date("Y-m-d", strtotime($elem[0]));
      
      // elem 0 - Date
      // elem 1 - call from
      // elem 2 - email
      // elem 3 - domain
      // elem 4 - ip
      
      if(in_array($tmp_date, $scope_date)) {
        // Email
        $return['email'][$elem[2]][$tmp_date] += 1;
        // Domain
        $return['domain'][$elem[3]][$tmp_date] += 1;
        // IP
        $return['ip'][$elem[4]][$tmp_date] += 1;
        // Date
        $return['date'][$tmp_date] = $tmp_date;
      }

      // Domain
      $return['domain'][$elem[3]]['total'] += 1;
      // Email
      $return['email'][$elem[2]]['total'] += 1;
      // IP
      $return['ip'][$elem[4]]['total'] += 1;

    }
  }

  return $return;
}

function get_spam_log_from_txt() {
  
  $log_retain_days = (int)$setting = elgg_get_plugin_setting('log_retain_days', 'spam_analysis', 5);

  for ($i = 0; $i < $log_retain_days ; $i++) {
    $filenames[] = date("Ymd", strtotime("-{$i} day"));
  }
  
  $logs = "";
  $return = [];
  $path = _elgg_config()->dataroot."spam_analysis";
  
  foreach ($filenames as $key => $fn) {
    if($fn == "." || $fn == "..") { continue; }
    if(file_exists("{$path}/{$fn}")) {
      $logs .= file_get_contents("{$path}/{$fn}");
    }
  }
  
  $lines = [];
  $lines = explode("\n", $logs);
  $lines = array_filter($lines);

  return $lines;
}

function remove_old_log_files(\Elgg\Hook $hook) {
  echo "\nSpamAnalysis: Removing Old log files\n<br>";

  $log_retain_days = (int)$setting = elgg_get_plugin_setting('log_retain_days', 'spam_analysis', 5);
  echo "Removing logs older than $log_retain_days days\n<br>";
  
  $filename = (int)date("Ymd", strtotime("-{$log_retain_days} day"));
  $path = _elgg_config()->dataroot."spam_analysis";

  $files = scandir($path);
  foreach ($files as $key => $file) {
    if($file == "." || $file == "..") { continue; }
    echo "File: $file; Filename: $filename ";
    if((int)$file <= $filename) {
      unlink("{$path}/{$file}");
      echo "- Deleted";
    }
    echo "\n<br>";
  }
}

 ?>