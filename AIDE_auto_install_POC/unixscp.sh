#!/bin/sh
HOST="192.168.157.148"
USER="root"
PASS="A3I6Yia6!"
TARGET_FILE1="/tmp/test/parent.sh"
TARGET_FILE2="/tmp/test/child.sh"
TARGET_DIR="/tmp"

expect -c "
spawn scp ${TARGET_FILE1} ${USER}@${HOST}:${TARGET_DIR}
expect {
\"Are you sure you want to continue connecting (yes/no)? \" {
send \"yes\r\"
expect \"password:\"
send \"${PASS}\r\"
} \"password:\" {
send \"${PASS}\r\"
}
}
interact
"
expect -c "
spawn scp ${TARGET_FILE2} ${USER}@${HOST}:${TARGET_DIR}
expect {
\"Are you sure you want to continue connecting (yes/no)? \" {
send \"yes\r\"
expect \"password:\"
send \"${PASS}\r\"
} \"password:\" {
send \"${PASS}\r\"
}
}
interact
"