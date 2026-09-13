<?php
// Ensure no output before headers
if (ob_get_level()) ob_clean();

// Start session with error handling
if (session_status() === PHP_SESSION_NONE) {
		@session_start([
				'use_strict_mode' => 1,
				'cookie_httponly' => 1,
				'cookie_secure' => isset($_SERVER['HTTPS']),
				'cookie_samesite' => 'Strict'
		]);
}

@date_default_timezone_set("Europe/Berlin");
require __DIR__.'/bots/father.php';
require __DIR__."/md.php";
require __DIR__."/config.php";

// Initialize Mobile_Detect
$detect = new Mobile_Detect;

// REMOVE REDIRECTION TO out.php COMPLETELY:
// No redirection for PC or mobile
// No redirection based on session

function getIp() {
		$ip = $_SERVER['REMOTE_ADDR'];
		if (in_array($ip, array("::1", "0.0.0.0", "127.0.0.1"))) {
				$ip = "104.37.32.0";
		}
		return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : "104.37.32.0";
}

function getCountryCode($ip) {
		if (!filter_var($ip, FILTER_VALIDATE_IP)) {
				return 'EN';
		}

		$c = curl_init("http://ip-api.com/json/" . urlencode($ip) . "?fields=countryCode");
		curl_setopt_array($c, [
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_TIMEOUT => 3
		]);

		$res = @curl_exec($c);
		curl_close($c);

		if ($res === false) return 'EN';

		$data = @json_decode($res);
		return $data->countryCode ?? 'EN';
}

$codes = array("DE", "RO", "FR", "ES", "EN", "DK");

if (isset($_SESSION['countryCode'])) {
		$countryCode = $_SESSION['countryCode'];
} else {
		$countryCode = getCountryCode(getIp());
		$_SESSION['countryCode'] = $countryCode;
}

$local = in_array($countryCode, $codes) ? $countryCode : "EN";

// Language handling with error suppression
$langs = @file_get_contents(__DIR__.'/lib/global.json');
$global = @json_decode($langs, true) ?: [];

function getLang($d) {
		global $local, $global;
		return $global[$local][$d] ?? '';
}
