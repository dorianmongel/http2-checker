<?php

error_reporting(0);

echo  '== SCRIPT HTTP2 =='."\n";

$urlsHosted       = array();
$fn               = fopen("websites.txt","r");
while(! feof($fn))  {
  $line           = fgets($fn);
  if( trim($line) != ""){
    if(substr($line,0,1) != '#'){
      $urlsHosted[]   = trim($line);
    }
  }
}
fclose($fn);

foreach( $urlsHosted as $url){

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL            => $url,
    CURLOPT_HEADER         => true,
    CURLOPT_NOBODY         => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_2_0,
]);
$response = curl_exec($ch);

if ($response !== false && strpos($response, "HTTP/2") === 0) {
    echo  "\033[1;32m"  . '✔ ' . $url . "\033[0m" . "\n";
} elseif ($response !== false) {
    echo  "\033[0;31m" . '✘ ' . $url . "\033[0m" ."\n";
} else {
    echo  "\033[0;31m" . '✘ Erreur connexion ' . $url . "\033[0m" ."\n";
}
curl_close($ch);

}

