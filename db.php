<?php
/*
 * Contact Form for static websites
 * 
 * @author Prahlad Yeri<prahladyeri@yahoo.com>
 * @date 2016-06-03
 * */
$filename = "forms.db";
$initsql = "";
$config = array();
if (count(glob($filename)) == 0) 
{
	$initsql = <<<EOT
	create table config
	(
		name text,
		host TEXT,
		port INT,
		smtp_secure TEXT, --ssl/tls
		from_address TEXT,
		username TEXT,
		password TEXT
	);
EOT;
}
//phpinfo();
//print_r( PDO::getAvailableDrivers());
$dbh = new PDO("sqlite:".$filename) or die("cannot open the database");
if (strlen($initsql)>0) {
	$sth = $dbh->prepare($initsql);
	$sth->execute();
	$sth = $dbh->prepare("insert into config values(?,?,?,?,?,?,?);");
	$sth->execute(array(
		"John Doe",
		"smtp.example.com",
		22,
		"ssl",
		"someone@example.com",
		"someone",
		"foobar"
	));
}
$config = $dbh->query("select * from config")->fetch();
//print_r($config);

//~ foreach($config as $key=>$val) {
	//~ echo $key . "::" . $val . "<br>";
//~ }
//$dbh
//INSERT INTO CONFIG VALUES("test.smtp.com", 22, "ssl", "prah@yahoo.com", "prah", "prah");
