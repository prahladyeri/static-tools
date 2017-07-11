<?php
/*
 * Tools for static website hosting
 * 
 * @author Prahlad Yeri<prahladyeri@yahoo.com>
 * @date 2016-06-03
 * */
$version = "1.0.4";
require_once('db.php');
if ($config["admin_password"] != "") {
	//password protect this page
	if (!isset($_SERVER['PHP_AUTH_USER'])) 
	{
		header('WWW-Authenticate: Basic realm="Static Forms"');
		header('HTTP/1.0 401 Unauthorized');
		echo 'You are not authorized to view this page'; //echo if user cancels.
		exit;
	} 
	else {
		//echo "<p>Hello {$_SERVER['PHP_AUTH_USER']}.</p>";
		//echo "<p>You entered {$_SERVER['PHP_AUTH_PW']} as your password.</p>";
		if ($_SERVER['PHP_AUTH_USER'] == "admin" && $_SERVER['PHP_AUTH_PW'] == $config["admin_password"]) 
		{
			//logged in
		}
		else  {
			echo "Incorrect password/username";
			exit;
		}
	}
}

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$config["name"] = $_POST["name"];
	$config["host"] = $_POST["host"];
	$config["port"] = $_POST["port"];
	$config["smtp_secure"] = $_POST["smtp_secure"];
	$config["from_address"] = $_POST["from_address"];
	$config["username"] = $_POST["username"];
	$config["password"] = $_POST["password"];
	$config["admin_password"] =  $_POST["admin_password"];
	
	$dbh->prepare("delete from config;")->execute();
	
	$sth = $dbh->prepare("insert into config values(?,?,?,?,?,?,?,?);");
	$sth->execute(array(
		$config["name"],
		$config["host"],
		$config["port"],
		$config["smtp_secure"],
		$config["from_address"],
		$config["username"],
		$config["password"],
		$config["admin_password"],
	));
	
	$message = "Record Saved!";
}
?>
<!DOCTYPE html>
<html lang='en'>
<head>
	<link rel='stylesheet' href='pure-min-0.6.css'>
	<title>Static Forms v<?=$version?></title>
	<script src="jquery-1.11.1.min.js"></script>
</head>
<body style='margin-left:20px;'>
	<style>
	body {
		/*text-align: center;*/
		/*background: rgb(103, 140, 215) none repeat scroll 0% 0%;*/
		background: #009688 none repeat scroll 0% 0%;
		font-family: arial;
	}
		
	.loading #testContactForm
	{
		background-image: url("ajax.gif");
		background-repeat: no-repeat;
		background-position: right;
		padding-right: 25px;
	}
	</style>
	
	<?php
	echo "<h1>Welcome to Static Tools Admin v$version </h1>";
	?>
	<form method="POST" action="">
		<fieldset>
			<legend>Admin Configuration</legend>
		<label>Admin Name:&nbsp;</label><input class='disabled' id='name' name='name' type='text' value="<?= isset($config["name"]) ? $config["name"] : "" ?>">&nbsp;(For email template customization.)<br>
		<label>Admin username:&nbsp;</label><input id='admin_username' name='admin_username' type='text' value="admin" disabled><br>
		<label>Password:&nbsp;</label><input id='admin_password' name='admin_password' type='password' value="<?= isset($config["admin_password"]) ? $config["admin_password"] : "" ?>"><br>
		</fieldset>
		<br>
		<fieldset>
			<legend>SMTP Configuration</legend>
		<label>SMTP Host:&nbsp;</label><input id='host' name='host' type='text' value="<?= isset($config["host"]) ? $config["host"] : "" ?>"><br>
		<label>Port:&nbsp;</label><input id='port' name='port' type='number' value="<?= isset($config["port"]) ? $config["port"] : "" ?>"><br>
		<label>SMTP Secure (ssl/tls):&nbsp;</label><input id='smtp_secure' name='smtp_secure' type='text' value="<?= isset($config["smtp_secure"]) ? $config["smtp_secure"] : "" ?>"><br>
		<label>From(Address):&nbsp;</label><input id='from_address' name='from_address' type='text' value="<?= isset($config["from_address"]) ? $config["from_address"] : "" ?>"><br>
		<label>Username:&nbsp;</label><input id='username' name='username' type='text' value="<?= isset($config["username"]) ? $config["username"] : "" ?>"><br>
		<label>Password:&nbsp;</label><input id='password' name='password' type='password' value="<?= isset($config["password"]) ? $config["password"] : "" ?>"><br>
		</fieldset>
		<br>
		<button type='submit'>Submit</button>
		<button id="testContactForm" type='button'>Test Contact Form</button>
	</form>
	<br>
	<label id='message'><?=$message?></label>
	
	<script>
	$(document).on({
		ajaxStart: function() { $('body').addClass("loading");    },
		 ajaxStop: function() { $('body').removeClass("loading"); }
	});
	
	$(document).ready(function(){
		//alert('foo');
	});
	
	$("#testContactForm").click(function(){
		//alert('foo');
		//~ $.post("contact.php",{
			//~ "email": "prahladyeri@yahoo.com",
			//~ "name": "Prahlad Yeri",
			//~ "subject": "Test contact form filled by Prahlad",
			//~ "body": "Nunquam titilandus",
			//~ }, function(data, status, xhr){
				//~ //alert(data);
				//~ $("#message").text(data);
			//~ });
		var to = prompt("Enter recepient's email address: ");
		if (to=="" || to==undefined) return;

		$.post("/contact.php", {
			"email": "prahladyeri@yahoo.com",
			"name": "CodeIgniter",
			"subject": "This is some cool subject dude.",
			"body": "Hello, World. static-tools is working!",
			}, function(data, status, xhr){
				$("#message").text(data);
			});

	});
	</script>
	
<footer style='position:fixed;left:3px;bottom:3px;'>
	<a class='small' href="https://www.prahladyeri.com">&copy;2016-<?= date("Y") ?> Prahlad Yeri.</a>
	<br>
	<a class='small' href="https://github.com/prahladyeri/static-forms">Project Github.</a>
</footer>
</body>
</html>
