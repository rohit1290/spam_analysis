<?php

function save_spam_log_to_txt($email, $ip, $call_from) {
  
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
      
      
      // Email
      $return['email'][$elem[2]][$tmp_date] += 1;
      $return['email'][$elem[2]]['total'] += 1;
      // Domain
      $return['domain'][$elem[3]][$tmp_date] += 1;
      $return['domain'][$elem[3]]['total'] += 1;
      // IP
      $return['ip'][$elem[4]][$tmp_date] += 1;
      $return['ip'][$elem[4]]['total'] += 1;
      
      // Date
      $return['date'][$tmp_date] = $tmp_date;

    }
  }

  return $return;
}

function get_spam_log_from_txt() {
  $filenames[] = date("Ymd");
  $filenames[] = date("Ymd", strtotime('-1 day'));
  $filenames[] = date("Ymd", strtotime('-2 day'));
  $filenames[] = date("Ymd", strtotime('-3 day'));
  $filenames[] = date("Ymd", strtotime('-4 day'));
  
  $logs = "";
  $return = [];
  $path = _elgg_config()->dataroot."spam_analysis";
  
  foreach ($filenames as $key => $fn) {
    if(file_exists("{$path}/{$fn}")) {
      $logs .= file_get_contents("{$path}/{$fn}");
    }
  }
  
  $lines = [];
  $lines = explode("\n", $logs);

  return $lines;
}

function remove_old_log_files(\Elgg\Hook $hook) {
  $filename = (int)date("Ymd", strtotime('-5 day'));
  $path = _elgg_config()->dataroot."spam_analysis";

  $files = scandir($path);
  foreach ($files as $key => $file) {
    if((int)$file <= $filename) {
      unlink("{$path}/{$file}");
    }
  }
}

 ?>