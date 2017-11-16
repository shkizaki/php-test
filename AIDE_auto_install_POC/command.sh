#!/bin/sh

PROG="aide"
CONFIL="/etc/aide.conf"
AI_IPADR=$1
AI_DAT=`date "+%Y%m%d"`
AI_PASSW=$2
echo $AI_IPADR
echo $AI_PASSW

sshpass -p $AI_PASSW ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null root@$AI_IPADR "yum list installed | grep aide" > /dev/null
#echo $?
if [ $? -eq 0 ]; then
    echo "すでにインストール済みです。"
    exit 1
elif [ $? -ne 1 ]; then
    echo "問題があります。"
    exit 1
fi

sshpass -p $AI_PASSW ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null root@$AI_IPADR "yum -y install aide" > /dev/null
#echo $?
if [ $? -ne 0 ]; then
    echo "インストールに失敗しました。"
    exit 1
else
    echo "インストールが成功しました。"
fi

sshpass -p $AI_PASSW ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null root@$AI_IPADR "cp -p /etc/aide.conf /etc/aide.conf$AI_DAT" > /dev/null
#echo $?
if [ $? -ne 0 ]; then
    echo "コンフィグファイルのコピーに失敗しました。"
    exit 1
fi

sshpass -p 'A3I6Yia6!' ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null root@$AI_IPADR "sed -i -e 's/^\\/boot/\\!\\/boot/g' -e 's/^\\/bin/\\!\\/bin/g' -e 's/^\\/sbin/\\!\\/sbin/g' -e 's/^\\/lib/\\!\\/lib/g' -e 's/^\\/lib64/\\!\\/lib64/g' -e 's/^\\/opt/\\!\\/opt/g' -e 's/^\\/root/\\!\\/root/g' /etc/aide.conf" > /dev/null
#echo $?
if [ $? -ne 0 ]; then
    echo "コンフィグファイルの修正に失敗しました。"
    exit 1
fi

echo "AIDEのインストール処理が完了しました。"