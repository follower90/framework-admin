<?php

namespace App\Service;

class Mail
{

	public static function send($email, $subject, $body, $attachments)
	{
		$siteName = \Admin\Object\Setting::get('sitename');
		$siteEmail = \Admin\Object\Setting::get('email');

		return \Core\Library\Mail::send($siteName, $siteEmail, $email, $email, $subject, $body, $attachments);
	}
}