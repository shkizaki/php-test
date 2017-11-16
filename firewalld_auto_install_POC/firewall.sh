#!/bin/sh


IPADDR=$1
PASSWD=$2
PORTS=$3
#対象ホストの応答確認-Ping
ping -c 4 $1
if [ "$?" -ne 0 ]; then
  echo "PLEASE CHECK IP ADDRESS." >
  exit 1
fi

#portチェック-nmap
nmap -p 22 $1 | grep "closed" |wc -l
if [ $(nmap -p 22 $1 | egrep "closed|filtered" |wc -l) -ne 0 ]; then
  echo "PLEASE OPEN SSH PORT#22."
  exit 1
fi

#ログイン-sshpass/ssh OSバージョン確認-uname
sshpass -p $2 ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null root@$1 hostname ;date
#分岐処理1(el7)(el6,ubuntu)
if [$(sshpass -p $2 ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null root@$1 uname -r |sed -e 's/^.*el\([0-9]*\).*$/\1/') -eq 7 ]; then
  echo "check firewalld"
else
  echo "check iptables"



#firewalldの処理
#インストール有無確認
sshpass -p $2 ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null root@$1 rpm -q firewalld
if [ $? -ne 0 ]; then
	echo "firewalldをインストールします。"
	INSTALL-FIREWALLD #なければインストールして起動

##########################
function INSTALL-FIREWALLD() {
sshpass -p $2 ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null root@$1 yum -y install firewalld
sshpass -p $2 ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null root@$1 systemctl enable firewalld
sshpass -p $2 ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null root@$1 systemctl start firewalld
}
##########################

fi


#状況確認停止していたら起動
sshpass -p $2 ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null root@$1 systemctl status firewalld

if [ $? -ne 0 ]; then
sshpass -p $2 ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null root@$1 systemctl start firewalld
sshpass -p $2 ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null root@$1 systemctl enable firewalld




#ポート開ける
firewall-cmd --add-port=$1/tcp --permanent
firewall-cmd --reload

###########テキストファイルの内容を一行ずつ処理###############
###########入力されたポート番号をport.txtに出力###############
###########port.txtにポート番号を追記させていき、それを読む###############
#!/bin/sh

function SSHLOGIN() {
  #statements
  sshpass -p $2 ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null root@$1
}

cat port.txt | while read line
do
  $SSHLOGIN firewall-cmd --add-port=$line/tcp --permanent
done
##########################


#iptablesの処理
#インストール確認/なければインストール
#現在の設定確認
#サービス開ける
#ポート開ける
