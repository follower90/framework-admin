<?php

namespace App\Service;

class NovaPoshta
{
	public static function getCities()
	{
		$params = [
			"modelName" => "Address",
			"calledMethod" => "getCities"
		];

		return static::fetchData($params);
	}

	public static function getWarehouses($cityRef)
	{
		$params = [
			"modelName" => "AddressGeneral",
			"calledMethod" => "getWarehouses",
			"methodProperties" => [
				"CityRef" => $cityRef
			]
		];

		return static::fetchData($params);
	}

	public static function fetchData($params)
	{
		$params = array_merge($params, ['apiKey' => static::_apiKey()]);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($ch, CURLOPT_URL, 'http://api.novaposhta.ua/v2.0/json/');
		curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));

		$output = json_decode(curl_exec($ch), true);
		curl_close($ch);

		return $output['data'];
	}

	private static function _apiKey()
	{
		return \Admin\Object\Setting::get('nova_poshta_api_key');
	}
}