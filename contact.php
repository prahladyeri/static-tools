<?php
/*
 * Contact Form for static websites
 * 
 * @author Prahlad Yeri<prahladyeri@yahoo.com>
 * @date 2016-06-03
 * */

//Implement CORS (Cross origin resource sharing)
if (array_key_exists('HTTP_ORIGIN', $_SERVER)) {
	switch ($_SERVER['HTTP_ORIGIN']) 
	{
		case 'http://prahladyeri.com': case 'https://prahladyeri.com':
		case 'http://www.prahladyeri.com': case 'https://www.prahladyeri.com':
		case 'http://127.0.0.1:4000': case 'https://127.0.0.1:4000':
		header('Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN']);
		header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
		header('Access-Control-Max-Age: 1000');
		header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		break;
	}
}
 
require_once("db.php");
require_once('class.phpmailer.php');
require_once('class.smtp.php');

if ($_SERVER["REQUEST_METHOD"] != "POST") {
	//echo $_SERVER["REQUEST_METHOD"];
	echo "Invalid method";
	exit;
}

$email = htmlspecialchars($_POST["email"]);
$name =  htmlspecialchars($_POST["name"]);
$subject = htmlspecialchars($_POST["subject"]);
$body = htmlspecialchars($_POST["body"]);
$adminName = $config["name"];

//first send thanking email to poster
$mail = new PHPMailer(); // create a new object
$mail->IsSMTP(); // enable SMTP
$mail->CharSet  =  "utf-8";
//$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPAuth = true; 
$mail->SMTPSecure = $config["smtp_secure"]; //"ssl";
$mail->Host = $config["host"];  //"smtp.gmail.com"; 
//error_log("HOST IS::".$config["host"]);
$mail->Port =  $config["port"]; //465 or 583;
//$mail->IsHTML(false);
$mail->Username = $config["username"]; //""; 
$mail->Password = $config["password"]; //"";
$mail->SetFrom($config["username"]);

$mail->Subject = "RE: ".$subject;
$mail->Body = <<<EODL
Hi $name,

Thanks a lot for visiting my website and filling this form, I really appreciate that!
I'll go through your requirements and will get back to you soon.

Regards,
$adminName
EODL;
$mail->AddAddress($email);
if(!$mail->Send()) 
{
    echo json_encode(array( "Mailer Error: " . $mail->ErrorInfo));
}

//then send the matter to yourself
$mail = new PHPMailer(); // create a new object
$mail->IsSMTP(); // enable SMTP
$mail->CharSet  =  "utf-8";
//$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPAuth = true; 
$mail->SMTPSecure = $config["smtp_secure"]; //"ssl";
$mail->Host = $config["host"];  //"smtp.gmail.com"; 
$mail->Port =  $config["port"]; //465;
//$mail->IsHTML(false);
$mail->Username = $config["username"]; //""; 
$mail->Password = $config["password"]; //"";
$mail->SetFrom($config["from_address"], $config["name"]);

$mail->Subject = $subject;
$mail->Body = "From: $email ($name)\n\n".$body;
$mail->AddAddress($config["username"]);
//echo "success";
 if(!$mail->Send()) {
    echo json_encode(array( "Mailer Error: " . $mail->ErrorInfo));
 } 
 else {
    echo json_encode(array("success"));
 }
