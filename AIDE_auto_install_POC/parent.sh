#!/bin/sh

# サブコマンドを実行
sh ./child.sh &

echo "親の出力".PPID=$PPID, PID=$$

for i in `seq 1 5`; do
        echo "親の出力 ${i}"
            sleep 1
            count=`ps -ef | grep $! | grep -v grep | wc -l`
            if [ $count = 0 ]; then
                 break
            fi
done

if [ ${i} = 5 ]; then
     kill $!
     echo "シェルをkilしたよ。"
else
     echo "シェルが終了したよ。"
fi

# サブコマンドが終わるのを待つ
#wait