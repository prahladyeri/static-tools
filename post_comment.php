<?php
/*
 * Comment hosting for static websites
 * 
 * @author Prahlad Yeri<prahladyeri@yahoo.com>
 * @date 2017-07-11
 * */

//Implement CORS (Cross origin resource sharing)
switch ($_SERVER['HTTP_ORIGIN']) 
{
    case 'http://prahladyeri.com': case 'https://prahladyeri.com':
    case 'http://www.prahladyeri.com': case 'https://www.prahladyeri.com':
    header('Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN']);
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    header('Access-Control-Max-Age: 1000');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    break;
}
 
require_once("db.php");
// require_once('class.phpmailer.php');
// require_once('class.smtp.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$url = htmlspecialchars($_POST["url"]);
	$body =  htmlspecialchars($_POST["body"]);
	$name = htmlspecialchars($_POST["name"]);
	$email = htmlspecialchars($_POST["email"]);
	$website = htmlspecialchars($_POST["website"]);
	//$created_at = htmlspecialchars($_POST["created_at"]);
	$notify_follow_up = htmlspecialchars($_POST["notify_follow_up"]);
	$notify_new_posts = htmlspecialchars($_POST["notify_new_posts"]);
	
	$sth = $dbh->prepare("insert into comments(url,body,name,email,website,notify_follow_up,notify_new_posts) values(?,?,?,?,?,?,?);");
	$sth->execute(array(
		$url,
		$body,
		$name,
		$email,
		$website,
		$notify_follow_up,
		$notify_new_posts,
	));
	echo "Success!";

}
else {
	//GET method
}