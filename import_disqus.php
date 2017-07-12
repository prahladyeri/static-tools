<?php
/*
 * Tools for static website hosting
 * 
 * @author Prahlad Yeri<prahladyeri@yahoo.com>
 * @date 2017-07-12
 * */
require_once('db.php');

function find_url($root, $thid) {
	foreach($root->thread as $thread) {
		$curr_id =  $thread->attributes("dsq", true)[0];
		if (strcmp($thid,$curr_id) === 0) {
			$url = $thread->id;
			//echo "comparing:" , $curr_id, " ",$thid, "\n";
			//print("url:".($url=="")."\n");
			return $url;
		}
	}
	return null;
}

if (php_sapi_name() == "cli") {
	if (count($argv) < 2) {
		print("Incorrect arguments. Provide path to file\n");
		exit;
	}
	$xmlstr = file_get_contents($argv[1]);
	
	$root = new SimpleXMLElement($xmlstr);
	$posts = $root->post;
	foreach($posts as $post) {
			$thid = "";
			foreach($post->thread->attributes("dsq",true) as $a=>$b) {
				$thid = $b;
				break;
			}
			//find_url($root, $thid);
			$url = find_url($root, $thid);
			if ($url != null)
			// echo "id: " . $post->id ."\n"
			// ."message: ".strip_tags($post->message)."\n"
			// ."createdAt: ".$post->createdAt."\n"
			// ."author.email: ".$post->author->email."\n"
			// ."author.name: ".$post->author->name."\n"
			// ."thread: ".$thid."\n"
			// ."url: ".$url."\n"
			// . "\n";
			
			//insert comment in database
			$sql = "delete from comments where url=?";
			$sth = $dbh->prepare($sql);
			$sth->execute(array($url));
			
			$values = array(
			"body"=>strip_tags($post->message),
			"name"=>$post->author->name,
			"email"=>$post->author->email,
			//"created_at"=>date("Y-m-dTH:i:sZ", $post->created_at),
			//"created_at"=>date_create($post->createdAt),
			"created_at"=>$post->createdAt,
			"url"=>$url,
			);
			
			
			$cols = implode(",", array_keys($values));
			$placeholders = array();
			for ($i=0;$i<count(array_keys($values));$i++) {
				$placeholders[] = "?";
			}
			$placeholders = implode(",", $placeholders);
			$sql = "insert into comments(".$cols.") values(".$placeholders.")";
			//echo $post->created_at;
			//echo date_create( $post->createdAt);
			$sth = $dbh->prepare($sql);
			$sth->execute(array_values($values));
			echo "inserted record.\n";
	}
}
//echo $xmlstr;