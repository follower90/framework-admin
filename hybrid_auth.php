<?php

use \Admin\Object\Setting;
use \Core\Router;

return array(
	"base_url" => "http://" . Router::get('host') . "/vendor/hybridauth/hybridauth/hybridauth/",
	"providers" => array(
		"Google" => array(
			"enabled" => true,
			"keys" => array("id" => Setting::get('google_api_key'), "secret" => Setting::get('google_api_secret')),
		),
		"Facebook" => array(
			"enabled" => true,
			"keys" => array("id" => Setting::get('facebook_api_key'), "secret" => Setting::get('facebook_api_secret')),
			"trustForwarded" => false, "scope" => array("public_profile", "email")
		),
		"Twitter" => array(
			"enabled" => true,
			"keys" => array("key" => Setting::get('twitter_api_key'), "secret" => Setting::get('twitter_api_secret')),
			"includeEmail" => false,
		),
		"Vk" => array(
			"enabled" => true,
			"keys" => array("id" => Setting::get('vk_api_key'), "secret" => Setting::get('vk_api_secret')),
		),
	),
	"debug_mode" => false,
	"debug_file" => "",
);
