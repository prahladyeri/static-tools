# static-forms
Light-weight contact forms hosting for static websites

static-forms is a light-weight self-hosted solution for those bloggers who already have a statically hosted solution in place using *Jekyll* or a similar static site generators. They have also setup comments using `disqus` and just need a basic hosting for submitting contact forms.

static-forms is a simple `php` package of around 7kb that accepts `POST` requests from contact forms and emails the data to you. All you need is `php 5.x+` with PDO extension for `sqlite` enabled. And you also need an email account with SMTP sending enabled.

## Installation

Just copy this repository and host it in the root directory. Make sure that the root folder has write access since `static-forms` creates a lightweight sqlite database to store your email configuration. Once installed, open the site in a web-browser to set things up from the Admin screen:

![Admin screen](/StaticFormsAdmin.png)


The Admin screen is a simple one where you put your SMTP server details like host, username, password, etc. Please note that `gmail` requires you to switch on the insecure apps setting in order to work. Once the data is saved, you can test contact forms submission using the test button. If test is successful, you can then keep sending `POST` requests to the below url from your statically hosted website:

`http://<your-url>/contact.php`


## Bugs

If you face any bugs or issues, post them in the issue tracker for this repo.


## Roadmap

The future agenda is to host actual contact forms along with email forwarding feature and also add various other customized form creation features besides this basic one.
