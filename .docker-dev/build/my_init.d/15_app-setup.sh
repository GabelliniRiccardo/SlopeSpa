#!/usr/bin/env bash

# Start postfix (without runit as it seems a lot easier to do it this way, plus it handles chroot)
/etc/init.d/postfix start
