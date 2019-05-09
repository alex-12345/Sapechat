<?php
declare(strict_types=1);
namespace app\model\service;

use app\controllers\service\Reporter;

class Mailer{
	public static function constructSignUpEmail(string $username, string $calback, string $key):array{
		$body = file_get_contents(__DIR__.'/../../view/emails_tpl/signup.tpl');
		$body = strtr($body, [
			"{username}" => $username,
			"{link}" => $calback,
			"{key}" => $key  
			]);
		$headers = 'From: SAPECHAT <'.NOREPLY_EMAIL.'>' . "\r\n" ;
		$headers .= 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		return ["headers" => $headers, "body" => $body];
		
	}
	public static function sendMail(string $to, string $subject, string $body, string $headers):bool{
		
		$smtp = @stream_socket_client(HOSTMAIL, $errno, $errstr, 15); 
		if($smtp === false){
			return Reporter::error_report(102);
		}
		$B = 8192;
		$c = "\r\n";
		
		fwrite($smtp, 'EHLO ' . API_DOMAIN . $c); 
		  $junk = fgets($smtp, $B);
		  //echo  $junk;
		fwrite($smtp, 'AUTH LOGIN'. $c);
		$junk = fgets($smtp, $B);
		  //echo  $junk;
		
		fwrite($smtp, base64_encode(NOREPLY_EMAIL). $c);
		$junk = fgets($smtp, $B);
		 // echo  $junk;
		fwrite($smtp, base64_encode(NOREPLY_PSWD). $c);
		$junk = fgets($smtp, $B);
		  //echo  $junk;

		fwrite($smtp, 'MAIL FROM: ' . NOREPLY_EMAIL . $c); 
		  $junk = fgets($smtp, $B);
		  //echo  $junk;
		fwrite($smtp, 'RCPT TO: ' . $to . $c);
		  $junk = fgets($smtp, $B);
		  //echo  $junk;
		fwrite($smtp, 'DATA' . $c);
		  $junk = fgets($smtp, $B);
		
		// Header 
		fwrite($smtp, 'To: ' . $to . $c); 
		if(mb_strlen($subject)) fwrite($smtp, 'Subject: ' . $subject . $c); 
		fwrite($smtp, $headers . $c); 
		
		// Body
		if(mb_strlen($body)) fwrite($smtp, $body . $c); 
		fwrite($smtp, $c . '.' . $c);
		  $junk = fgets($smtp, $B);
		  //echo  $junk;
		
		// Close
		fwrite($smtp, 'quit' . $c);
		  $junk = fgets($smtp, $B);
		 // echo  $junk;
		fclose($smtp);
		return true;
	}
	
	
}