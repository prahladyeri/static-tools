<?php
/*
 * Contact Form for static websites
 * 
 * @author Prahlad Yeri<prahladyeri@yahoo.com>
 * @copyright MIT license
 * @date 2016-06-03
 * */
require_once("db.php");
require_once('class.phpmailer.php');
require_once('class.smtp.php');

$email = $_POST["email"];
$name =  $_POST["name"];
$subject = $_POST["subject"];
$body = $_POST["body"];
$adminName = $config["name"];

//first send thanking email to poster
$mail = new PHPMailer(); // create a new object
$mail->IsSMTP(); // enable SMTP
$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPAuth = true; // authentication enabled
$mail->SMTPSecure = $config["smtp_secure"]; //'ssl'; // secure transfer enabled REQUIRED for Gmail
$mail->Host = $config["host"]; //;
$mail->Port =  $config["port"]; //; 
$mail->IsHTML(true);
$mail->Username = $config["username"];//"	";
$mail->Password = $config["password"]; //"";
$mail->SetFrom($config["username"]);
$mail->Subject = "RE: ".$subject;
$mail->Body = <<<EODL
<pre>
Hi $name,

Thanks a lot for visiting my website and filling this form, I really appreciate that!
I'll go through your requirements and will get back to you soon.

Regards,
$adminName
</pre>
EODL;
$mail->AddAddress($email);
if(!$mail->Send()) 
{
	echo "Mailer Error: " . $mail->ErrorInfo;
}

//then send the matter to yourself
$mail = new PHPMailer(); // create a new object
$mail->IsSMTP(); // enable SMTP
//$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPAuth = true; // authentication enabled
$mail->SMTPSecure = $config["smtp_secure"]; //'ssl'; // secure transfer enabled REQUIRED for Gmail
$mail->Host = $config["host"]; //;
$mail->Port =  $config["port"]; //; 
$mail->IsHTML(true);
$mail->Username = $config["username"];//"	";
$mail->Password = $config["password"]; //"";
$mail->SetFrom($config["username"]);
$mail->Subject = $subject;
$mail->Body = $body;
$mail->AddAddress($config["username"]);
//echo "success";
 if(!$mail->Send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
 } 
 else {
    echo "success";
 }
