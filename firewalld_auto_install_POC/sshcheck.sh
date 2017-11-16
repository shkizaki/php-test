#!/bin/sh
sshpass -p $2 ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null root@$1
