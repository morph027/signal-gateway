# Signal (former TextSecure) Gateway

I have already wrote a basic _check_mk_ Signal notification plugin. But now, i needed more clients to send messages and don't want to register multiple numbers. So this is a basic gateway which delivers messages via SSH.

## Prerequisites

Go and get [janimo's](https://github.com/janimo/signal) Signal client. Check his wiki on how to get a working binary.

## Setup

### SSH

As SSH adds an authentication and encryption layer to the whole thing, i'm using it with authorized key files. I'd recommend a special user for this, probably best called _signal_ or _axolotl_ (the Signal protocol, sounds more fancy) or similiar.

```
useradd -s /bin/bash -m -d /opt/signal-gateway axolotl
```

Now, create the _authorized\_keys_ file:

```
su - axolotl
mkdir -m 700 .ssh
(umask 077; touch .ssh/authorized_keys)
```

Now you need to add the public keys of the systems/users using this gateway.

### Gateway

As the newly created user, clone this project:

```
su - axolotl
git clone https://github.com/morph027/signal-gateway
```

### Signal

Please follow janimo's wiki on how to setup the client properly. You then need to put the binary, the _.config_ and _.storage_ into the _bin_ folder of this project. Rename ```textsecure``` to ```signal```


## Usage

### SSH

```
ssh [-i /your/ssh/folder/id_rsa_or_so] user@yourserver /folder/to/signal-gateway/bin/signal-wrapper --from someone --to account.from.your.signal.address.book.or.phone.number --message \"this is your message\"
```

## Group Chat

You need to set the hexid (see _.storage/groups/${hexid}_) of the group as ```--to``` and ```--group true```.

## Queuing

To add messages to s simple queue (in case of internet failures), you can pass ```--queue```. Basically, the messages will be added to a text file which will then be read by a script later (e.g. fired by cron).

Cron:  ```crontab -u user -e``` and then add ```*/5 * * * * /folder/to/signal-gateway/bin/signal-resend```
