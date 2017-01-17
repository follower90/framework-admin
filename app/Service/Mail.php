<?php

namespace App\Service;

use \PHPMailer as PHPMailer;
use \Admin\Object\Setting as Setting;

class Mail
{
	public static function send($email, $subject, $body, $attachments = [])
	{
		$siteName = Setting::get('sitename');
		$siteEmail = Setting::get('phpmailer.username');

		$mail = new PHPMailer();
		$mail->isSMTP();

		$mail->SMTPAuth = true;
		$mail->CharSet = 'UTF-8';
		$mail->Host = Setting::get('phpmailer.host');
		$mail->Username = Setting::get('phpmailer.username');
		$mail->Password = Setting::get('phpmailer.password');
		$mail->SMTPSecure = Setting::get('phpmailer.secure');
		$mail->Port = Setting::get('phpmailer.port');

		foreach ($attachments as $file) {
			$mail->addAttachment($file);
		}

		$mail->isHTML(true);

		$mail->setFrom($siteEmail, $siteName);
		$mail->addAddress($email);

		$mail->Subject = $subject;
		$mail->Body = $body;

		$mail->send();
	}
}
