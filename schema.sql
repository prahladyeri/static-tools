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
	url text, 
	body text, --message
	name text, --author->name
	email text, --author->email
	website text, 
	created_at date default CURRENT_TIMESTAMP, --createdAt
	notify_follow_up int default 0,
	notify_new_posts int default 0
);