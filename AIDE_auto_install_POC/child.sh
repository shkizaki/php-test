#!/bin/sh

# 子の処理
echo "子の出力".PPID=$PPID, PID=$$
echo $$ > child_pid

for i in `seq 1 5`; do
        echo "子の出力 ${i}"
            sleep 0.5
done

echo "子シェルが終了したよ。"