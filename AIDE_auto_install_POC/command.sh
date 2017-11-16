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
    echo "���łɃC���X�g�[���ς݂ł��B"
    exit 1
elif [ $? -ne 1 ]; then
    echo "��肪����܂��B"
    exit 1
fi

sshpass -p $AI_PASSW ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null root@$AI_IPADR "yum -y install aide" > /dev/null
#echo $?
if [ $? -ne 0 ]; then
    echo "�C���X�g�[���Ɏ��s���܂����B"
    exit 1
else
    echo "�C���X�g�[�����������܂����B"
fi

sshpass -p $AI_PASSW ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null root@$AI_IPADR "cp -p /etc/aide.conf /etc/aide.conf$AI_DAT" > /dev/null
#echo $?
if [ $? -ne 0 ]; then
    echo "�R���t�B�O�t�@�C���̃R�s�[�Ɏ��s���܂����B"
    exit 1
fi

sshpass -p 'A3I6Yia6!' ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null root@$AI_IPADR "sed -i -e 's/^\\/boot/\\!\\/boot/g' -e 's/^\\/bin/\\!\\/bin/g' -e 's/^\\/sbin/\\!\\/sbin/g' -e 's/^\\/lib/\\!\\/lib/g' -e 's/^\\/lib64/\\!\\/lib64/g' -e 's/^\\/opt/\\!\\/opt/g' -e 's/^\\/root/\\!\\/root/g' /etc/aide.conf" > /dev/null
#echo $?
if [ $? -ne 0 ]; then
    echo "�R���t�B�O�t�@�C���̏C���Ɏ��s���܂����B"
    exit 1
fi

echo "AIDE�̃C���X�g�[���������������܂����B"