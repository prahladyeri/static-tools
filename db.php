<?php
/*
 * Tools for static website hosting
 * 
 * @author Prahlad Yeri<prahladyeri@yahoo.com>
 * @date 2016-06-03
 * */
$filename = "db.sqlite3";
$config = array();
$cnt = count(glob($filename));
$dbh = new PDO("sqlite:".$filename) or die("cannot open the database");
//$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, 0);
if ($cnt == 0)
{
	/*$initsql = <<<EOT
	create table config
	(
		name text,
		host TEXT,
		port INT,
		smtp_secure TEXT, --ssl/tls
		from_address TEXT,
		username TEXT,
		password TEXT,
		admin_password text
	);
EOT;*/
	$sql = file_get_contents("schema.sql");
	//print_r($sql);
	//$sth = $dbh->prepare($sql);
	//$sth->execute();
	$dbh->exec($sql);
}
//phpinfo();
//print_r( PDO::getAvailableDrivers());
// if (strlen($initsql)>0) {
	// $sth = $dbh->prepare($initsql);
	// $sth->execute();
	// $sth = $dbh->prepare("insert into config values(?,?,?,?,?,?,?,?);");
	// $sth->execute(array(
		// "John Doe",
		// "smtp.example.com",
		// 22,
		// "ssl",
		// "someone@example.com",
		// "someone",
		// "foobar",
		// "",
	// ));
// }
$config = $dbh->query("select * from config;")->fetch();
//print_r($config);
//print_r("success");

//~ foreach($config as $key=>$val) {
	//~ echo $key . "::" . $val . "<br>";
//~ }
//$dbh
//INSERT INTO CONFIG VALUES("test.smtp.com", 22, "ssl", "prah@yahoo.com", "prah", "prah");
