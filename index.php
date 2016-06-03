<?php
/*
 * Contact Form for static websites
 * 
 * @author Prahlad Yeri<prahladyeri@yahoo.com>
 * @date 2016-06-03
 * */
 $version = "1.0.1";
require_once('db.php');
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$config["name"] = $_POST["name"];
	$config["host"] = $_POST["host"];
	$config["port"] = $_POST["port"];
	$config["smtp_secure"] = $_POST["smtp_secure"];
	$config["from_address"] = $_POST["from_address"];
	$config["username"] = $_POST["username"];
	$config["password"] = $_POST["password"];
	
	$dbh->prepare("delete from config;")->execute();
	
	$sth = $dbh->prepare("insert into config values(?,?,?,?,?,?,?);");
	$sth->execute(array(
		$config["name"],
		$config["host"],
		$config["port"],
		$config["smtp_secure"],
		$config["from_address"],
		$config["username"],
		$config["password"],
	));
	
	$message = "Record Saved!";
}
?>
<!DOCTYPE html>
<html lang='en'>
<head>
	<link rel='stylesheet' href='/pure-min-0.6.css'>
	<title>Static Forms v<?=$version?></title>
	<script src="/jquery-1.11.1.min.js"></script>
</head>
<body style='margin-left:20px;'>
	<style>
	.loading #testContactForm
	{
		background-image: url("ajax.gif");
		background-repeat: no-repeat;
		background-position: right;
		padding-right: 25px;
	}
	</style>
	
	<?php
	echo "<h1>Welcome to Static Forms Admin v$version </h1>";
	?>
	<form method="POST" action="">
		<fieldset>
			<legend>SMTP Configuration</legend>
		<label>Admin Name:&nbsp;</label><input id='name' name='name' type='text' value="<?= isset($config["name"]) ? $config["name"] : "" ?>">&nbsp;(For email template customization.)<br>
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
		$.post("/contact.php",{
			"email": "prahladyeri@yahoo.com",
			"name": "Prahlad Yeri",
			"subject": "Test contact form filled by Prahlad",
			"body": "Nunquam titilandus",
			}, function(data, status, xhr){
				//alert(data);
				$("#message").text(data);
			});
	});
	</script>
</body>
</html>
