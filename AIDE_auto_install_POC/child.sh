#!/bin/sh

# �q�̏���
echo "�q�̏o��".PPID=$PPID, PID=$$
echo $$ > child_pid

for i in `seq 1 5`; do
        echo "�q�̏o�� ${i}"
            sleep 0.5
done

echo "�q�V�F�����I��������B"