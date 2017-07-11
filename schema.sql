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

insert into config values(
	"John Doe",
	"smtp.example.com",
	22,
	"ssl",
	"someone@example.com",
	"someone",
	"foobar",
	""
);

create table comments(
	id integer primary key,
	url text, -- url of the blog post
	body text,
	name text, -- poster's name
	email text,
	website text,
	created_at date default CURRENT_TIMESTAMP,
	notify_follow_up int default 0,
	notify_new_posts int default 0
);