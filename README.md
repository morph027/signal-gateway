# TextSecure Gateway

I have already wrote a basic _check_mk_ TextSecure notification plugin. But now, i needed more clients to send messages and don't want to register multiple numbers. So this is a basic gateway which delivers messages via HTTP or SSH.

## Prerequisites

Go and get [janimo's](https://github.com/janimo/textsecure) TextSecure client. Check his wiki on how to get a working binary.

As i'm a lazy bastard, the HTTP gateway potion was a quick&dirty PHP hack for some devices which can't do proper SSH. PHP was already running on one of my devices, so i'd choose it. Basically it just does an ugly system exec, you might also use CGI instead.

## Setup

### TextSecure

Please follow janimo's wiki on how to setup the client properly. You then need to put the binary, the _.config_ and _.storage_ into the _bin_ folder of this project.

## HTTP

### PHP

Just serve the _index.php_ file with a webserver and you should be able to use it. You might want to add some SSL setup and basic authentication to avoid spamming ;)

### CGI

* [Apache2](http://httpd.apache.org/docs/2.2/howto/cgi.html)
* [NGINX](https://www.nginx.com/resources/wiki/start/topics/examples/fcgiwrap/)

## SSH (preferred!)

As SSH adds an authentication and encryption layer to the whole thing, i'm using it with authorized key files. I'd recommend a special user for this, probably best called _textsecure_ or _axolotl_ (the TextSecure protocol, sounds more fancy) or similiar.

## Usage

### HTTP

```
curl --data "from=someone&to=account.from.your.textsecure.address.book.or.phone.number&message=\"this is your message\"" http(s)://yourserver.example.com/textsecure-gateway/index.php
```

### CGI

Just needs a modified URL which points at your previously configured _cgi-bin_ directory. Example could be:

```
curl --data "from=someone&to=account.from.your.textsecure.address.book.or.phone.number&message=\"this is your message\"" http(s)://yourserver.example.com/cgi-bin/textsecure-gateway/bin/textsecure-wrapper
```

### SSH

```
ssh [-i /your/ssh/folder/id_rsa_or_so] user@yourserver /folder/to/textsecure-gateway/bin/textsecure-wrapper --from someone --to account.from.your.textsecure.address.book.or.phone.number --message \"this is your message\"
```
