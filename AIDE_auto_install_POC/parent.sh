#!/bin/sh

# �T�u�R�}���h�����s
sh ./child.sh &

echo "�e�̏o��".PPID=$PPID, PID=$$

for i in `seq 1 5`; do
        echo "�e�̏o�� ${i}"
            sleep 1
            count=`ps -ef | grep $! | grep -v grep | wc -l`
            if [ $count = 0 ]; then
                 break
            fi
done

if [ ${i} = 5 ]; then
     kill $!
     echo "�V�F����kil������B"
else
     echo "�V�F�����I��������B"
fi

# �T�u�R�}���h���I���̂�҂�
#wait