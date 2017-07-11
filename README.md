# Introduction
`static-tools` is a light-weight web app to host specific services for those who want to otherwise host a static blog instead of going full wordpress. Presently, the supported services are:

1. Contact Forms.
2. Comments Hosting.

## Installation

Just [download](https://github.com/prahladyeri/static-tools/archive/master.zip) this repo and host it on your server. Once installed, open the site in a web-browser to set things up from the Admin screen:

![Admin screen](/StaticFormsAdmin.png)

For admin screen, the username is `admin` and password is "" (blank) by default. The Admin screen is a simple one where you put your SMTP server details like host, username, password, etc. Please note that `gmail` requires you to switch on the insecure apps setting in order to work. Once the data is saved, you can test contact forms submission using the test button. If test is successful, you can then send `POST` requests to the below url from your statically hosted html site:

`http://<your-url>/contact.php`

## Features

- Secure Admin dashboard. Provides screen protection once admin password is entered.
- HTML input sanitization in contact form data.
- Comment hosting.

## Bugs

If you face any bugs or issues, post them in the issue tracker for this repo.

## Roadmap

The future agenda is to make lots of enhancements and host actual contact forms along with email forwarding feature and also add various other customized form creation features besides this basic one. You can provide improvement suggestions through the github bug tracker for this project.
