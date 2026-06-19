<?php
$iqmaximoLocalConfig = __DIR__ . "/config.local.php";
if (is_file($iqmaximoLocalConfig)) {
	require_once($iqmaximoLocalConfig);
}

function iqmaximo_config($key, $default = "")
{
	if (isset($GLOBALS["IQMAXIMO_CONFIG"]) && array_key_exists($key, $GLOBALS["IQMAXIMO_CONFIG"])) {
		return $GLOBALS["IQMAXIMO_CONFIG"][$key];
	}

	$value = getenv($key);
	return $value === false ? $default : $value;
}
