#!/bin/sh
nmap -p 22 $1 | grep "closed" |wc -l　> /dev/null 2>&1
if [ $(nmap -p 22 $1 | egrep "closed|filtered" |wc -l) -ne 0 ]; then
  echo "エラーが発生しました。SSHポートが開いていません。"
  exit 1
fi
