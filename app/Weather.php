<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
	public static function get($type, $lat, $lng)
	{
		$url = 'http://api.wunderground.com/api/' . env('API_WEATHER') . '/' . $type . '/lang:JP/q/' . $lat . ',' . $lng . '.json';
		$response = self::getCurl($url);
		
		return $response;
	}

	public static function getCurl($url)
	{
		if(function_exists('curl_exec')) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
			curl_setopt($ch, CURLOPT_TIMEOUT, 60);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$response = curl_exec($ch);
			curl_close($ch);
		}

		if (empty($response)) {
			$response = file_get_contents($url);
		}

		return json_decode($response, true);
	}
}
